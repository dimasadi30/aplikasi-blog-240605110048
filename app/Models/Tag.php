<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = [
        'nama_tag',
        'slug',
    ];

    public function artikel()
    {
        return $this->belongsToMany(Artikel::class, 'artikel_tag', 'tag_id', 'artikel_id');
    }
}
