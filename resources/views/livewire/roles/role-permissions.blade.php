<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Manage Permissions — {{ ucfirst($role->name) }}</h3>

        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                @foreach ($permissions as $permission)
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input type="checkbox"
                                class="form-check-input"
                                wire:model="selectedPermissions"
                                value="{{ $permission->name }}"
                                id="perm_{{ $permission->id }}"
                                wire:change="savePermissions">
                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                {{ ucfirst($permission->name) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
