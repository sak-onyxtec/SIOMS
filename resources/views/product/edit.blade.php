<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8">
            <!-- Important: wire:key ensures mount() is called correctly on SPA navigation -->
            <livewire:products.form :id="$id" wire:key="product-form-{{ $id }}" />
        </div>
    </div>
</x-app-layout>
