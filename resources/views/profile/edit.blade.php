<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 py-6 text-gray-900 dark:text-gray-100">
        {{-- Top section: avatar + basic info --}}
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl font-semibold shadow">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase mb-1">Signed in as</p>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                        {{ auth()->user()->name }}
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap gap-3 text-sm">
                <div class="px-3 py-2 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                    <span class="font-semibold">Profile</span> settings
                </div>
                <div class="px-3 py-2 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                    Secure your <span class="font-semibold">password</span>
                </div>
            </div>
        </div>

        {{-- Main content: 2-column layout on large screens --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left column: profile + password --}}
            <div class="space-y-6 lg:col-span-2">
                <div class="p-5 sm:p-7 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-5 sm:p-7 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Right column: danger zone (hidden for admin users) --}}
            @unless(auth()->user() && auth()->user()->hasRole('admin'))
                <div class="space-y-6">
                    <div class="p-5 sm:p-7 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-red-100 dark:border-red-500/40">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            @endunless
        </div>
    </div>
</x-app-layout>
