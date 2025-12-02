@extends('web.layouts.master')
@section('title', 'Products')
@section('content')
    @include('web.layouts.hero', [
        'title' => 'Browse',
        'subtitle' => 'Discover our full catalogue and find the right products for your needs.',
        'showButton' => false,
    ])

    <section class="bg-gray-50 py-20">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10 scroll-fade-in">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 flex items-center gap-3">
                        <i class="fa fa-box-open text-blue-500 text-3xl"></i>
                        <span>All Products</span>
                    </h1>
                    <p class="text-gray-600 mt-2">
                        Use the filters on the left to narrow down by category, price, and more.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('faq.web') }}"
                       class="inline-flex items-center px-4 py-2 bg-white text-blue-600 border border-blue-200 rounded-lg text-sm font-semibold shadow-sm hover:bg-blue-50 transition">
                        <i class="fa fa-circle-question mr-2"></i>
                        Help / FAQs
                    </a>
                    <a href="{{ route('contact.web') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-md hover:bg-blue-700 transition">
                        <i class="fa fa-headset mr-2"></i>
                        Contact Support
                    </a>
                </div>
            </div>

            <div class="scroll-fade-in">
                <livewire:products.web.listing />
            </div>
        </div>
    </section>
@endsection
