<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $guarded = [];

    protected $casts = ['is_active' => 'boolean'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeTopLevel($q)
    {
        return $q->whereNull('parent_id');
    }

    /** This category's id plus its sub-category ids (used to list a parent's products). */
    public function familyIds(): array
    {
        return self::where('parent_id', $this->id)->pluck('id')->prepend($this->id)->all();
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
