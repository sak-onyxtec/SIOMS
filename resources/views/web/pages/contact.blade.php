@extends('web.layouts.master')

@section('title', 'Contact Us')

@section('content')
    {{-- Hero --}}
    @include('web.layouts.hero', [
        'title' => 'Need help with',
        'subtitle' => 'Get in touch with the SIOMS team for support with orders, inventory, and your account.',
        'showButton' => false,
    ])

    <section class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-16">
        <div class="container mx-auto px-4 max-w-5xl">
            {{-- Hero / Heading --}}
            <div class="mb-10 text-center">
                <p class="inline-flex items-center px-4 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold uppercase tracking-wide mb-3">
                    <i class="fa fa-headset mr-2"></i> We’re here to help
                </p>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">
                    Contact <span class="text-blue-600">SIOMS</span> Support
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Have a question about your orders, inventory, or account? Send us a message and our team will get back to you as soon as possible.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                {{-- Left: Contact Info + Highlights --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-md p-6 space-y-4">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fa fa-envelope text-blue-600"></i>
                            Get in touch
                        </h2>
                        <p class="text-gray-600 text-sm">
                            Fill out the form and our support team will respond within
                            <span class="font-semibold text-gray-800">24 hours</span>.
                        </p>
                        <div class="space-y-3 text-sm text-gray-700">
                            <p class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                    <i class="fa fa-envelope-open-text text-sm"></i>
                                </span>
                                <span>
                                    <span class="block text-xs uppercase tracking-wide text-gray-400">Email</span>
                                    support@sioms.test
                                </span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                                    <i class="fa fa-phone-alt text-sm"></i>
                                </span>
                                <span>
                                    <span class="block text-xs uppercase tracking-wide text-gray-400">Phone</span>
                                    +1 (555) 123-4567
                                </span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                                    <i class="fa fa-clock text-sm"></i>
                                </span>
                                <span>
                                    <span class="block text-xs uppercase tracking-wide text-gray-400">Response time</span>
                                    Typically under 1 business day
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="bg-blue-600 text-white rounded-2xl p-6 shadow-md space-y-3">
                        <h3 class="text-lg font-semibold flex items-center gap-2">
                            <i class="fa fa-info-circle"></i>
                            Quick Help
                        </h3>
                        <p class="text-sm text-blue-100">
                            Before contacting us, you can also check our FAQ page for instant answers to common questions.
                        </p>
                        <a href="{{ route('faq.web') }}" class="inline-flex items-center text-sm font-semibold text-white hover:text-blue-100 no-underline">
                            Go to FAQ
                            <i class="fa fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- Right: Contact Form --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        @if (session('success'))
                            <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 text-green-800 text-sm font-medium flex items-center gap-2">
                                <i class="fa fa-check-circle"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <div id="contact-form-alert" class="hidden mb-4"></div>

                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Send us a message</h2>
                        <p class="text-sm text-gray-500 mb-6">
                            Fill in the details below and we’ll reach out via email.
                        </p>

                        <form id="contact-form" class="space-y-4" method="POST" action="{{ route('contact.submit') }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="John Doe">
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="you@example.com">
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        name="subject"
                                        value="{{ old('subject') }}"
                                        placeholder="Order, inventory, billing...">
                                    @error('subject')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Order ID (optional)</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        name="order_id"
                                        value="{{ old('order_id') }}"
                                        placeholder="#SIOMS-12345">
                                    @error('order_id')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea rows="4"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    name="message"
                                    placeholder="Describe your issue or question in a few sentences...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between pt-2">
                                <p class="text-xs text-gray-500">
                                    We’ll never share your information. Read our
                                    <a href="{{ route('privacy.web') }}" class="text-blue-600 hover:underline">privacy policy</a>.
                                </p>
                                <button type="submit" id="submit-btn"
                                    class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 disabled:opacity-75 disabled:cursor-not-allowed disabled:transform-none">
                                    <span id="submit-text">
                                        <i class="fa fa-paper-plane mr-2 text-xs"></i>
                                        Send Message
                                    </span>
                                    <span id="submit-loader" class="hidden">
                                        <i class="fa fa-spinner fa-spin mr-2 text-xs"></i>
                                        Sending...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('contact-form');
            const alertBox = document.getElementById('contact-form-alert');
            if (!form || !alertBox) return;

            function showAlert(type, message, errors = []) {
                const baseClasses = 'mb-4 px-4 py-3 rounded-lg text-sm font-medium flex items-center gap-2 ';
                if (type === 'success') {
                    alertBox.className = baseClasses + 'bg-green-50 text-green-800';
                    alertBox.innerHTML = `<i class="fa fa-check-circle"></i><span>${message}</span>`;
                    alertBox.classList.remove('hidden');
                    
                    // Auto-hide success alert after 3 seconds
                    setTimeout(() => {
                        alertBox.style.transition = 'opacity 0.5s ease-out';
                        alertBox.style.opacity = '0';
                        setTimeout(() => {
                            alertBox.classList.add('hidden');
                            alertBox.style.opacity = '';
                        }, 500);
                    }, 3000);
                } else {
                    alertBox.className = baseClasses + 'bg-red-50 text-red-800';
                    let html = `<i class="fa fa-exclamation-circle"></i><div><span>${message}</span>`;
                    if (errors.length) {
                        html += '<ul class="mt-1 list-disc list-inside text-xs font-normal">';
                        errors.forEach(err => {
                            html += `<li>${err}</li>`;
                        });
                        html += '</ul>';
                    }
                    html += '</div>';
                    alertBox.innerHTML = html;
                    alertBox.classList.remove('hidden');
                }
            }

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                alertBox.classList.add('hidden');

                // Get button elements
                const submitBtn = document.getElementById('submit-btn');
                const submitText = document.getElementById('submit-text');
                const submitLoader = document.getElementById('submit-loader');

                // Show loader and disable button
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                submitLoader.classList.remove('hidden');

                const formData = {
                    name: form.name.value,
                    email: form.email.value,
                    subject: form.subject.value,
                    order_id: form.order_id.value,
                    message: form.message.value,
                };

                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
                    || document.querySelector('input[name="_token"]')?.value;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token || '',
                        },
                        body: JSON.stringify(formData),
                    });

                    if (response.ok) {
                        const data = await response.json();
                        showAlert('success', data.message || 'Thank you for contacting us!');
                        form.reset();
                    } else if (response.status === 422) {
                        const data = await response.json();
                        const errors = [];
                        if (data.errors) {
                            Object.values(data.errors).forEach(fieldErrors => {
                                fieldErrors.forEach(msg => errors.push(msg));
                            });
                        }
                        showAlert('error', 'Please correct the highlighted errors and try again.', errors);
                    } else {
                        showAlert('error', 'Something went wrong while sending your message. Please try again later.');
                    }
                } catch (err) {
                    showAlert('error', 'Unable to send your message at the moment. Please check your connection and try again.');
                } finally {
                    // Hide loader and enable button
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    submitLoader.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
