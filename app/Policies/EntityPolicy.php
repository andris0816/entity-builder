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

    public function delete(User $user, Entity $entity): bool
    {
        return $this->hasOwnership($user, $entity);
    }

    public function update(User $user, Entity $entity): bool
    {
        return $this->hasOwnership($user, $entity);
    }

    protected function hasOwnership(User $user, Entity $entity): bool
    {
        return $entity->world->user_id === $user->getKey();
    }
}
