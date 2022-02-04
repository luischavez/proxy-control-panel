<div class="h-full max-h-full main-grid">
    <header class="flex items-center justify-between p-1 text-white bg-orange-500">
        <h2 class="text-xl">{{ config('app.name') }}</h2>
        <div class="flex items-center gap-2">
            <span>{{ auth()->user()?->name }}</span>
            <button class="p-1 text-sm hover:underline" wire:click="logout">
                {{ __('pages.panel.logout_button') }}
            </button>
        </div>
    </header>
    <div class="flex">
        <aside class="flex flex-col justify-between p-4 bg-white shadow-md">
            <ol class="space-y-2">
                <li>
                    <button class="flex items-center gap-1 hover:underline active:text-orange-500" wire:click="changeSection('home')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('pages.panel.menus.home') }}
                    </button>
                </li>
                <li>
                    <button class="flex items-center gap-1 hover:underline active:text-orange-500" wire:click="changeSection('domains')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('pages.panel.menus.domains') }}
                    </button>
                </li>
                <li>
                    <button class="flex items-center gap-1 hover:underline active:text-orange-500" wire:click="changeSection('subdomains')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        {{ __('pages.panel.menus.subdomains') }}
                    </button>
                </li>
            </ol>
            <ol class="space-y-2">
                @if (auth()->user()?->type === 'superadmin')
                    <li>
                        <button class="flex items-center gap-1 hover:underline active:text-orange-500" wire:click="changeSection('users')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            {{ __('pages.panel.menus.users') }}
                        </button>
                    </li>
                @endif
                <li>
                    <button class="flex items-center gap-1 hover:underline active:text-orange-500" wire:click="changeSection('logs')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('pages.panel.menus.logs') }}
                    </button>
                </li>
                <li>
                    <button class="flex items-center gap-1 hover:underline active:text-orange-500" wire:click="changeSection('configuration')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('pages.panel.menus.configuration') }}
                    </button>
                </li>
            </ol>
        </aside>
        <main class="flex flex-col w-full px-4 py-2">
            <h1 class="text-lg">{{ __('pages.panel.menus.'.$section) }}</h1>
            <hr class="my-4">
            <div class="relative flex w-full h-full max-h-full p-1 overflow-auto">
                <div class="absolute top-0 right-0 z-10">
                    @foreach ($alerts as $alert)
                        @livewire('alert', $alert, key($alert['tag']))
                    @endforeach
                </div>
                @livewire($section, key($section))
            </div>
        </main>
    </div>
</div>
