<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ArticlePolicy;
use App\Policies\CommentPolicy;
use App\Policies\UserPolicy;
use App\Policies\CategoryPolicy;
use App\Models\Artikel;
use App\Models\Komentar;
use App\Models\User;
use App\Models\KategoriArtikel;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Artikel::class => ArticlePolicy::class,
        Komentar::class => CommentPolicy::class,
        User::class => UserPolicy::class,
        KategoriArtikel::class => CategoryPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
