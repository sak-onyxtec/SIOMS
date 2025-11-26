<div class="p-4">

    @can('create-products')
        <div class="mb-3 text-end">
            <a href="{{ route('product.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    @endcan

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="productsTable" class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->sku }}</td>
                            <td>{{ $p->category ?? '-' }}</td>
                            <td>{{ $p->quantity }}</td>
                            <td>${{ number_format($p->price, 2) }}</td>
                            <td>
                                @if ($p->product_image)
                                    <img src="{{ $p->product_image }}" class="rounded-circle" width="50"
                                        height="50">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('product.logs', $p->id) }}" title="Change Logs" class="btn btn-sm btn-info">
                                    <i class="fas fa-file"></i>
                                </a>
                                @can('edit-products')
                                    <a href="{{ route('product.edit', $p->id) }}" title="Edit" wire:key="edit-{{ $p->id }}"
                                        class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete-products')
                                    <button type="button" title="Delete" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete({{ $p->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var table = $('#productsTable').DataTable({
                "lengthMenu": [5, 10, 25, 50],
                "order": [
                    [0, "desc"]
                ],
            });

            Livewire.hook('message.processed', (message, component) => {
                // Destroy the old DataTable if it exists
                if ($.fn.DataTable.isDataTable('#productsTable')) {
                    $('#productsTable').DataTable().destroy();
                }

                // Re-initialize
                $('#productsTable').DataTable({
                    "lengthMenu": [5, 10, 25, 50],
                    "order": [
                        [0, "desc"]
                    ],
                });
            });

        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', id);
                    Swal.fire(
                        'Deleted!',
                        'Product has been deleted.',
                        'success'
                    );
                }
            })
        }
    </script>
@endpush
