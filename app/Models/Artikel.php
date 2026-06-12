<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\KategoriArtikel;
use App\Models\User;
use App\Models\Komentar;

class Artikel extends Model
{
    use SoftDeletes;
    
    protected $table = 'artikel';
    protected $fillable = [
        'id_penulis',
        'id_kategori',
        'judul',
        'slug',
        'isi',
        'gambar',
        'hari_tanggal',
        'status',
        'view_count',
        'search_count',
    ];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'id_penulis')->withTrashed();
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriArtikel::class, 'id_kategori');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'artikel_id');
    }

    public function scopeSearch($query, $searchTerm)
    {
        if (empty($searchTerm)) {
            return $query;
        }

        // Simple, reliable LIKE-based search
        $words = explode(' ', trim($searchTerm));
        return $query->where(function ($q) use ($words) {
            foreach ($words as $word) {
                if (!empty($word)) {
                    $q->orWhere('judul', 'like', '%' . $word . '%')
                      ->orWhere('isi', 'like', '%' . $word . '%');
                }
            }
        });
    }

    public function scopeWithRelevance($query, $searchTerm)
    {
        if (empty($searchTerm)) {
            return $query;
        }

        // Add relevance score based on match position
        // Title matches get higher score than content matches
        return $query->selectRaw('artikel.*, 
            CASE 
                WHEN judul LIKE ? THEN 10
                WHEN isi LIKE ? THEN 5
                ELSE 0
            END as relevance_score',
            ["%$searchTerm%", "%$searchTerm%"]
        )->orderBy('relevance_score', 'desc');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePendingReview($query)
    {
        return $query->where('status', 'pending_review');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function isPublished(): bool
    {
        return $this->status === 'publish';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isPendingReview(): bool
    {
        return $this->status === 'pending_review';
    }

    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }
}
