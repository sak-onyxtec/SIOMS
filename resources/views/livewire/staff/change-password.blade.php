<div>
    @if($showModal && auth()->user()->hasRole('staff') && auth()->user()->first_login)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-2xl border border-gray-100 w-full max-w-md mx-4">
                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 px-6 py-4 rounded-t-xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white">Change Your Password</h3>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4">
                    <div class="mb-4 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            This is your first login. Please change your temporary password to a secure one.
                        </p>
                    </div>

                    <form wire:submit.prevent="updatePassword" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                New Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password"
                                   wire:model="password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('password') border-red-500 @enderror"
                                   placeholder="Enter new password"
                                   autofocus>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password"
                                   wire:model="password_confirmation"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('password_confirmation') border-red-500 @enderror"
                                   placeholder="Confirm new password">
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end items-center pt-4 border-t border-gray-200 gap-3">
                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="updatePassword"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-75 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="updatePassword">
                                    <i class="fas fa-save mr-2"></i> Change Password
                                </span>
                                <span wire:loading wire:target="updatePassword">
                                    <i class="fas fa-spinner fa-spin mr-2"></i> Updating...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

