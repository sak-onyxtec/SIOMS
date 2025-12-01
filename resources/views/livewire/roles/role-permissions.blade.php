<div class="p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Manage Permissions — {{ ucfirst($role->name) }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Toggle the permissions assigned to this role to control access across the system.
            </p>
        </div>

        <a href="{{ route('roles.index') }}"
           class="inline-flex items-center no-underline px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
            <i class="fa fa-arrow-left mr-2"></i> Back to Roles
        </a>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-lg border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($permissions as $permission)
                <label for="perm_{{ $permission->id }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 hover:border-blue-400 cursor-pointer transition-colors duration-200">
                    <input type="checkbox"
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                           wire:model="selectedPermissions"
                           value="{{ $permission->name }}"
                           id="perm_{{ $permission->id }}"
                           wire:change="savePermissions">
                    <span class="text-sm text-gray-800">
                        {{ ucfirst($permission->name) }}
                    </span>
                </label>
            @endforeach
        </div>
    </div>
</div>
