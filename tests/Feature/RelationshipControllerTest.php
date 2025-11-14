<?php

namespace Tests\Feature;

use App\Models\Entity;
use App\Models\Relationship;
use App\Models\User;
use App\Models\World;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RelationshipControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_user_can_create_relationship_in_own_world()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $world = World::factory()->for($user)->create();

        $entityOne = Entity::factory()->for($world)->create();
        $entityTwo = Entity::factory()->for($world)->create();

        $response = $this->postJson('/api/relationship', [
           'source' => $entityOne->getKey(),
           'target' => $entityTwo->getKey(),
           'type' => 'Allies with',
           'desc' => 'These 2 know each other.'
        ]);

        $response->assertStatus(201)->assertJson([
            'source' => $entityOne->getKey(),
            'target' => $entityTwo->getKey(),
        ]);
    }

    public function test_relationship_already_exists()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $world = World::factory()->for($user)->create();

        $entityOne = Entity::factory()->for($world)->create();
        $entityTwo = Entity::factory()->for($world)->create();

        $this->postJson('/api/relationship', [
            'source' => $entityOne->getKey(),
            'target' => $entityTwo->getKey(),
            'type' => 'Allies with',
            'desc' => 'These 2 know each other.'
        ]);

        $response = $this->postJson('/api/relationship', [
            'source' => $entityOne->getKey(),
            'target' => $entityTwo->getKey(),
            'type' => 'Allies with',
            'desc' => 'These 2 know each other.'
        ])->assertStatus(422);
    }

    public function test_user_cannot_update_relationship_they_not_own()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $world = World::factory()->for($user)->create();

        $entityOne = Entity::factory()->for($world)->create();
        $entityTwo = Entity::factory()->for($world)->create();

        $relationship = Relationship::factory()->create(['source' => $entityOne->getKey(), 'target' => $entityTwo->getKey()]);
        Sanctum::actingAs($otherUser = User::factory()->create());

        $this->patchJson('/api/relationship/' . $relationship->getKey(), [
            'source' => $entityOne->getKey(),
            'target' => $entityTwo->getKey(),
            'type' => 'Allies with',
            'desc' => 'These 2 know each other. (Updated)'
        ])->assertStatus(403);
    }
}
