<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

# Sanctum
use Laravel\Sanctum\Sanctum;

# Model
use App\Models\User;

class NoteTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    private const HEADERS = [
        'Accept' => 'application/json',
    ];

    public function test_fetch_notes()
    {
        $this->seed();

        $user = User::first();

        Sanctum::actingAs($user);
        
        $this->get('api/note', self::HEADERS)->assertStatus(200);
    }

    public function test_create_note()
    {
        $this->seed();

        $user = User::first();

        Sanctum::actingAs($user);

        $this->post('api/note', [
            'title' => $this->faker->text(),
            'body'  => $this->faker->realText(500),
        ], self::HEADERS)
        ->assertStatus(200);
    }

    public function test_invalid_form_create_note()
    {
        $this->seed();

        $user = User::first();

        Sanctum::actingAs($user);

        $this->post('api/note', [
            'title' => null,
            'body'  => $this->faker->randomNumber(),
        ], self::HEADERS)
        ->assertStatus(422);
    }

    public function test_update_note()
    {
        $this->seed();

        $user = User::first();

        Sanctum::actingAs($user);
        
        // Create note first
        $note = $this->post('api/note', [
            'title' => $this->faker->text(),
            'body'  => $this->faker->realText(500),
        ], self::HEADERS)
        ->assertStatus(200)
        ->decodeResponseJson();

        $noteId = $note['id'];

        $this->put("api/note/$noteId", [
            'title' => $this->faker->text(),
            'body'  => $this->faker->realText(500),
        ], self::HEADERS)
        ->assertStatus(200);
    }

    public function test_invalid_form_update_note()
    {
        $this->seed();

        $user = User::first();

        Sanctum::actingAs($user);
        
        // Create note first
        $note = $this->post('api/note', [
            'title' => $this->faker->text(),
            'body'  => $this->faker->realText(500),
        ], self::HEADERS)
        ->assertStatus(200)
        ->decodeResponseJson();

        $noteId = $note['id'];

        $this->put("api/note/$noteId", [
            'title' => null,
            'body'  => null,
        ], self::HEADERS)
        ->assertStatus(422);
    }

    public function test_invalid_id_update_note()
    {
        $this->seed();

        $user = User::first();

        Sanctum::actingAs($user);

        $this->put('api/note/999', [
            'title' => null,
            'body'  => null,
        ], self::HEADERS)
        ->assertStatus(404);
    }

    public function test_delete_note()
    {
        $this->seed();

        $user = User::first();

        Sanctum::actingAs($user);

        // Create note first
        $note = $this->post('api/note', [
            'title' => $this->faker->text(),
            'body'  => $this->faker->realText(500),
        ], self::HEADERS)
        ->assertStatus(200)
        ->decodeResponseJson();

        $noteId = $note['id'];

        $this->delete("api/note/$noteId")->assertStatus(200)->assertJson([
            'deleted' => true,
        ]);
    }

    public function test_invalid_id_delete_note()
    {
        $this->seed();

        $user = User::first();

        Sanctum::actingAs($user);

        $this->delete('api/note/9999')->assertStatus(404);
    }
}
