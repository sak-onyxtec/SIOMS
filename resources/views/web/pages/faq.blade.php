@extends('web.layouts.master')

@section('title', 'FAQ')

@section('content')
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h1>
            <p class="text-gray-600 mb-8">
                Find answers to the most common questions about orders, shipping, and your account.
            </p>

            <div class="bg-white rounded-2xl shadow-xl divide-y divide-gray-200">
                <details class="p-6 group" open>
                    <summary class="flex justify-between items-center cursor-pointer">
                        <span class="text-sm font-semibold text-gray-800">How do I track my order?</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">&#9660;</span>
                    </summary>
                    <p class="mt-3 text-sm text-gray-600">
                        You can track your orders from the “My Orders” section of your account after logging in.
                    </p>
                </details>

                <details class="p-6 group">
                    <summary class="flex justify-between items-center cursor-pointer">
                        <span class="text-sm font-semibold text-gray-800">What payment methods do you accept?</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">&#9660;</span>
                    </summary>
                    <p class="mt-3 text-sm text-gray-600">
                        We accept major credit/debit cards and other methods shown at checkout.
                    </p>
                </details>

                <details class="p-6 group">
                    <summary class="flex justify-between items-center cursor-pointer">
                        <span class="text-sm font-semibold text-gray-800">How can I contact support?</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">&#9660;</span>
                    </summary>
                    <p class="mt-3 text-sm text-gray-600">
                        You can use the contact form on our Contact page or email us at support@example.com.
                    </p>
                </details>
            </div>
        </div>
    </section>
@endsection


