<button
    @class([
        'p-1 rounded-md shadow-md',
        'text-black bg-white hover:bg-gray-200 active:bg-gray-300'      => $color == 'white',
        'text-white bg-blue-500 hover:bg-blue-600 active:bg-blue-700'   => $color == 'blue',
    ])
    wire:click="{{ $handler }}"
>
    {{ $slot }}
</button>
