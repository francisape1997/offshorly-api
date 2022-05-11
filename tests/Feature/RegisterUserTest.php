<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    private const HEADERS = [
        'Accept' => 'application/json',
    ];

    public function test_normal_register_user()
    {
        $password = $this->faker->password();

        $this->post('api/register', [
            'first_name'            => $this->faker->firstName(),
            'last_name'             => $this->faker->lastName(),
            'email'                 => $this->faker->email(),
            'password'              => $password,
            'password_confirmation' => $password,

        ], self::HEADERS)
        ->assertStatus(200);
    }

    public function test_invalid_form_register_user()
    {
        $password = $this->faker->password();

        $this->post('api/register', [
            'first_name'            => $this->faker->randomNumber(),
            'last_name'             => $this->faker->randomNumber(),
            'email'                 => $this->faker->firstName(),
            'password'              => $password,
            'password_confirmation' => $password,

        ], self::HEADERS)
        ->assertStatus(422);
    }

    public function test_invalid_password_confirmation_register_user()
    {
        $this->post('api/register', [
            'first_name'            => $this->faker->firstName(),
            'last_name'             => $this->faker->lastName(),
            'email'                 => $this->faker->email(),
            'password'              => $this->faker->password(),
            'password_confirmation' => $this->faker->password(),

        ], self::HEADERS)
        ->assertStatus(422);
    }

    public function test_empty_body_register_user()
    {
        $this->post('api/register', [], self::HEADERS)->assertStatus(422);
    }
}
