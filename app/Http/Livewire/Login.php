<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Login extends Component
{
    public string $name = '';

    public string $password = '';

    public string $errorMessage = '';

    public function render(): View
    {
        return view('livewire.login');
    }

    public function login(): void
    {
        $this->errorMessage = '';

        $credentials = [
            'name'      => $this->name,
            'password'  => $this->password,
        ];

        if (!auth()->attempt($credentials, true)) {
            $this->errorMessage = trans('pages.login.login_error');
        } else {
            $this->emit('logged', $this->name);
        }
    }
}
