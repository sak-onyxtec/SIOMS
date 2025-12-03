<?php

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCancellationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $refunded;

    public function __construct(Order $order, $refunded = false)
    {
        $this->order = $order;
        $this->refunded = $refunded;
    }

    public function build()
    {
        $mail = $this->subject('Order Cancelled #' . $this->order->uid)
            ->markdown('emails.orders.cancellation');

        // Attach refund PDF only when a refund was actually processed
        if ($this->refunded && $this->order->refunded_at) {
            $this->order->loadMissing(['items.product', 'user']);

            $pdf = Pdf::loadView('emails.orders.refund-pdf', [
                'order' => $this->order,
            ]);

            $mail->attachData(
                $pdf->output(),
                'refund-' . $this->order->uid . '.pdf',
                ['mime' => 'application/pdf']
            );
        }

        return $mail;
    }
}
