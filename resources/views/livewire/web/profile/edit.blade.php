<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Header --}}
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-4">
                <div class="relative">
                    <div class="w-14 h-14 rounded-full overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl font-semibold shadow">
                        @if ($profile_image)
                            <img src="{{ $profile_image->temporaryUrl() }}" alt="Profile preview" class="w-full h-full object-cover">
                        @elseif($currentImage)
                            <img src="{{ $currentImage }}" alt="Profile Image" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">My Profile</h1>
                    <p class="text-sm text-gray-500">Manage your account information</p>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-6 py-6 space-y-6">
                @if (session('status') === 'profile-updated')
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-init="setTimeout(() => show = false, 3000)"
                        x-transition.opacity.duration.300ms
                        class="px-4 py-2 rounded-lg bg-green-50 text-green-800 text-sm border border-green-200">
                        Profile updated successfully.
                    </div>
                @endif

                <form wire:submit.prevent="save" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Name</label>
                        <input id="name" type="text" wire:model.defer="name"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                        <input id="email" type="email" wire:model.defer="email"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="profile_image">Profile Image</label>
                        <input id="profile_image" type="file" wire:model="profile_image"
                               class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('profile_image')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        @if ($profile_image)
                            <p class="mt-2 text-xs text-gray-500">Previewing new image...</p>
                        @elseif($currentImage)
                            <p class="mt-2 text-xs text-gray-500">Current image shown above.</p>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


