<div
    x-data="{}"
    class="my-2 overflow-hidden bg-white rounded-md shadow-md"
>
    <div
        @class([
            'flex items-center justify-between gap-1 p-1',
            'bg-black text-white'       => $type == '' || $type == 'default',
            'bg-red-500 text-white'     => $type == 'error',
            'bg-green-500 text-white'   => $type == 'success',
            'bg-blue-500 text-white'    => $type == 'info',
            'bg-yellow-500 text-white'  => $type == 'warning',
        ])
    >
        <h3>{!! $title !!}</h3>
        <button wire:click="close">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div class="p-1">
        {!! $message !!}
    </div>
</div>
