@extends('web.layouts.master')
@section('title', 'Products')
@section('content')
    @include('web.layouts.hero',['title'=>'Our Products','subtitle'=>'Browse our wide range of products','showButton'=>false])
    <div class="container mx-auto px-4 py-12">
        <div class="scroll-fade-in mb-8">
            <h1 class="text-4xl font-bold mb-4 text-center text-gray-800">Our Products</h1>
            <p class="text-center text-gray-600">Discover our complete collection</p>
        </div>
        <div class="scroll-fade-in">
            <livewire:products.web.listing />
        </div>
    </div>
@endsection
