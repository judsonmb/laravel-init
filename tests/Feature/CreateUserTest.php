<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CreateUserTest extends TestCase
{
    public function test_success(): void
    {
        $user = User::factory()->create();

        $body = User::factory()->make()->toArray();

        $body['password'] = 'password';
        $body['password_confirmation'] = 'password';

        $response = $this->actingAs($user)
                          ->withHeaders([
                                'Accept' => 'application/json',
                            ])
                          ->post('/api/users', $body);
        
        $response->assertStatus(200);

        $response->assertJson(['message' => 'created successfully!']);

        $this->assertDatabaseHas('users', [
            'name' => $body['name'],
            'email' => $body['email'],
        ]);
    }

    public function test_create_user_without_required_parameters(): void
    {
        $user = User::factory()->create();

        $body = [];

        $response = $this->actingAs($user)
                         ->withHeaders([
                            'Accept' => 'application/json',
                         ])
                         ->post('/api/users', $body);
        
        $response->assertStatus(422);

        $response->assertJson(
            [
                'message' => 'The full name field is required. (and 3 more errors)',
                'errors' => [
                    'name' => [
                        'The full name field is required.'
                    ],
                    'email' => [
                        'The email field is required.'
                    ],
                    'password' => [
                        'The password field is required.'
                    ]
                ]  
            ]
        );
    }
}
