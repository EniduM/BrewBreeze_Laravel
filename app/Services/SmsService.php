<?php

namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->from = config('services.twilio.from');
    }

    public function send($to, $message)
    {
        return $this->client->messages->create($to, [
            'from' => $this->from,
            'body' => $message,
        ]);
    }
}
