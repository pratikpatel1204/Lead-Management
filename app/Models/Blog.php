<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'author_name',
        'short_description',
        'description',
        'image',
        'status',
    ];

    // Auto-generate slug if not provided
    protected static function boot()
    {
        parent::boot();

        // Generate slug on create
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title) . '-' . time();
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title')) {
                $blog->slug = Str::slug($blog->title) . '-' . time();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
}
