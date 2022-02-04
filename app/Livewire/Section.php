<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

abstract class Section extends Component
{
    use WithPagination;

    public mixed $editingModel = null;

    public ?array $confirmation = null;

    protected abstract function getModelClass(): string;

    protected abstract function getFormViewName(): string;

    protected abstract function getTableHeaders(): array;

    protected function getTableCellActions(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [
            [
                'text'      => __('pages.tables.actions.edit'),
                'color'     => 'blue',
                'icon'      => 'edit',
                'handler'   => 'edit',
            ],
            [
                'text'      => __('pages.tables.actions.delete'),
                'color'     => 'red',
                'icon'      => 'delete',
                'handler'   => 'delete',
                'confirm'   => [
                    'type'      => 'warning',
                    'title'     => function ($id) {
                        return __('pages.confirm_dialog.delete_title');
                    },
                    'message'   => function ($id) {
                        $model = ($this->getModelClass())::findOrFail($id);
                        $name = $model->{$this->getModelTitleKey()};

                        return __('pages.confirm_dialog.delete_message', ['name' => $name]);
                    },
                ],
            ],
        ];
    }

    protected function getModelTitleKey(): ?string
    {
        return null;
    }

    protected function filterResults(Builder $query): Builder
    {
        return $query;
    }

    public function booted(): void
    {
        abort_if(!auth()->check(), 401);
    }

    public function render(): View
    {
        $query = $this->filterResults(($this->getModelClass())::query());

        return view('layouts.section', [
            'models' => $query->paginate(10),
        ]);
    }

    protected function getListeners(): array
    {
        $section = class_basename($this->getModelClass());
        $section = Str::plural($section);
        $section = Str::studly($section);

        $listeners = [
            "load$section"  => 'onLoadSection',
            'confirmOk'     => 'confirmOk',
            'confirmCancel' => 'confirmCancel',
        ];

        return $listeners;
    }

    protected function updated(string $key, mixed $value): void
    {
        $this->validateOnly($key);
    }

    protected function modelChanged(?Model $model): void
    {}

    public function create(): void
    {
        $this->clearValidation();
        $this->editingModel = new ($this->getModelClass());
        $this->modelChanged($this->editingModel);
    }

    public function edit(int $id): void
    {
        $this->clearValidation();
        $this->editingModel = ($this->getModelClass())::findOrFail($id);
        $this->modelChanged($this->editingModel);
    }

    public function delete(int $id): void
    {
        $domain = ($this->getModelClass())::findOrFail($id);

        try {
            $domain->delete();
        } catch (QueryException $ex) {
            if (strpos($ex->getMessage(), 'Integrity constraint violation') !== false) {
                $this->emit('alert', 'error', __('pages.errors.integrity_title'), __('pages.errors.integrity_message'));
            } else {
                throw $ex;
            }
        }
    }

    public function confirm(string $type, string $title, string $message, string $handler, int $id): void
    {
        $this->confirmation = compact('type', 'title', 'message', 'handler', 'id');
    }

    public function confirmOk(): void
    {
        $handler = $this->confirmation['handler'];
        $id = $this->confirmation['id'];

        if ($this->methodIsPublicAndNotDefinedOnBaseClass($handler)) {
            $this->callMethod($handler, [$id]);
        }

        $this->confirmation = null;
    }

    public function confirmCancel(): void
    {
        $this->confirmation = null;
    }

    public function goBack(): void
    {
        $this->editingModel = null;
        $this->modelChanged(null);
    }

    protected function beforeSave(): void
    {}

    public function save(): void
    {
        $this->validate();

        $this->beforeSave();

        $this->editingModel->save();

        /*foreach ($this->editingModel->getRelations() as $relation) {
            foreach ($relation as $model) {
                if ($model->isDirty()) {
                    $model->save();
                }
            }
        }*/

        $this->goBack();
    }

    public function onLoadSection(array $payload): void
    {
        $this->editingModel = null;
        $this->modelChanged(null);
    }

    public function getAction(array $action, int $id): string
    {
        $handler = $action['handler'];

        if (isset($action['confirm'])) {
            $type = $action['confirm']['type'] ?? 'default';
            $title = is_callable($action['confirm']['title']) ? $action['confirm']['title']($id) : $action['confirm']['title'];
            $message = is_callable($action['confirm']['message']) ? $action['confirm']['message']($id) : $action['confirm']['message'];

            return "confirm('$type', '$title', '$message', '$handler', $id)";
        }

        return "$handler($id)";
    }
}
