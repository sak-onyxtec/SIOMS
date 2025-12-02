<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center space-y-1">
            <div
                class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                <i class="fa fa-envelope-open-text text-sm"></i>
            </div>
            <h1 class="text-xl font-semibold text-gray-900">
                {{ __('Verify your email address') }}
            </h1>
            <p class="text-xs text-gray-500">
                {{ __('We have sent a verification link to your email. Please click the link to activate your account.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-2 font-medium text-xs text-green-600 dark:text-green-400 text-center">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                @csrf

                <x-primary-button class="w-full justify-center">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto text-center">
                @csrf

                <button type="submit"
                        class="w-full sm:w-auto underline text-xs text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
