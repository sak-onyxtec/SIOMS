<?php

namespace App\Jobs;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        $order = $this->order->loadMissing(['items.product', 'user']);

        $mailable = new OrderConfirmationMail($order);

        // Generate PDF receipt from view and attach
        try {
            $pdf = Pdf::loadView('emails.orders.receipt-pdf', [
                'order' => $order,
            ]);

            $mailable->attachData(
                $pdf->output(),
                'receipt-' . $order->uid . '.pdf',
                ['mime' => 'application/pdf']
            );
        } catch (\Throwable $e) {
            info('Failed to generate PDF receipt for order ' . $order->uid . ': ' . $e->getMessage());
        }

        Mail::to($order->user->email)
            ->send($mailable);
    }
}
