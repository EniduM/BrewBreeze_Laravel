<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderService
{
    /**
     * Create a new order with validation.
     */
    public function createOrder(array $data): Order
    {
        $order = Order::create($data);
        
        Log::info('Order created', [
            'order_id' => $order->id,
            'customer_id' => $data['customer_id'],
            'total' => $data['total'],
        ]);

        return $order;
    }

    /**
     * Update order status with audit trail.
     */
    public function updateStatus(Order $order, string $status): Order
    {
        $oldStatus = $order->status;
        
        $order->update(['status' => $status]);
        
        Log::info('Order status updated', [
            'order_id' => $order->id,
            'from' => $oldStatus,
            'to' => $status,
            'user_id' => auth()->id(),
        ]);

        return $order;
    }

    /**
     * Check if order can be cancelled.
     */
    public function canCancel(Order $order): bool
    {
        return $order->canCancel();
    }

    /**
     * Cancel an order with validation.
     */
    public function cancelOrder(Order $order): Order
    {
        if (!$this->canCancel($order)) {
            Log::warning('Cancel attempt on non-cancelable order', [
                'order_id' => $order->id,
                'status' => $order->status,
            ]);
            throw new \Exception('This order cannot be cancelled.');
        }

        return $this->updateStatus($order, 'cancelled');
    }

    /**
     * Get orders with eager loading optimized.
     */
    public function getOrdersForAdmin($perPage = 15)
    {
        return Order::withDetails()
            ->recent()
            ->paginate($perPage);
    }

    /**
     * Get customer's orders efficiently.
     */
    public function getCustomerOrders($customerId, $perPage = 15)
    {
        return Order::where('customer_id', $customerId)
            ->withDetails()
            ->recent()
            ->paginate($perPage);
    }
}
