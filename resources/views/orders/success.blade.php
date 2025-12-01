<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="text-center">

                        <!-- ✅ SUCCESS TICK ICON -->
                        <div class="flex justify-center mb-6">
                            <svg class="w-20 h-20 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-width="2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4" />
                            </svg>
                        </div>

                        <!-- Heading -->
                        <h3 class="text-2xl font-bold mb-4">Thank You for Your Order!</h3>

                        <p class="mb-4">Your order has been placed successfully.</p>

                        <p>
                            An order confirmation has been sent to your email,  
                            and you will receive updates shortly.
                        </p>

                        <div class="mb-6 mt-6">
                            <a href="{{ route('product.listing') }}"
                                class="inline-block no-underline bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                                Continue Shopping
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
