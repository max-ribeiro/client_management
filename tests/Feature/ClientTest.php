<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    
    use DatabaseTransactions;
    
    public function test_should_create_new_client_if_valid_data_provided(): void
    {
        $response = $this->post('/api/client', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => [
                'street' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'California',
                'neighborhood' => 'Downtown',
                'number' => 456,
            ],
            'picture' => [
                'content' => 'jaklsdjasdsasads',
            ],
            'age' => 30,
        ]);

        $response->assertStatus(201);
    }
    public function test_should_thow_exception_if_client_address_data_is_invalid(): void
    {
        $response = $this->post('/api/client', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => [
                'street' => null,
                'city' => null,
                'state' => null,
                'neighborhood' => null,
                'number' => null,
            ],
            'picture' => [
                'content' => 'jaklsdjasdsasads',
            ],
            'age' => 30,
        ]);
        $response->assertStatus(500);
    }
}
