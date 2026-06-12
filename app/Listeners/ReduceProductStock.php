<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReduceProductStock implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderPaid $event): void
    {
        \Log::info('Stock listener running');

        $order = Order::with('items')->find($event->orderId);

        if (!$order) {

            \Log::error('Order not found');

            return;
        }

        foreach ($order->items as $item) {

            $product = Product::find($item->product_id);

            if (!$product) {

                \Log::error('Product not found: ' . $item->product_id);

                continue;
            }

            $product->decrement('stock', $item->quantity);

            \Log::info('Stock reduced', [
                'product_id' => $product->id,
                'reduced_by' => $item->quantity,
                'new_stock' => $product->fresh()->stock,
            ]);
        }
    }
}