<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Image fields that should be auto-deleted
     */
    protected $imageFields = ['icon', 'image'];

    /**
     * Get division icon URL
     */
    public function getIconUrlAttribute()
    {
        return $this->getImageUrl('icon');
    }

    /**
     * Get division main image URL
     */
    public function getDivisionImageUrlAttribute()
    {
        return $this->getImageUrl('image');
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
