@extends('web.layouts.master')

@section('title', 'My Account')

@section('content')
    <div class="bg-gray-50 py-10">
        <div class="container mx-auto px-4" x-data="{ tab: 'dashboard' }">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-6">

                <!-- Sidebar card -->
                <aside class="w-full md:w-72 bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-6 py-6 border-b border-gray-200 text-center">
                        <div class="mx-auto w-24 h-24 rounded-full overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-3xl font-semibold shadow">
                            @if($user->profile_image)
                                <img src="{{ $user->profile_image }}" alt="Profile Image" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                        <h2 class="mt-4 text-lg font-semibold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>

                    <nav class="py-4 space-y-1">
                        <button
                            @click="tab = 'dashboard'"
                            :class="tab === 'dashboard'
                                ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600'
                                : 'text-gray-700 hover:bg-gray-100 border-l-4 border-transparent'"
                            class="w-full text-left px-6 py-3 text-sm font-medium flex items-center gap-2">
                            <i class="fa fa-gauge w-4"></i>
                            <span>Dashboard</span>
                        </button>

                        <button
                            @click="tab = 'profile'"
                            :class="tab === 'profile'
                                ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600'
                                : 'text-gray-700 hover:bg-gray-100 border-l-4 border-transparent'"
                            class="w-full text-left px-6 py-3 text-sm font-medium flex items-center gap-2">
                            <i class="fa fa-user w-4"></i>
                            <span>Personal Profile</span>
                        </button>

                        <button
                            @click="tab = 'password'"
                            :class="tab === 'password'
                                ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600'
                                : 'text-gray-700 hover:bg-gray-100 border-l-4 border-transparent'"
                            class="w-full text-left px-6 py-3 text-sm font-medium flex items-center gap-2">
                            <i class="fa fa-key w-4"></i>
                            <span>Change Password</span>
                        </button>

                        <!-- <button
                            @click="tab = 'orders'"
                            :class="tab === 'orders'
                                ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600'
                                : 'text-gray-700 hover:bg-gray-100 border-l-4 border-transparent'"
                            class="w-full text-left px-6 py-3 text-sm font-medium flex items-center gap-2">
                            <i class="fa fa-receipt w-4"></i>
                            <span>My Orders</span>
                        </button> -->

                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-6 py-3 text-sm font-medium flex items-center gap-2 text-red-600 hover:bg-red-50 border-l-4 border-transparent">
                                <i class="fa fa-right-from-bracket w-4"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </nav>
                </aside>

                <!-- Main content -->
                <section class="flex-1 flex flex-col gap-6">
                {{-- Change Password --}}
                    <div x-show="tab === 'password'">
                        <div class="max-w-xl bg-white rounded-2xl shadow-xl px-6 py-6 space-y-6">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Change Password</h1>
                                <p class="text-sm text-gray-500">Update your account password to keep it secure.</p>
                            </div>

                            @if (session('status') === 'password-updated')
                                <div
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-init="setTimeout(() => show = false, 3000)"
                                    x-transition.opacity.duration.300ms
                                    class="px-4 py-2 rounded-lg bg-green-50 text-green-800 text-sm border border-green-200">
                                    Password updated successfully.
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                                @csrf
                                @method('put')

                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Current Password
                                    </label>
                                    <input id="current_password" name="current_password" type="password"
                                           autocomplete="current-password"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('current_password', 'updatePassword')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        New Password
                                    </label>
                                    <input id="password" name="password" type="password"
                                           autocomplete="new-password"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('password', 'updatePassword')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                        Confirm Password
                                    </label>
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                           autocomplete="new-password"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('password_confirmation', 'updatePassword')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-2">
                                    <button type="submit"
                                            class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- Dashboard --}}
                    <div x-show="tab === 'dashboard'" class="space-y-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">My Dashboard</h1>
                            <p class="text-sm text-gray-500">Overview of your orders</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-white rounded-xl shadow-md px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Total Orders</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-md px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                    <i class="fa fa-hourglass-half"></i>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Active</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $activeOrders }}</p>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-md px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Completed</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $completedOrders }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Profile --}}
                    <div x-show="tab === 'profile'">
                        <livewire:web.profile.edit />
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection


