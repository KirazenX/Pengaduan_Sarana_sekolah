<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_aspirasi';
    protected $fillable = [
        'id_pelaporan',
        'id_kategori',
        'status'
    ];

    public function inputAspirasi()
    {
        return $this->belongsTo(InputAspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'id_aspirasi', 'id_aspirasi');
    }
}
