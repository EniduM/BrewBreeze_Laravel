<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $customer;
    public $orderItems;
    public $subtotal;
    public $discountAmount;
    public $shippingCost;
    public $total;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order->load('orderItems.product', 'customer');
        $this->customer = $order->customer;
        $this->orderItems = $order->orderItems;
        
        // Calculate totals
        $this->subtotal = $this->orderItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        
        $this->discountAmount = $this->customer->getSubscriptionDiscount() > 0 
            ? round($this->subtotal * ($this->customer->getSubscriptionDiscount() / 100), 2)
            : 0;
            
        $this->shippingCost = $this->customer->getsFreeShipping() ? 0 : 10.00;
        $this->total = $order->total;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation - Order #' . $this->order->order_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation',
            text: 'emails.order-confirmation-text',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
