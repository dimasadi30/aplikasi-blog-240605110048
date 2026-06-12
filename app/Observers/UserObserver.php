<?php

namespace App\Observers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function created(User $user)
    {
        ActivityLog::create([
            'user_id' => Auth::id() ?? $user->id,
            'action' => 'created_user',
            'model_type' => 'User',
            'model_id' => $user->id,
            'changes' => ['name' => $user->name, 'role' => $user->role, 'status' => $user->status],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    
    public function updated(User $user)
    {
        $action = 'updated_user';
        $changes = $user->getChanges();

        if ($user->wasChanged('status')) {
            if ($user->status === 'suspended') {
                $action = 'suspended_user';
            } elseif ($user->status === 'active') {
                $action = 'activated_user';
            }
        } elseif ($user->wasChanged('password') && count($changes) === 1) {
            // Password reset
            $action = 'reset_password';
        }

        ActivityLog::create([
            'user_id' => Auth::id() ?? $user->id,
            'action' => $action,
            'model_type' => 'User',
            'model_id' => $user->id,
            'changes' => [
                'name' => $user->name,
                'role' => $user->role,
                'status' => $user->status,
                'old' => array_intersect_key($user->getOriginal(), $changes),
                'new' => $changes,
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    
    public function deleted(User $user)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted_user',
            'model_type' => 'User',
            'model_id' => $user->id,
            'changes' => ['name' => $user->name, 'role' => $user->role],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
