<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Client;
use App\Models\Picture;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;

use Tests\TestCase;

class ClientTest extends TestCase
{
    
    use DatabaseTransactions;
    /**
     * Testes API e Autenticação JWT
     *
     * @return void
     */
    public function test_should_return_unauthorized_if_token_not_sent(): void
    {
        $response = $this->get('/api/v1/client');

        $response->assertStatus(403);
    }
    public function test_should_create_new_client_if_authenticated_and_data_is_valid(): void
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $clientData = Client::factory(1)->raw([
            'address' => Address::factory(1)->raw()[0],
            'picture' => Picture::factory(1)->raw()[0]
        ]);
        unset($clientData['address_id'], $clientData['picture_id']);
        $payload = $clientData[0];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])
        ->postJson('/api/v1/client', $payload);
        
        $response->assertStatus(201);
    }

    public function test_should_fail_if_authenticated_and_address_not_sent(): void
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $clientData = Client::factory(1)->raw([
            'picture' => Picture::factory(1)->raw()[0]
        ]);
        unset($clientData['address_id'], $clientData['picture_id']);
        $payload = $clientData[0];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])
        ->postJson('/api/v1/client', $payload);
        
        $response->assertStatus(500);
    }   
}
