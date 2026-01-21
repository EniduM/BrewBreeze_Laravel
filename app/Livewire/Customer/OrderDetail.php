<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderDetail extends Component
{
    public $orderId;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
    }

    public function getCustomer()
    {
        return auth()->user()->getOrCreateCustomer();
    }

    public function printReceipt()
    {
        $customer = $this->getCustomer();
        
        if (!$customer) {
            abort(403, 'Customer record not found.');
        }

        $order = Order::with('orderItems.product', 'payment', 'customer')
            ->where('order_id', $this->orderId)
            ->where('customer_id', $customer->customer_id)
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.order-receipt', [
            'order' => $order,
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'order-receipt-' . $order->order_id . '.pdf');
    }

    public function render()
    {
        $customer = $this->getCustomer();
        
        if (!$customer) {
            abort(403, 'Customer record not found.');
        }

        $order = Order::with('orderItems.product', 'payment', 'customer')
            ->where('order_id', $this->orderId)
            ->where('customer_id', $customer->customer_id)
            ->firstOrFail();

        return view('livewire.customer.order-detail', [
            'order' => $order,
        ]);
    }
}
