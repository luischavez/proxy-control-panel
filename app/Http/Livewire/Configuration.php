<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Configuration extends Component
{
    public string $password = '';

    public string $password_confirmation = '';

    public string $current_password = '';

    protected $rules = [
        'password'              => 'required|confirmed|alpha_num|min:5',
        'password_confirmation' => 'required',
        'current_password'      => 'required',
    ];

    public function booted(): void
    {
        abort_if(!auth()->check(), 401);
    }

    public function updated(string $key, mixed $value): void
    {
        $this->validate();
    }

    public function render(): View
    {
        return view('livewire.configuration');
    }

    public function save(): void
    {
        $this->validate();

        $user = auth()->user();

        if (Hash::check($this->current_password, $user->password)) {
            $newPassword = Hash::make($this->password);
            $user->password = $newPassword;
            $user->save();

            $this->emit('alert', 'success', __('pages.success.password_changed_title'), __('pages.success.password_changed_message'));
        } else {
            $this->emit('alert', 'error', __('pages.errors.wrong_password_title'), __('pages.errors.wrong_password_message'));
        }
    }
}
