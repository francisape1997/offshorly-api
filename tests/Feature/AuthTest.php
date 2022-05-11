<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    private const HEADERS = [
        'Accept' => 'application/json',
    ];

    public function test_login()
    {
        $password = 'secret';
        $email    = 'testing@gmail.com';

        // Register First
        $this->post('api/register', [
            'first_name'            => 'Francis',
            'last_name'             => 'Ape',
            'email'                 => $email,
            'password'              => $password,
            'password_confirmation' => $password,

        ], self::HEADERS)
        ->assertStatus(200);

        // Login
        $this->post('api/login', [
            'email'    => $email,
            'password' => $password,

        ], self::HEADERS)
        ->assertStatus(200);
    }

    public function test_non_existing_user_login()
    {
        $this->post('api/login', [
            'email'    => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password()
        ], self::HEADERS)
        ->assertStatus(404);
    }

    public function test_invalid_form_login()
    {
        $this->post('api/login', [
            'email'    => $this->faker->randomNumber(),
            'password' => null,
        ], self::HEADERS)
        ->assertStatus(422);
    }

    public function test_logout()
    {
        $password = 'secret';
        $email    = 'testing@gmail.com';

        // Register First
        $this->post('api/register', [
            'first_name'            => 'Francis',
            'last_name'             => 'Ape',
            'email'                 => $email,
            'password'              => $password,
            'password_confirmation' => $password,

        ], self::HEADERS)
        ->assertStatus(200);

        // Login
        $auth = $this->post('api/login', [
            'email'    => $email,
            'password' => $password,
        ], self::HEADERS)
        ->assertStatus(200)
        ->decodeResponseJson();

        $token = $auth['token'];

        // Logout
        $this->post('api/logout', [],
        [
            ...self::HEADERS,
            'Authorization' => "Bearer $token",
        ])
        ->assertStatus(200)
        ->assertJson([
            'logout' => true,
        ]);
    }
}
