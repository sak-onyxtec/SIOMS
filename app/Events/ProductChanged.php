<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Models\Product;

class ProductChanged
{
    use SerializesModels;

    public $productId;
    public $action;
    public $before;
    public $after;

    public function __construct($productId, $action, $before = null, $after = null)
    {
        $this->productId = $productId;
        $this->action = $action;
        $this->before = $before;
        $this->after = $after;
    }
}
