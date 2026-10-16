<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $guarded = [];

    protected $casts = ['is_active' => 'boolean'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function imageUrl(): string
    {
        return $this->image ? asset('storage/'.$this->image) : asset('img/product-placeholder.png');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order');
    }
}
