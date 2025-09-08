<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'tags',
        'featured_image',
        'is_published',
        'published_at',
        'user_id',
        'reading_time',
        'view_count'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'tags' => 'array', // Cast ke array untuk JSON field
    ];

    /**
     * Image fields that should be auto-deleted
     */
    protected $imageFields = ['featured_image'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (!$post->slug) {
                $post->slug = Str::slug($post->title);
            }

            // Calculate reading time (average 200 words per minute)
            $wordCount = str_word_count(strip_tags($post->content));
            $post->reading_time = max(1, ceil($wordCount / 200));
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && !$post->isDirty('slug')) {
                $post->slug = Str::slug($post->title);
            }

            // Recalculate reading time if content changed
            if ($post->isDirty('content')) {
                $wordCount = str_word_count(strip_tags($post->content));
                $post->reading_time = max(1, ceil($wordCount / 200));
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at');
    }

    public function scopeWithTag($query, $tag)
    {
        return $query->where('tags', 'like', '%"' . $tag . '"%');
    }

    // Accessors
    public function getFeaturedImageUrlAttribute()
    {
        return $this->getImageUrl('featured_image', asset('img/logo.png'));
    }

    public function getTagsArrayAttribute()
    {
        return $this->tags ?? [];
    }

    public function getTagsStringAttribute()
    {
        return $this->tags ? implode(', ', $this->tags) : '';
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getReadingTimeTextAttribute()
    {
        return $this->reading_time . ' min read';
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('view_count');
    }
}
