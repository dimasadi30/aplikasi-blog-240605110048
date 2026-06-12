<?php

namespace App\Policies;

use App\Models\Artikel;
use App\Models\User;

class ArticlePolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'penulis']);
    }

    public function view(User $user, Artikel $article)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isPenulis()) {
            return $article->id_penulis === $user->id;
        }
        
        return false;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'penulis']);
    }

    public function update(User $user, Artikel $article)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isPenulis()) {
            return $article->id_penulis === $user->id;
        }
        
        return false;
    }

    public function delete(User $user, Artikel $article)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isPenulis()) {
            return $article->id_penulis === $user->id;
        }
        
        return false;
    }

    public function publish(User $user, Artikel $article)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isPenulis()) {
            return $article->id_penulis === $user->id;
        }
        
        return false;
    }
}
