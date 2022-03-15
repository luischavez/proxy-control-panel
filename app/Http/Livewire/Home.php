<?php

namespace App\Http\Livewire;

use App\Models\Domain;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class Home extends Component
{
    public function booted(): void
    {
        abort_if(!auth()->check(), 401);
    }

    public function render(): View
    {
        return view('livewire.home');
    }

    public function applyChanges(): void
    {
        try {
            $domains = Domain::all();

            $servers = [];

            $letsEncryptPath = config('app.letsencrypt_cert_path');

            $errors = [];

            foreach ($domains as $domain) {
                if (
                    $domain->enable_ssl
                    && (empty($domain->ssl_cert_location) || empty($domain->ssl_key_location))
                    && !File::exists($domain->ssl_cert_location)
                    && !File::exists($domain->ssl_key_location)
                ) {
                    $errors[] = "cert not found $domain->name";
                }

                foreach ($domain->subdomains as $subdomain) {
                    if ($subdomain->locations->count() === 0) {
                        continue;
                    }

                    $servers[$subdomain->name . '.' . $domain->name] = view('nginx.server', compact('subdomain'))->render();
                }
            }

            $configPath = config('app.nginx_config_path');

            $files = File::files($configPath);
            foreach ($files as $file) {
                File::delete($file->getPath());
            }

            foreach ($servers as $name => $server) {
                file_put_contents("$configPath/$name", $server);

                exec('sudo nginx -t', $checkOutput, $checkResult);
                if ($checkResult != 0) {
                    $errors[] = "Error in configuration: $name";
                    File::delete("$configPath/$name");
                }
            }

            exec('sudo nginx -t', $checkOutput, $checkResult);
            if ($checkResult != 0) {
                $errors[] = $checkOutput;
            } else {
                exec('sudo service nginx reload', $serviceOutput, $serviceResult);
                $this->emit('alert', 'success', __('pages.success.generated_title'), __('pages.success.generated_message'));
            }

            if (!empty($errors)) {
                $errors = implode("<br>", $errors);
                Log::error($errors);
                $this->emit('alert', 'error', __('pages.errors.generated_title'), $errors);
            }
        } catch (Throwable $ex) {
            Log::error($ex->getMessage());
            $this->emit('alert', 'error', __('pages.errors.generated_title'), __('pages.errors.generated_message'));
        }
    }
}
