@extends('web.layouts.master')

@section('title', 'Terms & Conditions')

@section('content')
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Terms &amp; Conditions</h1>
            <p class="text-gray-600 mb-8">
                By using our website and services, you agree to the following terms and conditions.
            </p>

            <div class="space-y-6 text-sm text-gray-700 leading-relaxed bg-white rounded-2xl shadow-xl p-8">
                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-800">Use of Service</h2>
                    <p>You agree to use this platform for lawful purposes only and not to misuse or disrupt the service.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-800">Orders & Payments</h2>
                    <p>All orders are subject to acceptance and availability. Prices and payment terms are displayed at checkout.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-800">Returns & Refunds</h2>
                    <p>Returns and refunds are handled according to our return policy as displayed on the site.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-800">Changes to Terms</h2>
                    <p>We may update these terms from time to time. Continued use of the service means you accept the new terms.</p>
                </div>
            </div>
        </div>
    </section>
@endsection


