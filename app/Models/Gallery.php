<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'title',
        'description',
        'image',
        'event_name',
        'event_date',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'event_date' => 'date'
    ];

    /**
     * Image fields that should be auto-deleted
     */
    protected $imageFields = ['image'];

    /**
     * Get gallery image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->getImageUrl('image');
    }
}
