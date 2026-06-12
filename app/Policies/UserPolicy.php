<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $targetUser)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return $user->id === $targetUser->id;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $targetUser)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return $user->id === $targetUser->id;
    }

    public function delete(User $user, User $targetUser)
    {
        return $user->isAdmin();
    }

    public function changeRole(User $user)
    {
        return $user->isAdmin();
    }
}
