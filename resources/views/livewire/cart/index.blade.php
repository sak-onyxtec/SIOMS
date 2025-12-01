<div class="max-w-4xl mx-auto py-12">
    <h2 class="text-2xl font-bold mb-6">Your Cart</h2>
    @if (session()->has('message'))
        <div class="mb-4 p-3 text-white bg-green-600 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (count($cart) > 0)
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Product</th>
                    <th class="text-left py-2">Price</th>
                    <th class="text-left py-2">Quantity</th>
                    <th class="text-left py-2">Subtotal</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $id => $item)
                    <tr class="border-b">
                        <td class="py-2 flex items-center gap-3">
                            @if ($item['image'])
                                <img src="{{ $item['image'] }}" class="h-12 w-12 object-cover rounded"
                                    alt="{{ $item['name'] }}">
                            @endif
                            {{ $item['name'] }}
                        </td>
                        <td class="py-2">${{ number_format($item['price'], 2) }}</td>
                        <td class="py-2 flex items-center gap-2">
                            <button wire:click="decrement('{{ $id }}')"
                                class="px-2 py-1 bg-gray-200 rounded">-</button>
                            <span>{{ $item['quantity'] }}</span>
                            <button wire:click="increment('{{ $id }}')"
                                class="px-2 py-1 bg-gray-200 rounded">+</button>
                        </td>
                        <td class="py-2">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td class="py-2">
                            <button wire:click="remove('{{ $id }}')"
                                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 text-right">
            <span class="text-xl font-bold">Total: ${{ number_format($this->total, 2) }}</span>
        </div>

        <div class="mt-4 text-right">
            <button wire:click="checkout" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Proceed to Checkout
            </button>
        </div>
    @else
        <p class="text-gray-500">Your cart is empty.</p>
        <a href="{{ route('product.listing') }}" class="text-blue-600 hover:underline">Continue shopping</a>
    @endif
</div>
