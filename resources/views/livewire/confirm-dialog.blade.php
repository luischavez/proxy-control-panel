<div class="overflow-hidden bg-white rounded-md shadow-md">
    <div
        @class([
            'p-1',
            'bg-black text-white'       => $type == '' || $type == 'default',
            'bg-red-500 text-white'     => $type == 'error',
            'bg-green-500 text-white'   => $type == 'success',
            'bg-blue-500 text-white'    => $type == 'info',
            'bg-yellow-500 text-white'  => $type == 'warning',
        ])
    >
        <h2>{{ $title }}</h2>
    </div>

    <div class="p-1">
        {{ $message }}
    </div>

    <div class="flex justify-end gap-5 p-1">
        <button class="" wire:click="cancel">{{ __('pages.confirm_dialog.no') }}</button>
        <button class="text-green-500" wire:click="ok">{{ __('pages.confirm_dialog.yes') }}</button>
    </div>
</div>
