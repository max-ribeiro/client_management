<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Client;
use App\Models\Picture;
use App\Models\User;
use App\Services\ClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class VOIPTest extends TestCase
{
    use RefreshDatabase;
    public function test_should_make_a_call(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $mock = $this->createMock(ClientService::class);
        $clientData = Client::factory(1)->make();
        
        $mock->method('getClient')
            ->willReturn($clientData->first());
        
        $this->app->instance(ClientService::class, $mock);

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])->post('/api/voip/call/1');

        $response->assertStatus(200);
    }
}
