<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function itCanRegisterAnUser(): void
    {
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password(),
        ];

        $response = $this->post(route('api.register'), $data, [
            'Accept' => 'application/json',
        ]);

        $response->assertJsonMissingValidationErrors();
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'The user was created successfully',
            'user' => [
                'name' => $data['name'],
                'email' => $data['email'],
            ],
        ]);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    /** @test */
    public function itCanValidatedWhenRegisterAnUser(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => '',
            'email' => $user->email,
            'password' => '',
        ];

        $response = $this->post(route('api.register'), $data, [
            'Accept' => 'application/json',
        ]);

        $response->assertJsonValidationErrors(['name', 'email', 'password']);
        $response->assertStatus(422);
    }
}
