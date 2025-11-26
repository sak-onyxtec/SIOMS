<div class="p-4">

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Transaction Form --}}
    <div class="mb-4">
        <label>Product</label>
        <select wire:model="product_id" class="form-control">
            <option value="">Select Product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->quantity }})</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Type</label>
        <select wire:model="type" class="form-control">
            <option value="">Select Type</option>
            <option value="stock_in">Stock In</option>
            <option value="stock_out">Stock Out</option>
            <option value="adjustment">Adjustment</option>
        </select>
    </div>

    <div class="mb-4">
        <label>Quantity</label>
        <input type="number" wire:model="quantity" class="form-control">
        @error('quantity')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4">
        <label>Notes</label>
        <textarea wire:model="notes" class="form-control"></textarea>
    </div>

    <button wire:click="saveTransaction" class="btn btn-primary">Save Transaction</button>

    {{-- Transactions Table --}}
    {{-- @if ($transactions->count()) --}}
        <hr>
        <h5>Transaction History</h5>

        {{-- Filter Dropdown --}}
        <div class="mb-3">
            <label>Filter by Product</label>
            <select wire:model="filter_product_id" wire:change="loadTransactions" class="form-control"
                style="width: 200px;">
                <option value="">All Products</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Notes</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>{{ $transaction->user?->name }}</td>
                        <td>{{ $transaction->product?->name }}</td>
                        <td>{{ $transaction->notes }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    {{-- @endif --}}

</div>
