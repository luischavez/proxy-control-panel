<?php

namespace App\Http\Livewire;

use App\Models\ChangeLog;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Logs extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.logs', [
            'logs' => ChangeLog::orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
