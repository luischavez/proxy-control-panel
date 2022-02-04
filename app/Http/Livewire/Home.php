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

            foreach ($domains as $domain) {
                foreach ($domain->subdomains as $subdomain) {
                    if ($subdomain->locations->count() === 0) {
                        continue;
                    }

                    if ($domain->enable_ssl
                        && (empty($domain->ssl_cert_location) || empty($domain->ssl_key_location))
                        && !File::exists($letsEncryptPath."/{$subdomain->name}.{$domain->name}/fullchain.pem")) {
                        exec("sudo generate-cert-subdomain.sh {$domain->name} {$subdomain->name}", $certOutput, $certResult);
                        sleep(2);
                    }

                    $servers[$subdomain->name.'.'.$domain->name] = view('nginx.server', compact('subdomain'))->render();
                }
            }

            $configPath = config('app.nginx_config_path');

            $files = File::files($configPath);
            foreach ($files as $file) {
                File::delete($file->getPath());
            }

            foreach ($servers as $name => $server) {
                file_put_contents("$configPath/$name", $server);
            }

            exec('sudo nginx -t', $checkOutput, $checkResult);
            exec('sudo service nginx -s reload', $serviceOutput, $serviceResult);

            $this->emit('alert', 'success', __('pages.success.generated_title'), __('pages.success.generated_message'));
        } catch (Throwable $ex) {
            Log::error($ex->getMessage());
            $this->emit('alert', 'error', __('pages.errors.generated_title'), __('pages.errors.generated_message'));
        }
    }
}
