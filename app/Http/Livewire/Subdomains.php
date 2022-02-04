<?php

namespace App\Http\Livewire;

use App\Livewire\Section;
use App\Models\Domain;
use App\Models\Subdomain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Subdomains extends Section
{
    public ?Domain $domain = null;

    public array $domains = [];
    public array $locations = [];

    public function booted(): void
    {
        $this->domains = Domain::pluck('name', 'id')->toArray();
    }

    protected function modelChanged(?Model $model): void
    {
        $this->locations = [];

        if ($model) {
            foreach ($model->locations as $location) {
                $this->locations[$location->id] = $location->toArray();
            }
        }
    }

    protected function beforeSave(): void
    {
        if ($this->editingModel?->id === null) {
            unset($this->editingModel->locations);
            return;
        }

        $newLocations = $this->locations;
        foreach ($this->editingModel->locations as $location) {
            if (!isset($newLocations[$location->id])) {
                $location->delete();
            } else {
                $location->fill($newLocations[$location->id]);
                $location->save();
                unset($newLocations[$location->id]);
            }
        }

        foreach ($newLocations as $location) {
            $location = $this->editingModel->locations()->create($location);
        }
    }

    public function onLoadSection(array $payload): void
    {
        parent::onLoadSection($payload);
        $this->domain = isset($payload['domain']) ? Domain::findOrFail($payload['domain']) : null;
    }

    protected function filterResults(Builder $query): Builder
    {
        if ($this->domain) {
            $query->whereDomainId($this->domain->id);
        }

        $query->orderBy('domain_id');

        return $query;
    }

    protected function getModelClass(): string
    {
        return Subdomain::class;
    }

    protected function getFormViewName(): string
    {
        return 'forms.subdomain';
    }

    protected function getTableHeaders(): array
    {
        return [
            'name'          => __('pages.subdomains.table.subdomain'),
            'domain.name'   => __('pages.subdomains.table.domain')
        ];
    }

    protected function getTableCellActions(): array
    {
        return [];
    }

    protected function getModelTitleKey(): ?string
    {
        return 'name';
    }

    protected function getRules(): array
    {
        $rules = [
            'editingModel.name'                         => [
                'required',
                'string',
                'max:128',
                Rule::unique('subdomains', 'name')->where(function ($query) {
                    if ($this->editingModel) {
                        $query->where('domain_id', $this->editingModel->domain_id)
                            ->where('id', '<>', $this->editingModel->id);
                    }

                    return $query;
                })
            ],
            'editingModel.locations.*.path'             => 'required',
            'editingModel.locations.*.type'             => 'required',
            'editingModel.locations.*.subtype'          => 'nullable',
            'editingModel.locations.*.target'           => 'required',
            'editingModel.locations.*.connect_timeout'  => 'int',
            'editingModel.locations.*.send_timeout'     => 'int',
            'editingModel.locations.*.read_timeout'     => 'int',
            'editingModel.locations.*.enable_x_headers' => 'boolean',
        ];

        if ($this->editingModel?->id === null) {
            $rules['editingModel.domain_id'] = 'required|exists:domains,id';
        }

        return $rules;
    }

    public function newLocation(): void
    {
        $location = [
            'path'              => '/change_this',
            'type'              => 'proxy',
            'subtype'           => 'http',
            'target'            => '0.0.0.0:1234',
            'connect_timeout'   => 60,
            'send_timeout'      => 60,
            'read_timeout'      => 60,
            'enable_x_headers'  => true,
        ];

        $size = count($this->locations);

        $this->locations[1000 + $size] = $location;
    }

    public function removeLocation(int $index): void
    {
        unset($this->locations[$index]);
    }
}
