@extends('web.layouts.master')

@section('title', 'Terms & Conditions')

@section('content')
    {{-- Hero --}}
    @include('web.layouts.hero', [
        'title' => 'Using',
        'subtitle' => 'Understand the terms that apply when you use the SIOMS platform and related services.',
        'showButton' => false,
    ])

    <section class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-16">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="mb-10 text-center">
                <p class="inline-flex items-center px-4 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold uppercase tracking-wide mb-3">
                    <i class="fa fa-file-contract mr-2"></i> Legal
                </p>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">
                    Terms &amp; <span class="text-blue-600">Conditions</span>
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    By using our website and services, you agree to the following terms and conditions.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                {{-- Left: Quick summary --}}
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="fa fa-scale-balanced text-blue-600"></i>
                            In short
                        </h2>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                Use SIOMS only for lawful, legitimate purposes.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Orders are subject to availability and our policies.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                We may update these terms from time to time.
                            </li>
                        </ul>
                    </div>

                    <div class="bg-blue-600 text-white rounded-2xl p-6 shadow-md space-y-3">
                        <h3 class="text-lg font-semibold flex items-center gap-2">
                            <i class="fa fa-circle-info"></i>
                            Questions about these terms?
                        </h3>
                        <p class="text-sm text-blue-100">
                            If anything in these terms is unclear, reach out to our team and we’ll be happy to help.
                        </p>
                        <a href="{{ route('contact.web') }}" class="inline-flex items-center text-sm font-semibold text-white hover:text-blue-100 no-underline">
                            Contact us
                            <i class="fa fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- Right: Terms content --}}
                <div class="lg:col-span-2">
                    <div class="space-y-6 text-sm text-gray-700 leading-relaxed bg-white rounded-2xl shadow-xl p-8">
                        <div>
                            <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">
                                <i class="fa fa-handshake-angle text-blue-500"></i>
                                Use of Service
                            </h2>
                            <p>
                                You agree to use this platform for lawful purposes only and not to misuse or disrupt the service.
                                You are responsible for maintaining the confidentiality of your account and for all activities
                                that occur under your login.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">
                                <i class="fa fa-receipt text-emerald-500"></i>
                                Orders &amp; Payments
                            </h2>
                            <p>
                                All orders are subject to acceptance and availability. Prices and payment terms are displayed at checkout.
                                We reserve the right to cancel or refuse any order if we suspect fraudulent or abusive activity.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">
                                <i class="fa fa-rotate-left text-amber-500"></i>
                                Returns &amp; Refunds
                            </h2>
                            <p>
                                Returns and refunds are handled according to our return policy as displayed on the site.
                                Please review the applicable policy before placing your order.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">
                                <i class="fa fa-arrows-rotate text-purple-500"></i>
                                Changes to Terms
                            </h2>
                            <p>
                                We may update these terms from time to time. Continued use of the service after changes are posted
                                means you accept the new terms.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


