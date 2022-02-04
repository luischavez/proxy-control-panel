<div class="flex items-start justify-center w-full">
    <x-form>
        <x-forms.text-input :label="__('pages.configurations.password')" model="password" type="password" :required="true" />
        <x-forms.text-input :label="__('pages.configurations.password_confirmation')" model="password_confirmation" type="password" :required="true" />
        <x-forms.text-input :label="__('pages.configurations.current_password')" model="current_password" type="password" :required="true" />
        <x-forms.actions>
            <x-forms.action color="blue" handler="save">
                {{ __('pages.save') }}
            </x-forms.action>
        </x-forms.actions>
    </x-form>
</div>
