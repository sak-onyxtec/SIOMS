@extends('web.layouts.master')

@section('title', 'Privacy Policy')

@section('content')
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Privacy Policy</h1>
            <p class="text-gray-600 mb-8">
                This Privacy Policy explains how we collect, use, and protect your information when you use our platform.
            </p>

            <div class="space-y-6 text-sm text-gray-700 leading-relaxed bg-white rounded-2xl shadow-xl p-8">
                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-800">Information We Collect</h2>
                    <p>We collect basic account details such as your name, email, and order history to provide our services.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-800">How We Use Your Data</h2>
                    <p>Your data is used to process orders, provide customer support, and improve your shopping experience.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-800">Data Security</h2>
                    <p>We implement reasonable technical and organizational measures to protect your information.</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-800">Contact</h2>
                    <p>If you have questions about this policy, you can contact us at <strong>privacy@example.com</strong>.</p>
                </div>
            </div>
        </div>
    </section>
@endsection


