<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Client;
use App\Models\Picture;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReportTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_should_return_chart_data(): void
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $clientData = Client::factory(10)->create([
            'address_id' => Address::factory(1)->create()[0]->id,
            'picture_id' => Picture::factory(1)->create()[0]->id
        ]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}"
        ])
        ->get('/api/reports');

        $response->assertStatus(200);
    }
}
