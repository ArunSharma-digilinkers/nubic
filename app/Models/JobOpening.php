<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOpening extends Model
{
    protected $guarded = [];

    protected $casts = ['is_active' => 'boolean', 'closing_date' => 'date'];

    public function scopeActive($q)
    {
        return $q->where('is_active', true)
            ->where(fn ($w) => $w->whereNull('closing_date')->orWhere('closing_date', '>=', today()))
            ->orderBy('sort_order')->latest();
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
