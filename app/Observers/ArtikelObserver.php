<?php

namespace App\Observers;

use App\Models\Artikel;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ArtikelObserver
{
    public function created(Artikel $artikel)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created_article',
            'model_type' => 'Artikel',
            'model_id' => $artikel->id,
            'changes' => ['judul' => $artikel->judul, 'status' => $artikel->status],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    
    public function updated(Artikel $artikel)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated_article',
            'model_type' => 'Artikel',
            'model_id' => $artikel->id,
            'changes' => [
                'judul' => $artikel->judul,
                'status' => $artikel->status,
                'old' => array_intersect_key($artikel->getOriginal(), $artikel->getChanges()),
                'new' => $artikel->getChanges(),
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    
    public function deleted(Artikel $artikel)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted_article',
            'model_type' => 'Artikel',
            'model_id' => $artikel->id,
            'changes' => ['judul' => $artikel->judul],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
