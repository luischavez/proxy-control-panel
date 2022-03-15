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

    public function delete(int $id): void
    {
        $subdomain = Subdomain::findOrFail($id);
        foreach ($subdomain->locations as $location) {
            $location->delete();
        }
        parent::delete($id);
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
            $location['path'] = empty($location['path']) ? '/' : $location['path'];
            $location['type'] = empty($location['type']) ? 'proxy' : $location['type'];
            $location['subtype'] = empty($location['subtype']) ? 'http' : $location['subtype'];
            $location['target'] = empty($location['target']) ? '0.0.0.0:1234' : $location['target'];
            $location['connect_timeout'] = empty($location['connect_timeout']) ? 60 : $location['connect_timeout'];
            $location['send_timeout'] = empty($location['send_timeout']) ? 60 : $location['send_timeout'];
            $location['read_timeout'] = empty($location['read_timeout']) ? 60 : $location['read_timeout'];
            $location['enable_x_headers'] = $location['enable_x_headers'] ? true : $location['enable_x_headers'];

            $location = $this->editingModel->locations()->create($location);
        }

        $this->editingModel->name = strtolower($this->editingModel->name);
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
        $query->orderBy('name');

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
                'regex:/^[a-z][a-z0-9]+$/',
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
            'editingModel.locations.*.connect_timeout'  => 'integer',
            'editingModel.locations.*.send_timeout'     => 'integer',
            'editingModel.locations.*.read_timeout'     => 'integer',
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

        $this->locations[($size + 1) * -1] = $location;
    }

    public function removeLocation(int $index): void
    {
        unset($this->locations[$index]);
    }
}
