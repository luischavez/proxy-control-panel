<x-forms.text-input :label="__('pages.domains.form.name')" model="editingModel.name" :required="true" />
<x-forms.check-box :label="__('pages.domains.form.enable_ssl')" model="editingModel.enable_ssl" />
<x-forms.check-box :label="__('pages.domains.form.force_https')" model="editingModel.force_https" />
<x-forms.text-input :label="__('pages.domains.form.ssl_cert_location')" model="editingModel.ssl_cert_location" />
<x-forms.text-input :label="__('pages.domains.form.ssl_key_location')" model="editingModel.ssl_key_location" />
<x-forms.actions>
    <x-forms.action color="white" handler="goBack">
        {{ __('pages.cancel') }}
    </x-forms.action>
    <x-forms.action color="blue" handler="save">
        {{ __('pages.save') }}
    </x-forms.action>
</x-forms.actions>
