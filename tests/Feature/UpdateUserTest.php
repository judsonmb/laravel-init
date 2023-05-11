<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UpdateUserTest extends TestCase
{
    public function test_success(): void
    {
        $user = User::factory()->create();

        $body = User::factory()->make()->toArray();

        $response = $this->actingAs($user)
                          ->withHeaders([
                                'Accept' => 'application/json',
                            ])
                          ->put('/api/users/'.$user->id, $body);
        
        $response->assertStatus(200);

        $response->assertJson(['message' => 'updated successfully!']);

        $this->assertDatabaseHas('users', [
            'name' => $body['name'],
            'email' => $body['email'],
        ]);
    }

    public function test_update_user_with_no_admin_user(): void
    {
        $user = User::factory()->create();

        $body = User::factory()->make()->toArray();

        $response = $this->actingAs($user)
                          ->withHeaders([
                                'Accept' => 'application/json',
                            ])
                          ->put('/api/users/'.$user->id, $body);
        
        $response->assertStatus(403);

        $response->assertJson(['message' => "You don't have permission to do it."]);
    }

    public function test_update_user_with_id_does_not_exist(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                          ->withHeaders([
                                'Accept' => 'application/json',
                            ])
                          ->put('/api/users/999999999999999999');
        
        $response->assertStatus(404);

        $response->assertJson(['message' => 'Record not found.']);
    }
}
