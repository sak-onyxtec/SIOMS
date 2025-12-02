@extends('web.layouts.master')

@section('title', 'Privacy Policy')

@section('content')
    {{-- Hero --}}
    @include('web.layouts.hero', [
        'title' => 'Your privacy with',
        'subtitle' => 'Learn how SIOMS collects, uses, and protects your information so you can shop with confidence.',
        'showButton' => false,
    ])

    <section class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-16">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="mb-10 text-center">
                <p class="inline-flex items-center px-4 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold uppercase tracking-wide mb-3">
                    <i class="fa fa-shield-alt mr-2"></i> Privacy & Security
                </p>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">
                    Privacy <span class="text-blue-600">Policy</span>
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    This Privacy Policy explains how we collect, use, and protect your information when you use our platform.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                {{-- Left: Quick overview --}}
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="fa fa-lock text-blue-600"></i>
                            At a glance
                        </h2>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                We only collect data needed to run SIOMS.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                We never sell your personal information.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                You can contact us anytime about your data.
                            </li>
                        </ul>
                    </div>

                    <div class="bg-blue-600 text-white rounded-2xl p-6 shadow-md space-y-3">
                        <h3 class="text-lg font-semibold flex items-center gap-2">
                            <i class="fa fa-user-shield"></i>
                            Questions about privacy?
                        </h3>
                        <p class="text-sm text-blue-100">
                            If you have any questions about how we handle your data, our team is ready to help.
                        </p>
                        <a href="{{ route('contact.web') }}" class="inline-flex items-center text-sm font-semibold text-white hover:text-blue-100 no-underline">
                            Contact our privacy team
                            <i class="fa fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- Right: Policy content --}}
                <div class="lg:col-span-2">
                    <div class="space-y-6 text-sm text-gray-700 leading-relaxed bg-white rounded-2xl shadow-xl p-8">
                        <div>
                            <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">
                                <i class="fa fa-database text-blue-500"></i>
                                Information We Collect
                            </h2>
                            <p>
                                We collect basic account details such as your name, email, and order history to provide our services.
                                We may also collect technical information like IP address and device details to keep your account secure.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">
                                <i class="fa fa-cogs text-emerald-500"></i>
                                How We Use Your Data
                            </h2>
                            <p>
                                Your data is used to process orders, provide customer support, and improve your shopping experience.
                                We may send you important notifications related to your account or orders.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">
                                <i class="fa fa-shield-virus text-purple-500"></i>
                                Data Security
                            </h2>
                            <p>
                                We implement reasonable technical and organizational measures to protect your information from unauthorized access,
                                alteration, disclosure, or destruction.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">
                                <i class="fa fa-envelope-open-text text-amber-500"></i>
                                Contact
                            </h2>
                            <p>
                                If you have questions about this policy, you can contact us at
                                <strong>privacy@sioms.test</strong> or through our
                                <a href="{{ route('contact.web') }}" class="text-blue-600 hover:underline">contact page</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


