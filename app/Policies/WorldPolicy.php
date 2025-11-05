<?php

namespace App\Policies;

use App\Models\User;
use App\Models\World;

class WorldPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function createEntity(User $user, World $world): bool
    {
        return $user->getKey() === $world->user_id;
    }
}
