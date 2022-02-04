<x-forms.text-input :label="__('pages.users.form.name')" model="editingModel.name" :required="true" />
<x-forms.text-input :label="__('pages.users.form.password')" model="password" type="password" :required="$editingModel?->id === null" />
<x-forms.actions>
    <x-forms.action color="white" handler="goBack">
        {{ __('pages.cancel') }}
    </x-forms.action>
    <x-forms.action color="blue" handler="save">
        {{ __('pages.save') }}
    </x-forms.action>
</x-forms.actions>
