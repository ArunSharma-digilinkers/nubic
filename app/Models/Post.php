<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $casts = ['is_active' => 'boolean', 'published_at' => 'datetime'];

    public function scopePublished($q)
    {
        return $q->where('is_active', true)
            ->where(fn ($w) => $w->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->orderByDesc('published_at')->orderByDesc('id');
    }

    public function getSummaryAttribute(): string
    {
        return $this->excerpt ?: \Illuminate\Support\Str::limit(strip_tags((string) $this->content), 160);
    }
}
