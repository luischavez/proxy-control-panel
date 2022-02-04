<div class="relative w-full h-full">
    @if ($confirmation)
        <div class="absolute flex items-start justify-center w-full h-full">
            @livewire('confirm-dialog', $confirmation)
        </div>
    @endif
    <div class="flex-col @if ($confirmation) hidden @else flex @endif">
        @if ($editingModel == null)
            <div class="flex justify-end gap-1 mx-1 my-2">
                <button class="flex items-center gap-1 p-1 text-sm bg-white rounded-md shadow-md hover:bg-gray-200 active:bg-gray-300" wire:click="create">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    {{ __('pages.create') }}
                </button>
            </div>
            <x-table
                :headers="$this->getTableHeaders()"
                :paginator="$models"
                :cell-actions="$this->getTableCellActions()"
                :actions='$this->getTableActions()'
            />
        @else
            <div class="flex items-center gap-2">
                <button class="flex items-center gap-1 p-1 text-sm bg-white rounded-md shadow-md hover:bg-gray-200 active:bg-gray-300" wire:click="goBack">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    {{ __('pages.go_back') }}
                </button>

                @if ($editingModel->id == null)
                    <h2 class="text-lg">{{ __('pages.creating') }}</h2>
                @else
                    <h2 class="text-lg">{{ __('pages.editing', ['model' => $this->getModelTitleKey() ? $editingModel->{$this->getModelTitleKey()} : '' ]) }}</h2>
                @endif
            </div>
            <x-form>
                @include($this->getFormViewName())
            </x-form>
        @endif
    </div>
</div>
