<div class="p-6">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">
            Roles Management
        </h2>
    </div>

    {{-- Roles Summary --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Roles</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $roles->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-user-shield text-blue-600"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">With Permissions</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">
                    {{ $roles->filter(fn($r) => $r->permissions->count() > 0)->count() }}
                </p>
            </div>
            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-check text-green-600"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Without Permissions</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">
                    {{ $roles->filter(fn($r) => $r->permissions->count() == 0)->count() }}
                </p>
            </div>
            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-exclamation text-yellow-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white">
        <div class="">
            <table class="w-full js-datatable">
                <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Permissions
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-32">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($roles as $role)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">{{ ucfirst($role->name) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $role->permissions->count() > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $role->permissions->count() }} {{ Str::plural('permission', $role->permissions->count()) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <a href="{{ route('roles.permissions', $role->id) }}"
                                   class="inline-flex items-center no-underline justify-center text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200"
                                   title="Manage Permissions">
                                    <i class="fa fa-key mr-1"></i> Manage
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No roles found</p>
                                    <p class="text-sm mt-1">Roles will appear here once they are created.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
