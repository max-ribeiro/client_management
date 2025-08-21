<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Client;
use App\Models\Picture;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class ClientIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);
    }

    /** 
     * Deve retornar uma coleção vazia caso não existam clientes
     */
    public function test_should_return_empty_list_when_no_clients(): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])->getJson('/api/v1/clients');

        $response->assertStatus(200)
                 ->assertJsonCount(0);
    }

    /**
     * Deve retornar um cliente específico caso exista
     */
    public function test_should_return_client_when_exists(): void
    {
        $client = Client::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])->getJson("/api/v1/clients/{$client->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $client->id]);
    }

    /**
     * Deve retornar 404 caso o cliente não exista
     */
    public function test_should_return_404_if_client_not_found(): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])->getJson('/api/v1/clients/99999');

        $response->assertStatus(404);
    }

    /**
     * Deve atualizar informações do cliente
     */
    public function test_should_modify_client_data(): void
    {
        $client = Client::factory()->create();
        $update = ['name' => 'Updated Name'];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])->putJson("/api/v1/clients/{$client->id}", $update);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('clients', ['id' => $client->id, 'name' => 'Updated Name']);
    }


    /**
     * Deve deletar o cliente caso exista
     */
    public function test_should_delete_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])->deleteJson("/api/v1/clients/{$client->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Client deleted successfully']);

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
