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

    public function update(User $user, World $world): bool
    {
        return $this->hasOwnership($user, $world);
    }

    public function destroy(User $user, World $world): bool
    {
        return $this->hasOwnership($user, $world);
    }

    public function createEntity(User $user, World $world): bool
    {
        return $this->hasOwnership($user, $world);
    }

    protected function hasOwnership(User $user, World $world): bool
    {
        return $user->getKey() === $world->user_id;
    }
}
