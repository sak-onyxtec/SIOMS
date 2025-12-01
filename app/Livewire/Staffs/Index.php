<?php

namespace App\Livewire\Staffs;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use App\Mail\StaffStatusChangedMail;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortByColumn($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function delete($id)
    {
        $staff = User::role('staff')->findOrFail($id);
        $staff->delete();
        session()->flash('success', 'Staff deleted!');
        $this->resetPage();
    }

    public function toggleActive($id)
    {
        $staff = User::role('staff')->findOrFail($id);
        $staff->is_active = ! $staff->is_active;
        $staff->save();

        // Send status change email
        try {
            Mail::to($staff->email)->send(new StaffStatusChangedMail($staff, $staff->is_active));
        } catch (\Throwable $e) {
            logger()->error('Failed to send staff status changed email', [
                'staff_id' => $staff->id ?? null,
                'error' => $e->getMessage(),
            ]);
        }

        session()->flash('success', 'Staff status updated!');
        $this->resetPage();
    }

    public function render()
    {
        $staffs = User::role('staff')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.staffs.index', [
            'staffs' => $staffs
        ]);
    }
}
