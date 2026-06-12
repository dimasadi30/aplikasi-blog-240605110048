<?php

namespace App\Policies;

use App\Models\Komentar;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, Komentar $comment)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isPenulis()) {
            return $comment->artikel->id_penulis === $user->id;
        }
        
        return false;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'penulis', 'tamu']);
    }

    public function update(User $user, Komentar $comment)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return $comment->user_id === $user->id;
    }

    public function delete(User $user, Komentar $comment)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isPenulis()) {
            return $comment->artikel->id_penulis === $user->id;
        }
        
        return $comment->user_id === $user->id;
    }
}
