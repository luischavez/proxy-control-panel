<div class="h-screen">
    <div class="flex items-center justify-center h-full">
        <div class="p-4 bg-white rounded-md shadow-md">
            <h1 class="text-lg font-bold">Login</h1>
            <hr>
            @if (!empty($errorMessage))
                <span class="flex justify-center p-1 text-sm text-red-500">{{ $errorMessage }}</span>
            @endif
            <div class="flex flex-col gap-2 p-2">
                <div class="flex items-center justify-between gap-1">
                    <label for="name">
                        {{ __('pages.login.name_label') }}
                    </label>
                    <input id="name" class="p-1 border rounded-md" type="text" wire:model.debounce="name">
                </div>
                <div class="flex items-center justify-between gap-1">
                    <label for="password">
                        {{ __('pages.login.password_label') }}
                    </label>
                    <input id="password" class="p-1 border rounded-md" type="password" wire:model.debounce="password">
                </div>
                <div class="flex justify-end">
                    <button class="p-1 text-white bg-blue-500 rounded-md shadow-md hover:bg-blue-600 active:bg-blue-700" wire:click="login">
                        {{ __('pages.login.login_button') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
