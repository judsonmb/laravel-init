<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    public function test_success(): void
    {
        $user = User::factory()->create();

        $body = [
            'email' => $user->email,
            'password' => 'password' 
        ];

        $response = $this->withHeaders([
                        'Accept' => 'application/json',
                    ])->post('/api/login', $body);

        $response->assertStatus(200);
    }

    public function test_login_without_password(): void
    {
        $user = User::factory()->create();

        $body = [
            'email' => $user->email 
        ];

        $response = $this->withHeaders([
                        'Accept' => 'application/json',
                    ])->post('/api/login', $body);

        $response->assertStatus(422);

        $response->assertJson(
            [
                'message' => 'The password field is required.',
                'errors' => [
                    'password' => [
                        'The password field is required.'
                    ]
                ]
            ]
        );
    }

    public function test_login_without_email(): void
    {
        $user = \App\Models\User::factory()->create();

        $body = [
            'password' => 'password' 
        ];

        $response = $this->withHeaders([
                        'Accept' => 'application/json',
                    ])->post('/api/login', $body);

        $response->assertStatus(422);

        $response->assertJson(
            [
                'message' => 'The email field is required.',
                'errors' => [
                    'email' => [
                        'The email field is required.'
                    ]
                ]
            ]
        );
    }
}
