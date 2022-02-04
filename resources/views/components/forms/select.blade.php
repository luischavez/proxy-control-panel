<div class="flex flex-col gap-1">
    <div class="flex items-center justify-between gap-1">
        <label for="{{ $id ?? $model }}" class="@error($model) text-red-500 @enderror">
            @if($required)
                <span class="font-bold">*</span>{{ $label }}
            @else
                {{ $label }}
            @endif
        </label>
        <select id="{{ $id ?? $model }}" class="w-full p-1 border rounded-md @error($model) border-red-500 focus:outline-none focus:ring focus:ring-red-500 @enderror" wire:model="{{ $model }}">
            <option value=""></option>
            @foreach ($options as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    @error($model)
        <span class="p-1 text-xs text-red-500">{{ $message }}</span>
    @enderror
</div>
