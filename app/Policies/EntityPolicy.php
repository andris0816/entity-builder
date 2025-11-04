<?php

namespace App\Policies;

use App\Models\Entity;
use App\Models\User;
use App\Models\World;

class EntityPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Entity $entity)
    {
        return $entity->world->user_id === $user->id;
    }
}
