<div class="flex flex-col gap-1">
    <div class="flex items-center justify-start gap-1">
        <label for="{{ $id ?? $model }}" class="flex items-center gap-1 select-none">
            <input id="{{ $id ?? $model }}" class="border rounded-md" type="checkbox" wire:model="{{ $model }}">
            {{ $label }}
        </label>
    </div>
    @error($model)
        <span class="p-1 text-xs text-red-500">{{ $message }}</span>
    @enderror
</div>
