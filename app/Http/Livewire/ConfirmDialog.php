<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ConfirmDialog extends Component
{
    public string $type;

    public string $title;

    public string $message;

    public function render(): View
    {
        return view('livewire.confirm-dialog');
    }

    public function ok(): void
    {
        $this->emit('confirmOk');
    }

    public function cancel(): void
    {
        $this->emit('confirmCancel');
    }
}
