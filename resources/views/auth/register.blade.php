<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center space-y-1">
            <div
                class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                <i class="fa fa-user-plus text-sm"></i>
            </div>
            <h1 class="text-xl font-semibold text-gray-900">
                {{ __('Create a new account') }}
            </h1>
            <p class="text-xs text-gray-500">
                {{ __('Sign up to start using SIOMS and keep track of your orders.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                              :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                              :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                              type="password"
                              name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="pt-2 space-y-3">
                <x-primary-button class="w-full justify-center">
                    {{ __('Register') }}
                </x-primary-button>

                <p class="text-xs text-center text-gray-500">
                    {{ __('Already registered?') }}
                    <a class="text-blue-600 hover:underline" href="{{ route('login') }}">
                        {{ __('Log in') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
