<?php

namespace App\Livewire\Customers;

use App\Mail\CustomerStatusChangedMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

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

    public function toggleActive($id)
    {
        $customer = User::role('customer')->findOrFail($id);
        $customer->is_active = ! $customer->is_active;
        $customer->save();

        // Send status change email to customer
        try {
            Mail::to($customer->email)->send(new CustomerStatusChangedMail($customer, $customer->is_active));
        } catch (\Throwable $e) {
            logger()->error('Failed to send customer status changed email', [
                'customer_id' => $customer->id ?? null,
                'error' => $e->getMessage(),
            ]);
        }

        session()->flash('success', 'Customer status updated!');
        $this->resetPage();
    }

    public function render()
    {
        $customers = User::role('customer')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();

        return view('livewire.customers.index', [
            'customers' => $customers,
        ]);
    }
}


