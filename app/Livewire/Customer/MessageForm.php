<?php

namespace App\Livewire\Customer;

use App\Models\Message;
use Livewire\Component;

class MessageForm extends Component
{
    public $subject = '';
    public $description = '';

    protected $rules = [
        'subject' => 'required|string|max:255',
        'description' => 'required|string|min:10',
    ];

    protected $messages = [
        'subject.required' => 'Please enter a subject for your message.',
        'subject.max' => 'Subject cannot exceed 255 characters.',
        'description.required' => 'Please enter a message description.',
        'description.min' => 'Message description must be at least 10 characters.',
    ];

    public function getCustomer()
    {
        return auth()->user()->getOrCreateCustomer();
    }

    public function sendMessage()
    {
        $this->validate();

        $customer = $this->getCustomer();
        
        if (!$customer) {
            session()->flash('error', 'Unable to access customer account.');
            return;
        }

        Message::create([
            'customer_id' => $customer->customer_id,
            'subject' => $this->subject,
            'description' => $this->description,
            'date' => now(),
        ]);

        session()->flash('message', 'Message sent successfully! We will get back to you soon.');
        $this->reset(['subject', 'description']);
    }

    public function render()
    {
        return view('livewire.customer.message-form');
    }
}
