<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Jobs\SendOrderEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderConfirmationEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderPaid $event): void
    {
        \Log::info('DISPATCHING EMAIL JOB');

        SendOrderEmailJob::dispatch($event->orderId);
    }
}