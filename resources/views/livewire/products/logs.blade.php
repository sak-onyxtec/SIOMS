<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Change Logs & Inventory Transactions — {{ $product->name }}</h3>
        <a href="{{ route('product.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="row">
        <!-- Change Logs -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Change Logs</h5>

                    @if ($changeLogs->count())
                        <ul class="timeline list-unstyled position-relative">
                            @foreach ($changeLogs as $log)
                                <li class="mb-4 position-relative ps-5">
                                    <span class="position-absolute top-0 start-0 translate-middle bg-primary rounded-circle"
                                        style="width:14px; height:14px;"></span>

                                    <div class="p-3 border rounded shadow-sm bg-light">
                                        <h6 class="mb-1">{{ ucfirst($log->action) }}</h6>
                                        <p class="mb-1 text-muted">
                                            <strong>User:</strong> {{ $log->user->name ?? 'System' }}
                                        </p>
                                        <small class="text-secondary">
                                            {{ $log->created_at->format('d M Y — h:i A') }}
                                        </small>
                                    </div>
                                </li>
                            @endforeach

                            <div class="position-absolute top-0 start-0 bg-primary"
                                style="width:3px; height:100%; left:6px;"></div>
                        </ul>
                    @else
                        <p class="text-muted">No change logs found for this product.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Inventory Transactions -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Inventory Transactions</h5>

                    @if ($transactions->count())
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>User</th>
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
                                        <td>{{ $transaction->user?->name ?? 'System' }}</td>
                                        <td>{{ $transaction->notes ?? '-' }}</td>
                                        <td>{{ $transaction->created_at->format('d M Y — h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No inventory transactions found for this product.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
