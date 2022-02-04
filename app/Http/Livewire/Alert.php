<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Alert extends Component
{
    public string $tag;

    public string $type;

    public string $title;

    public string $message;

    public function render(): View
    {
        return view('livewire.alert');
    }

    public function close(): void
    {
        $this->emit('closeAlert', $this->tag);
    }
}
