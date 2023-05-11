<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ReadUserTest extends TestCase
{
    public function test_success(): void
    {
        $user = User::factory()->create();

        $newUser = User::factory()->create();

        $response = $this->actingAs($user)
                          ->withHeaders([
                                'Accept' => 'application/json',
                            ])
                          ->get('/api/users/'.$newUser->id);
        
        $response->assertStatus(200);

        $response->assertJson(
            [
                'data' => [
                    [
                        'id' => $newUser->id,
                        'name' => $newUser->name,
                        'email' => $newUser->email,
                        'orders' => []
                    ]
                ]
            ]
        );
    }

    public function test_read_user_with_id_does_not_exist(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                          ->withHeaders([
                                'Accept' => 'application/json',
                            ])
                          ->get('/api/users/999999999999999999');
        
        $response->assertStatus(200);

        $response->assertJson(['data' => []]);
    }
}
