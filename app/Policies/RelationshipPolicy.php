<?php

namespace App\Policies;

use App\Models\Relationship;
use App\Models\User;

class RelationshipPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Relationship $relationship): bool
    {
        return $this->hasOwnership($user, $relationship);
    }

    public function update(User $user, Relationship $relationship): bool
    {
        return $this->hasOwnership($user, $relationship);
    }

    protected function hasOwnership(User $user, Relationship $relationship): bool
    {
        return $relationship->world?->user_id === $user->getKey();
    }
}
