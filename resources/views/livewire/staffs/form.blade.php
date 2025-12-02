<div class="max-w-full mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">
                {{ $staff_id ? 'Edit Staff' : 'Create Staff' }}
            </h2>
        </div>

        <form wire:submit.prevent="save" class="p-6 space-y-6">
            {{-- Profile Image --}}
            <div class="border-b border-gray-200 pb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Profile Image
                </label>

                <div class="flex flex-col items-center mb-4">
                    @if ($profile_image)
                        <img src="{{ $profile_image->temporaryUrl() }}"
                             class="rounded-full border-2 border-gray-200 shadow-md"
                             width="128" height="128"
                             style="object-fit: cover;">
                    @elseif ($oldProfileImage)
                        <img src="{{ asset('storage/uploads/users/' . $oldProfileImage) }}"
                             class="rounded-full border-2 border-gray-200 shadow-md"
                             width="128" height="128"
                             style="object-fit: cover;">
                    @else
                        <div class="w-32 h-32 bg-gray-100 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center">
                            <i class="fas fa-user text-gray-400 text-3xl"></i>
                        </div>
                    @endif
                </div>

                <div class="text-center">
                    <input type="file"
                           wire:model="profile_image"
                           accept="image/*"
                           class="hidden"
                           id="profile-image-upload">
                    <label for="profile-image-upload"
                           class="inline-block px-4 py-2 bg-gray-100 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-200 transition-colors duration-200 text-sm font-medium">
                        <i class="fas fa-upload mr-2"></i> Upload Profile Image
                    </label>
                </div>
                @error('profile_image')
                    <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
                @enderror
            </div>

            {{-- Name --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Staff Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       wire:model="name"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('name') border-red-500 @enderror"
                       placeholder="Enter staff name"
                       maxlength="25">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email"
                       wire:model="email"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('email') border-red-500 @enderror"
                       placeholder="Enter email address"
                       maxlength="100">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Info: password will be generated & emailed --}}
            @if(!$staff_id)
                <div>
                    <div class="rounded-lg border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                        A temporary password will be generated and emailed to this staff member.
                    </div>
                </div>
            @endif

            {{-- Buttons --}}
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a wire:navigate
                   href="{{ route('staff.index') }}"
                   class="px-6 py-3 no-underline border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>

                <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> Save Staff
                </button>
            </div>
        </form>
    </div>
</div>
