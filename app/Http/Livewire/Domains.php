<?php

namespace App\Http\Livewire;

use App\Livewire\Section;
use App\Models\Domain;

class Domains extends Section
{
    protected function getModelClass(): string
    {
        return Domain::class;
    }

    protected function getFormViewName(): string
    {
        return 'forms.domain';
    }

    protected function getTableHeaders(): array
    {
        return [
            'name'              => __('pages.domains.table.domain'),
            'subdomain_count'   =>__('pages.domains.table.subdomain_count'),
        ];
    }

    protected function getTableCellActions(): array
    {
        return [
            'subdomain_count' => 'goToSubdomains',
        ];
    }

    protected function getModelTitleKey(): ?string
    {
        return 'name';
    }

    protected function getRules(): array
    {
        $rules = [
            'editingModel.name'                => 'required|string|max:128|unique:domains,name',
            'editingModel.enable_ssl'          => 'nullable|boolean',
            'editingModel.force_https'         => 'required_unless:editingModel.enable_ssl,true|boolean',
            'editingModel.ssl_cert_location'   => 'required_if:editingModel.enable_ssl,true',
            'editingModel.ssl_key_location'    => 'required_if:editingModel.enable_ssl,true',
        ];

        if ($this->editingModel?->id !== null) {
            $rules['editingModel.name'] .= ','.$this->editingModel->id;
        }

        return $rules;
    }

    public function goToSubdomains(int $id): void
    {
        $this->emit('changeSection', 'subdomains', [
            'domain' => $id,
        ]);
    }

    protected function beforeSave(): void
    {
        $this->editingModel->force_https = $this->editingModel->force_https === null ? false : $this->editingModel->force_https;
        $this->editingModel->enable_ssl = $this->editingModel->enable_ssl === null ? false : $this->editingModel->enable_ssl;
    }
}
