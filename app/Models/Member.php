<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nim',
        'email',
        'phone',
        'photo',
        'batch',
        'position', // UBAH JADI STRING BIASA
        'division_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // HAPUS RELASI POSITION INI
    // public function position()
    // {
    //     return $this->belongsTo(Position::class);
    // }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('img/default-avatar.jpg');
    }
}
