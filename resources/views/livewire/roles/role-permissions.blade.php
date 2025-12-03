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

    {{-- Add New Permission --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Add New Permission</h3>
        <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
            <div class="flex-1 w-full">
                <input
                    type="text"
                    wire:model.defer="newPermissionName"
                    placeholder="e.g. view-reports"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm"
                >
                @error('newPermissionName')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button
                wire:click="addPermission"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200"
            >
                <i class="fa fa-plus mr-2"></i> Add Permission
            </button>
        </div>
    </div>

    {{-- Existing Permissions --}}
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
