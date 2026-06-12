<?php

namespace App\Jobs;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOrderEmailJob implements ShouldQueue
{
    use Queueable;

    public $orderId;

    /**
     * Create a new job instance.
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('JOB STARTED');

        $order = Order::with('items')->find($this->orderId);

        if (!$order) {

            \Log::error('ORDER NOT FOUND IN JOB');

            return;
        }

        Mail::to($order->email)
            ->send(new OrderConfirmationMail($order));

        \Log::info('JOB EMAIL SENT');
    }
}