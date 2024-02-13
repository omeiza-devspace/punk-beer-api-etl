<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('db:seed');
    }


    public function it_authenticates_a_user_and_returns_a_token()
    {
        $user = User::factory()->create();
        $data = [
            'email' => $user->email,
            'password' => 'password', 
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }


    public function it_logs_out_a_authenticated_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;

        $response = $this->actingAs($user)
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Tokens revoked']);
    }


    public function it_refreshes_a_token_for_authenticated_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;

        $response = $this->actingAs($user)
            ->postJson('/api/refresh');

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }


    public function it_returns_authenticated_user_details()
    {
        $user = User::factory()->create();
        $token = $user->createToken('testToken')->plainTextToken;

        $response = $this->actingAs($user)
            ->postJson('/api/user');

        $response->assertStatus(200)
            ->assertJson(['email' => $user->email]); 
    }

    public function it_registers_a_new_user_and_returns_a_token()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);

        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }

    public function it_requires_authentication_to_refresh_token()
    {
        $response = $this->postJson('/api/refresh');

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function it_requires_a_valid_password_for_registration()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'short', // Invalid password (less than 8 characters)
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }


    public function it_does_not_allow_duplicate_email_registration()
    {
        $existingUser = User::factory()->create();
        $userData = [
            'name' => 'John Doe',
            'email' => $existingUser->email,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function it_does_not_refresh_token_for_unauthenticated_user()
    {
        $response = $this->postJson('/api/refresh');

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function it_requires_name_for_registration()
    {
        $userData = [
            'email' => 'john@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }


    public function it_requires_email_for_registration()
    {
        $userData = [
            'name' => 'John Doe',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }


    public function it_requires_valid_email_for_registration()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

}
