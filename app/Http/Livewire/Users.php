<?php

namespace App\Http\Livewire;

use App\Livewire\Section;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Section
{
    public string $password = '';

    protected function beforeSave(): void
    {
        abort_if(auth()->user()?->type !== 'superadmin' && $this->editingModel->type === 'superadmin', 401);

        $this->editingModel->type = $this->editingModel?->type === 'superadmin' ? 'superadmin' : 'admin';

        $this->password = trim($this->password);

        if (!empty($this->password)) {
            $this->editingModel->password = Hash::make($this->password);
        }
    }

    protected function getModelClass(): string
    {
        return User::class;
    }

    protected function getFormViewName(): string
    {
        return 'forms.user';
    }

    protected function getTableHeaders(): array
    {
        return [
            'name' => __('pages.users.table.name'),
            'type' => __('pages.users.table.type'),
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
            'editingModel.name' => 'required|alpha_num|min:5|unique:users,name',
            'password'          => 'nullable|alpha_num|min:5',
        ];

        if ($this->editingModel?->id === null) {
            $rules['password'] = 'required|alpha_num|min:5';
        } else {
            $rules['editingModel.name'] = $rules['editingModel.name'].','.$this->editingModel->id;
        }

        return $rules;
    }
}
