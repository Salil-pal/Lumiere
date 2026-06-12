<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPaid
{
    use Dispatchable, SerializesModels;

    public $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }
}