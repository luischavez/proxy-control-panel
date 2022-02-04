<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $label;

    public string $model;

    public bool $required = false;

    public array $options;

    public ?string $id = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, string $model, bool $required = false, array $options = [], string $id = null)
    {
        $this->label = $label;
        $this->model = $model;
        $this->required = $required;
        $this->options = $options;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View
    {
        return view('components.forms.select');
    }
}
