<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    protected $table = 'input_aspirasi';
    protected $primaryKey = 'id_pelaporan';
    protected $fillable = [
        'nis',
        'id_kategori',
        'lokasi',
        'keterangan',
        'gambar'
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'nis', 'nis');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }

    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }
}
