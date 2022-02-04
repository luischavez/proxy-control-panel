@if ($editingModel?->id)
    <h2 class="text-lg">{{ $editingModel->domain->name }}</h2>
@endif
<x-forms.text-input :label="__('pages.subdomains.form.name')" model="editingModel.name" :required="true" />

@if ($editingModel?->id === null)
    <x-forms.select :label="__('pages.subdomains.form.domain')" :options="$domains" model="editingModel.domain_id" :required="true" />
@endif

@if ($editingModel?->id)
    <div class="flex flex-col gap-4 my-5">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold">
                {{ __('pages.subdomains.locations') }}
            </h2>
            <button class="p-1 text-white bg-blue-500 rounded-md shadow-md hover:bg-blue-600 active:bg-blue-700" wire:click="newLocation">
                {{ __('pages.new') }}
            </button>
        </div>
        @foreach ($locations as $index => $location)
            <div wire:key="{{ $index }}" class="flex flex-col gap-1 p-2 mx-2 text-xs border border-gray-200 rounded-md">
                <div class="flex justify-end">
                    <button wire:click="{{ "removeLocation({$index})" }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="flex justify-start gap-2">
                    <div class="flex items-center gap-1">
                        <label for="path_{{ $index }}">{{ __('pages.locations.form.path') }}</label>
                        <input id="path_{{ $index }}" class="p-1 border rounded-md" type="text" placeholder="path" wire:model="{{ "locations.$index.path" }}">
                    </div>
                    <div class="flex items-center gap-1">
                        <label for="type_{{ $index }}">{{ __('pages.locations.form.type') }}</label>
                        <select id="type_{{ $index }}" class="w-full h-full p-1 border rounded-md" wire:model="{{ "locations.$index.type" }}">
                            <option value="proxy">Proxy</option>
                            <option value="redirect">Redirect</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-1">
                        <label for="subtype_{{ $index }}">{{ __('pages.locations.form.subtype') }}</label>
                        <select id="subtype_{{ $index }}" class="w-full h-full p-1 border rounded-md" wire:model="{{ "locations.$index.subtype" }}">
                            <option value="http">HTTP</option>
                            <option value="ws">WS</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-1">
                        <label for="target_{{ $index }}">{{ __('pages.locations.form.target') }}</label>
                        <input id="target_{{ $index }}" class="p-1 border rounded-md" type="text" placeholder="target" wire:model="{{ "locations.$index.target" }}">
                    </div>
                </div>
                <div class="flex justify-start gap-2">
                    <div class="flex items-center gap-1">
                        <label for="connect_timeout_{{ $index }}">{{ __('pages.locations.form.connect_timeout') }}</label>
                        <input id="connect_timeout_{{ $index }}" class="p-1 border rounded-md" type="number" min="0" wire:model="{{ "locations.$index.connect_timeout" }}">
                    </div>
                    <div class="flex items-center gap-1">
                        <label for="send_timeout_{{ $index }}">{{ __('pages.locations.form.send_timeout') }}</label>
                        <input id="send_timeout_{{ $index }}" class="p-1 border rounded-md" type="number" min="0" wire:model="{{ "locations.$index.send_timeout" }}">
                    </div>
                    <div class="flex items-center gap-1">
                        <label for="read_timeout_{{ $index }}">{{ __('pages.locations.form.read_timeout') }}</label>
                        <input id="read_timeout_{{ $index }}" class="p-1 border rounded-md" type="number" min="0" wire:model="{{ "locations.$index.read_timeout" }}">
                    </div>
                </div>
                <div class="flex justify-start gap-2">
                    <div>
                        <label for="enable_x_headers_{{ $index }}" class="select-none">
                            <input id="enable_x_headers_{{ $index }}" type="checkbox" wire:model="{{ "locations.$index.enable_x_headers" }}">
                            {{ __('pages.locations.form.enable_x_headers') }}
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<x-forms.actions>
    <x-forms.action color="white" handler="goBack">
        {{ __('pages.cancel') }}
    </x-forms.action>
    <x-forms.action color="blue" handler="save">
        {{ __('pages.save') }}
    </x-forms.action>
</x-forms.actions>
