<?php

namespace App\Listeners;

use App\Events\ProductChanged;
use App\Models\ProductChangeLog;
use Illuminate\Support\Facades\Auth;

class LogProductChange
{
    public function handle(ProductChanged $event)
    {
        ProductChangeLog::create([
            'product_id' => $event->productId,
            'action_by' => Auth::id(),
            'action' => $event->action,
            'before' => $event->before ? json_encode($event->before) : null,
            'after' => $event->after ? json_encode($event->after) : null,
        ]);
    }
}
