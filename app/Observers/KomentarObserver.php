<?php

namespace App\Observers;

use App\Models\Komentar;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class KomentarObserver
{
    public function created(Komentar $komentar)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'model_type' => 'Komentar',
            'model_id' => $komentar->id,
            'changes' => $komentar->getAttributes(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    
    public function updated(Komentar $komentar)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'model_type' => 'Komentar',
            'model_id' => $komentar->id,
            'changes' => [
                'old' => $komentar->getOriginal(),
                'new' => $komentar->getAttributes(),
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    
    public function deleted(Komentar $komentar)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'model_type' => 'Komentar',
            'model_id' => $komentar->id,
            'changes' => $komentar->getAttributes(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
