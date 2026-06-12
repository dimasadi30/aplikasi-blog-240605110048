<?php

namespace App\Policies;

use App\Models\KategoriArtikel;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, KategoriArtikel $category)
    {
        return $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, KategoriArtikel $category)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, KategoriArtikel $category)
    {
        return $user->isAdmin();
    }
}
