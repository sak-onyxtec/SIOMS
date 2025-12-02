<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center space-y-1">
            <div
                class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600">
                <i class="fa fa-shield-alt text-sm"></i>
            </div>
            <h1 class="text-xl font-semibold text-gray-900">
                {{ __('Confirm your password') }}
            </h1>
            <p class="text-xs text-gray-500">
                {{ __('For your security, please enter your password again before continuing.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full justify-center">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
