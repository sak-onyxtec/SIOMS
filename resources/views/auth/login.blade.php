<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center space-y-1">
            <div
                class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                <i class="fa fa-lock text-sm"></i>
            </div>
            <h1 class="text-xl font-semibold text-gray-900">
                {{ __('Sign in to your account') }}
            </h1>
            <p class="text-xs text-gray-500">
                {{ __('Use your admin credentials to access the SIOMS dashboard.') }}
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-2" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                              :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember / Links -->
            <!-- <div class="flex items-center justify-between text-xs">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                           name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div> -->

            <div class="pt-2 space-y-3">
                <x-primary-button class="w-full justify-center">
                    {{ __('Log in') }}
                </x-primary-button>

                <p class="text-xs text-center text-gray-500">
                    {{ __('Not have an account?') }}
                    <a class="text-blue-600 hover:underline" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
