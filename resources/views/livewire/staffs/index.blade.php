<div class="p-4">

    <div class="mb-3 text-end">
        <a href="{{ route('staff.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Staff
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="staffsTable" class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staffs as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->email }}</td>
                            <td>
                                <a href="{{ route('staff.edit', $p->id) }}" class="btn btn-sm btn-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDelete({{ $p->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
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
            var table = $('#staffsTable').DataTable({
                "lengthMenu": [5, 10, 25, 50],
                "order": [
                    [0, "desc"]
                ],
            });

            Livewire.hook('message.processed', (message, component) => {
                // Destroy the old DataTable if it exists
                if ($.fn.DataTable.isDataTable('#staffsTable')) {
                    $('#staffsTable').DataTable().destroy();
                }

                // Re-initialize
                $('#staffsTable').DataTable({
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
                        'Staff has been deleted.',
                        'success'
                    );
                }
            })
        }
    </script>
@endpush
