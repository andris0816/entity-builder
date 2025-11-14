<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\World;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EntityControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_user_can_create_entity_in_own_world()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $world = World::factory()->create(['user_id' => $user->getKey()]);
        $response = $this->postJson('/api/entity', [
            'name' => 'Gandalf',
            'desc' => 'Gandalf is a wizard.',
            'type' => 'Character',
            'world_id' => $world->getKey(),
        ]);

        $response->assertStatus(201)->assertJson([
            'name' => 'Gandalf',
        ]);
    }

    public function test_user_can_not_create_entity_in_other_world()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $otherUser = User::factory()->create();
        $otherWorld = World::factory()->for($otherUser)->create();
        $response = $this->postJson('/api/entity', [
            'name'     => 'Harry',
            'desc'     => 'Wizard',
            'type'     => 'Character',
            'world_id' => $otherWorld->getKey(),
        ]);
        $response->assertStatus(403);
    }

    public function test_update_entity_requires_ownership()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $world = World::factory()->for($user)->create();

        $entity = $world->entities()->create([
            'name' => 'Legolas',
            'desc' => 'Elf',
            'type' => 'Character',
        ]);
        $response = $this->patchJson("/api/entity/{$entity->getKey()}", [
            'name' => 'Legolas Greenleaf',
            'desc' => 'Elf Prince',
            'type' => 'Character',
        ]);
        $response->assertOk();
        $this->assertDatabaseHas('entities', [
            'id' => $entity->getKey(),
            'name' => 'Legolas Greenleaf',
        ]);
    }
}
