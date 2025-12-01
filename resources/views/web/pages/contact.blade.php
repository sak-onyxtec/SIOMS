@extends('web.layouts.master')

@section('title', 'Contact Us')

@section('content')
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="mb-10 text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Contact Us</h1>
                <p class="text-gray-600">Have a question or need help? Send us a message and we’ll get back to you.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800">Get in touch</h2>
                    <p class="text-gray-600 text-sm">
                        Fill out the form and our team will respond as soon as possible.
                    </p>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><span class="font-semibold">Email:</span> support@example.com</p>
                        <p><span class="font-semibold">Phone:</span> +1 (555) 123-4567</p>
                    </div>
                </div>

                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Your name">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="you@example.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="How can we help?"></textarea>
                    </div>
                    <button type="button" class="inline-flex justify-center px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection


