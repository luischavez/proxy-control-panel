<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Action extends Component
{
    public string $color;

    public string $handler;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $color, string $handler)
    {
        $this->color = $color;
        $this->handler = $handler;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View
    {
        return view('components.forms.action');
    }
}
