<?php

namespace App\Livewire\Stripe;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Payments extends Component
{
    use WithPagination;

    public $search = '';
    public $dateFrom = '';
    public $dateTo = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        // Only show orders that have been paid (paid_at is not null)
        $payments = Order::where('payment_method', 'stripe')
            ->whereNotNull('paid_at')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('uid', 'like', "%{$this->search}%")
                        ->orWhere('stripe_session_id', 'like', "%{$this->search}%")
                        ->orWhere('stripe_payment_intent_id', 'like', "%{$this->search}%");
                });
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('paid_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('paid_at', '<=', $this->dateTo);
            })
            ->with(['user', 'items.product'])
            ->orderBy('paid_at', 'desc')
            ->paginate(15);

        // Calculate total earnings only from paid orders that have not been refunded (net earnings)
        $totalEarnings = Order::where('payment_method', 'stripe')
            ->whereNotNull('paid_at')
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('paid_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('paid_at', '<=', $this->dateTo);
            })
            ->sum('total');

        // Count only paid orders that have not been refunded
        $totalCount = Order::where('payment_method', 'stripe')
            ->whereNotNull('paid_at')
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('paid_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('paid_at', '<=', $this->dateTo);
            })
            ->count();

        $totalRefunded = Order::where('payment_method', 'stripe')
            ->whereNotNull('paid_at')
            ->whereNotNull('refunded_at')
            ->sum('total');

        $totalNetEarnings = $totalEarnings - $totalRefunded;

        return view('livewire.stripe.payments', [
            'payments' => $payments,
            'totalEarnings' => $totalEarnings,
            'totalCount' => $totalCount,
            'totalRefunded' => $totalRefunded,
            'totalNetEarnings' => $totalNetEarnings,
        ]);
    }
}
