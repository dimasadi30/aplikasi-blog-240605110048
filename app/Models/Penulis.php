<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Penulis extends Model
{
    protected $table = 'penulis';
    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'user_name',
        'password',
        'foto',
    ];
    protected $hidden = [
        'password',
    ];
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_penulis');
    }

}