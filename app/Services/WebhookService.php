<?php

namespace App\Services;
use Spatie\WebhookServer\WebhookCall;

class WebhookService {
    public function send(array $data) {
        WebhookCall::create()
            ->url(config('webhook-server.url'))
            ->payload($data)
            ->useSecret(config('webhook-server.secret'))
            ->dispatch();
    }
}