<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\World;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class WorldControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_store_requires_authentication()
    {
        $response = $this->postJson('/api/worlds', ['name' => 'Narnia', 'desc' => 'Magic world']);
        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_store_world()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $response = $this->postJson('/api/worlds', ['name' => 'Narnia', 'desc' => 'Magic world']);
        $response->assertStatus(201)->assertJson(['message' => 'world created']);
        $this->assertDatabaseHas('worlds', [
            'name'    => 'Narnia',
            'user_id' => $user->getKey(),
        ]);
    }

    public function test_index_returns_users_worlds_only()
    {
        Sanctum::actingAs($user = User::factory()->create());
        World::factory(3)->for($user)->create();

        $otherUser = User::factory()->create();
        World::factory()->for($otherUser)->create();

        $response = $this->getJson('/api/world');
        $response->assertStatus(200)
            ->assertJsonCount(3, 'worlds');
    }
}
