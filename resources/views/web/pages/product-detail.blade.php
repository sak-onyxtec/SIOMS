@extends('web.layouts.master')
@section('title', 'Product Details')
@section('content')
    @include('web.layouts.hero',['title'=>'Product Details','subtitle'=>'View detailed information about our products','showButton'=>false])
    <div class="container mx-auto px-4 py-12">
        <div class="scroll-fade-in">
            <livewire:products.web.detail :slug="$slug" />
        </div>
    </div>
@endsection
