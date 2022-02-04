<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class Panel extends Component
{
    public string $section = 'home';

    public array $payload = [];

    public array $alerts = [];

    protected array $sections = [
        'home',
        'domains',
        'subdomains',
        'users',
        'logs',
        'configuration',
    ];

    protected $listeners = [
        'changeSection' => 'changeSection',
        'alert'         => 'onAlert',
        'closeAlert'    => 'onCloseAlert',
    ];

    public function booted(): void
    {
        abort_if(!auth()->check(), 401);
    }

    public function render(): View
    {
        return view('livewire.panel');
    }

    public function logout(): void
    {
        auth()->logout();
        $this->emit('logout');
    }

    public function changeSection(string $section, array $payload = []): void
    {
        abort_if(!in_array($section, $this->sections), 500);

        $this->section = $section;

        $section = Str::studly($section);
        $this->emit("load$section", $payload);
    }

    public function onAlert(string $type, string $title, string $message): void
    {
        $tag = Str::random(10);
        $this->alerts[$tag] = compact('tag', 'type', 'title', 'message');
    }

    public function onCloseAlert(string $tag): void
    {
        if (isset($this->alerts[$tag])) {
            unset($this->alerts[$tag]);
        }
    }
}
