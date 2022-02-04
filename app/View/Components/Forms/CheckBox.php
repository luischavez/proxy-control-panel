<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CheckBox extends Component
{
    public string $label;

    public string $model;

    public ?string $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, string $model, ?string $id = null)
    {
        $this->label = $label;
        $this->model = $model;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View
    {
        return view('components.forms.check-box');
    }
}
