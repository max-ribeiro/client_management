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
     * Teste deve retornar json uma coleção vazia caso não existam clientes
     * @test
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
     * Sistema deve criar um novo cliente caso dados, endeço e foto sejam enviados
     * @test
     */   
    public function test_should_create_client_with_address_and_picture(): void
    {
        $payload = Client::factory()->raw([
            'address' => Address::factory()->raw(),
            'picture' => Picture::factory()->raw(),
        ]);
        unset($payload['address_id'], $payload['picture_id']);

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])->postJson('/api/v1/clients', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'name' => $payload['name'],
                     'email' => $payload['email'],
                 ]);

        $this->assertDatabaseHas('clients', ['email' => $payload['email']]);
        $this->assertDatabaseHas('addresses', ['street' => $payload['address']['street']]);
        $this->assertDatabaseHas('pictures', ['path' => $payload['picture']['path']]);
    }

    /**
     * Metodo show deve retornar um cliente especifo caso solicitado e ele exista
     * @test
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
     * Teste deve retornar erro 404 caso o cliente não exista/não foi criado
     * @test
     */
    public function test_should_return_404_if_client_not_found(): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])->getJson('/api/v1/clients/99999');

        $response->assertStatus(404);
    }

    /**
     * Update deve atualizar informção do usuario caso dado pra alteração tenha sido enviado
     * @test
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
     * Ao fazer um update no usuario o erro 404 deve ser retornado caso o usuario não exista
     * @test
     */
    public function test_should_return_404_if_client_not_found(): void
    {
        $update = ['name' => 'Updated'];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])->putJson("/api/v1/clients/99999", $update);

        $response->assertStatus(404);
    }

    /**
     * Teste deve deletar o client caso ele exista e o id foi enviado corretamente
     * @test
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

    /**
     * Teste deve retornar erro 404 caso tente deletar o cliente e o mesmo não existe
     */
    public function test_should_return_404_if_client_not_found(): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])->deleteJson('/api/v1/clients/99999');

        $response->assertStatus(404);
    }
}
