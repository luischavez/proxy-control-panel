<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextInput extends Component
{
    public string $label;

    public string $model;

    public bool $required = false;

    public string $type;

    public ?string $id = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, string $model, bool $required = false, string $type = 'text', string $id = null)
    {
        $this->label = $label;
        $this->model = $model;
        $this->required = $required;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View
    {
        return view('components.forms.text-input');
    }
}
