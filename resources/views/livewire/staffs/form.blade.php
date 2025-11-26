<div class="card p-4 rounded-3 shadow-sm">

    <form wire:submit.prevent="save">
        {{-- Name --}}
        <div class="mb-3">
            <label class="fw-semibold">Staff Name</label>
            <input type="text" wire:model="name" class="form-control rounded-pill">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="fw-semibold">Email</label>
            <input type="text" wire:model="email" class="form-control rounded-pill">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Password: only show if creating --}}
        @if(!$staff_id)
            <div class="mb-3">
                <label class="fw-semibold">Password</label>
                <input type="password" wire:model="password" class="form-control rounded-pill">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Confirm Password</label>
                <input type="password" wire:model="password_confirmation" class="form-control rounded-pill">
            </div>
        @endif

        {{-- Buttons --}}
        <div class="d-flex justify-content-between mt-4">
            <a wire:navigate href="{{ route('staff.index') }}" class="btn btn-secondary rounded-pill px-4">
                Back
            </a>

            <button class="btn btn-success rounded-pill px-4">
                Save Staff
            </button>
        </div>

    </form>
</div>
