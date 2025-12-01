<div class="min-h-screen flex">
    <!-- Left Side (Form) -->
    <div class="flex w-full lg:w-1/2 items-center justify-center bg-gray-100">
        <div class="max-w-md w-full bg-white p-10 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold mb-2 text-center text-gray-800">Create your SIOMS account</h2>
            <p class="text-sm text-gray-500 mb-6 text-center">Shop faster and track your orders in one place.</p>

            @if (session()->has('success'))
                <p class="bg-green-100 text-green-700 p-2 rounded mb-4 text-center">{{ session('success') }}</p>
            @endif

            <form wire:submit.prevent="register" class="space-y-4">
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Name</label>
                    <input type="text" wire:model.defer="name" placeholder="John Doe"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Email</label>
                    <input type="email" wire:model.defer="email" placeholder="you@example.com"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Password</label>
                    <input type="password" wire:model.defer="password" placeholder="********"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Confirm Password</label>
                    <input type="password" wire:model.defer="password_confirmation" placeholder="********"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold transition">
                    Register
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-gray-600">
                Already have an account? <a wire:navigate href="{{ route('login.web') }}"
                    class="text-blue-600 hover:underline">Login</a>
            </p>
        </div>
    </div>
    <!-- Right Side (Image/Color) -->
    <div class="hidden lg:flex w-1/2 bg-blue-600 items-center justify-center relative">
        <img src="{{ asset('storage/uploads/branding/register-hero.jpg') }}" alt="Register Image"
            class="object-cover w-full h-full opacity-80">
        <div class="absolute inset-0 bg-blue-700 opacity-50"></div>
        <div class="absolute text-white text-center px-6">
            <h1 class="text-4xl font-extrabold mb-2 tracking-tight">SIOMS</h1>
            <p class="text-lg">Join today to enjoy a seamless shopping experience.</p>
        </div>
    </div>


</div>
