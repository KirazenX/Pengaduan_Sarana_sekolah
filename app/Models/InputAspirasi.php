<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    // Definisi atribut model InputAspirasi
    protected $table = 'input_aspirasi';
    protected $primaryKey = 'id_pelaporan';
    protected $fillable = [
        'nis',
        'id_kategori',
        'lokasi',
        'keterangan',
        'gambar'
    ];

    // Relasi dengan model User untuk mendapatkan siswa yang membuat aspirasi ini
    public function siswa()
    {
        return $this->belongsTo(User::class, 'nis', 'nis');
    }

    // Relasi dengan model Category untuk mendapatkan kategori aspirasi
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }

    // Relasi dengan model Aspirasi untuk mendapatkan semua aspirasi yang terkait dengan input aspirasi ini
    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }
}
