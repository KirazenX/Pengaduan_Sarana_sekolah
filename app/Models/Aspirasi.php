<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    // Definisi atribut model Aspirasi
    protected $primaryKey = 'id_aspirasi';
    protected $fillable = [
        'id_pelaporan',
        'id_kategori',
        'status'
    ];

    // Relasi dengan model InputAspirasi, Category, dan Feedback
    public function inputAspirasi()
    {
        return $this->belongsTo(InputAspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }

    // Relasi dengan model Category untuk mendapatkan kategori aspirasi
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }

    // Relasi dengan model Feedback untuk mendapatkan feedback terkait aspirasi
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'id_aspirasi', 'id_aspirasi');
    }
}
