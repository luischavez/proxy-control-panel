<?php

namespace App\View\Components;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public array $headers;

    public Paginator $paginator;

    public array $cellActions;
    public array $actions;

    public array $icons = [
        'edit'      => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>',
        'delete'    => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $headers, Paginator $paginator, array $cellActions = [], array $actions = [])
    {
        $this->headers = $headers;
        $this->paginator = $paginator;
        $this->cellActions = $cellActions;
        $this->actions = $actions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View
    {
        return view('components.table');
    }
}
