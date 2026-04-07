<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Definisi atribut model Feedback
    protected $table = 'feedbacks';

    protected $fillable = [
        'id_aspirasi',
        'admin_id',
        'message'
    ];

    // Relasi dengan model Aspirasi untuk mendapatkan aspirasi terkait feedback ini
    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'id_aspirasi', 'id_aspirasi');
    }

    // Relasi dengan model User untuk mendapatkan admin yang memberikan feedback ini
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
