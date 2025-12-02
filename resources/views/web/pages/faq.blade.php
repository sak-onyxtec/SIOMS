@extends('web.layouts.master')

@section('title', 'FAQ')

@section('content')
    {{-- Hero --}}
    @include('web.layouts.hero', [
        'title' => 'Questions about',
        'subtitle' => 'Find quick answers to common questions about orders, inventory, and your SIOMS account.',
        'showButton' => false,
    ])

    <section class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-16">
        <div id="faq-page-container" class="container mx-auto px-4 max-w-5xl">
            <div class="mb-10 text-center">
                <p class="inline-flex items-center px-4 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold uppercase tracking-wide mb-3">
                    <i class="fa fa-question-circle mr-2"></i> Help Center
                </p>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">
                    Frequently Asked <span class="text-blue-600">Questions</span>
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Browse the topics below. If you still can’t find what you’re looking for, you can always
                    <a href="{{ route('contact.web') }}" class="text-blue-600 font-semibold hover:underline">contact our support team</a>.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left: Categories / Highlights --}}
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="fa fa-list text-blue-600"></i>
                            Topics
                        </h2>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Orders & Tracking
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Payments & Billing
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Accounts & Access
                            </li>
                        </ul>
                    </div>

                    <div class="bg-blue-600 text-white rounded-2xl p-6 shadow-md space-y-3">
                        <h3 class="text-lg font-semibold flex items-center gap-2">
                            <i class="fa fa-headset"></i>
                            Still need help?
                        </h3>
                        <p class="text-sm text-blue-100">
                            Our support team is available to help you with orders, inventory, and account issues.
                        </p>
                        <a href="{{ route('contact.web') }}" class="inline-flex items-center text-sm font-semibold text-white hover:text-blue-100 no-underline">
                            Contact Support
                            <i class="fa fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- Right: FAQ Accordions --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl divide-y divide-gray-200">
                        {{-- Orders & Tracking --}}
                        <details class="p-6 group" open>
                            <summary class="flex justify-between items-center cursor-pointer">
                                <span class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fa fa-truck text-blue-500"></i>
                                    How do I track my order?
                                </span>
                                <span class="text-gray-400 group-open:rotate-180 transition-transform">
                                    &#9660;
                                </span>
                            </summary>
                            <p class="mt-3 text-sm text-gray-600">
                                You can track your orders from the <strong>“My Orders”</strong> section of your account after logging in.
                                Each order shows its current status and key updates.
                            </p>
                        </details>

                        {{-- Payments --}}
                        <details class="p-6 group">
                            <summary class="flex justify-between items-center cursor-pointer">
                                <span class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fa fa-credit-card text-emerald-500"></i>
                                    What payment methods do you accept?
                                </span>
                                <span class="text-gray-400 group-open:rotate-180 transition-transform">
                                    &#9660;
                                </span>
                            </summary>
                            <p class="mt-3 text-sm text-gray-600">
                                We accept major credit/debit cards and any additional methods shown at checkout. All payments are processed securely.
                            </p>
                        </details>

                        {{-- Accounts --}}
                        <details class="p-6 group">
                            <summary class="flex justify-between items-center cursor-pointer">
                                <span class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fa fa-user-lock text-amber-500"></i>
                                    How can I contact support?
                                </span>
                                <span class="text-gray-400 group-open:rotate-180 transition-transform">
                                    &#9660;
                                </span>
                            </summary>
                            <p class="mt-3 text-sm text-gray-600">
                                You can use the contact form on our <a href="{{ route('contact.web') }}" class="text-blue-600 hover:underline">Contact page</a>
                                or email us at <span class="font-mono">support@sioms.test</span>.
                            </p>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('faq-page-container');
            if (!container) return;

            const detailsEls = Array.from(container.querySelectorAll('details'));
            if (!detailsEls.length) return;

            function updateFaqHeight() {
                let maxHeight = 0;
                const originalStates = detailsEls.map(d => d.open);

                // Temporarily open all to measure full height
                detailsEls.forEach(d => d.open = true);
                maxHeight = container.offsetHeight;

                // Restore original states
                detailsEls.forEach((d, i) => d.open = originalStates[i]);

                if (maxHeight > 0) {
                    container.style.minHeight = maxHeight + 'px';
                }
            }

            detailsEls.forEach(d => {
                d.addEventListener('toggle', updateFaqHeight);
            });

            window.addEventListener('resize', updateFaqHeight);
            updateFaqHeight();
        });
    </script>
@endsection


