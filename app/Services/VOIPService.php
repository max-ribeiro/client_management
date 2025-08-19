<?php

namespace App\Services;
use Twilio\Rest\Client;


class VOIPService {
    private Client $twilio;
    public function __construct()
    {
        $this->twilio = new Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );
    }

    /**
     * Calls a especific number
     *
     * @param string $to
     * @return string
     */
    public function call(string $to): string
    {
        $call = $this->twilio->calls->create(
            '5512996110767',
            env('TWILIO_PHONE_NUMBER'),
            ["url" => "http://demo.twilio.com/docs/voice.xml"]
        );

        return $call->sid;
    }
}