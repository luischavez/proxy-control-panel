<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class App extends Component
{
    public string $username = '';

    protected $listeners = [
        'logged' => 'onUserLogged',
        'logout' => 'onUserLogout',
    ];

    public function mount(): void
    {
        $this->username = auth()->user()?->username ?? '';
    }

    public function render(): View
    {
        return view('livewire.app');
    }

    public function onUserLogged(string $username): void
    {
        abort_if(auth()->user() === null, 500);

        $this->username = auth()->user()->name;
    }

    public function onUserLogout(): void
    {
        $this->username = '';
    }
}
