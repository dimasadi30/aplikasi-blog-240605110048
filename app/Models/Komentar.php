<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Artikel;
use App\Models\User;

class Komentar extends Model
{
    use SoftDeletes;
    
    protected $table = 'komentar';
    protected $fillable = [
        'artikel_id',
        'user_id',
        'isi_komentar',
        'status',
        'nama_tamu',
        'email_tamu',
    ];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeSpam($query)
    {
        return $query->where('status', 'spam');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isSpam(): bool
    {
        return $this->status === 'spam';
    }
}
