<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\WebhookServer\WebhookCall;
use Tests\TestCase;

class WeebhookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        WebhookCall::create()
            ->url(config('webhook-server.url'))
            ->payload(['key' => 'value'])
            ->useSecret('sign-using-this-secret')
            ->dispatch();

        $response->assertStatus(200);
    }
}
