<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card-theme overflow-hidden rounded-xl">
                <div class="p-6 text-primary-theme">
                    <h3 class="text-lg font-semibold mb-2">Welcome to {{ ucfirst(session('college', 'Engineering')) }} College</h3>
                    <p class="text-secondary-theme">{{ __("You're logged in!") }}</p>
                    <div class="mt-4 p-4 rounded-lg border-theme" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                        <p class="text-sm text-primary-theme font-medium">Current Theme: <span class="text-theme">{{ ucfirst(session('college', 'Engineering')) }}</span></p>
                        <p class="text-xs text-muted-theme mt-1">Primary Color: {{ session('theme_primary', '#1e40af') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
