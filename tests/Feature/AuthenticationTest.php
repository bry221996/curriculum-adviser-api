<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @group auth
     */
    public function test_successful_login_user()
    {
        $user = User::factory()->create();

        $this->postJson('/api/v1/auth/login', ['email' => $user->email, 'password' => 'password'])
            ->assertSuccessful()
            ->assertJsonFragment(['status' => true])
            ->assertJsonStructure([
                'status',
                'data' => ['user', 'access_token']
            ]);
    }

    /**
     * @group auth
     */
    public function test_failed_login_non_existing_user()
    {
        $this->postJson('/api/v1/auth/login', ['email' => $this->faker->email, 'password' => 'password'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    /**
     * @group auth
     */
    public function test_failed_login_user_with_wrong_password()
    {
        $user = User::factory()->create();

        $this->postJson('/api/v1/auth/login', ['email' => $user->email, 'password' => 'wrong_password'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }
}
