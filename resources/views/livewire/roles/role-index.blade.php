<div class="container py-4">
    <h3 class="mb-4">Roles Management</h3>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Role</th>
                        <th>Permissions Count</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ ucfirst($role->name) }}</td>
                            <td>{{ $role->permissions->count() }}</td>

                            <td class="text-center">
                                <a href="{{ route('roles.permissions', $role->id) }}"
                                   class="btn btn-sm btn-primary">
                                   <i class="fa fa-key"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
</div>
