<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = ['is_active' => 'boolean', 'is_featured' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class)->orderBy('sort_order');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order');
    }

    public function featureList(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $this->features))));
    }

    /** "Label: value" lines from the specs field, as [label => value]. */
    public function specList(): array
    {
        $specs = [];
        foreach (preg_split('/\R/', (string) $this->specs) as $line) {
            [$label, $value] = array_pad(array_map('trim', explode(':', $line, 2)), 2, '');
            if ($label !== '' && $value !== '') {
                $specs[$label] = $value;
            }
        }

        return $specs;
    }

    public function imageUrl(): string
    {
        return $this->image ? asset('storage/'.$this->image) : asset('img/product-placeholder.png');
    }

    /** Distinct ratings across variants, e.g. ["6 to 32A", "40A", "63A"]. */
    public function ratingList(): array
    {
        return $this->variants->pluck('rating')->filter()->unique()->values()->all();
    }

    /**
     * Catalogue names read "Family - Version" (e.g. "Isolator - Double Pole"); products in the
     * same category sharing the family part are offered as versions of one another.
     */
    public function familyName(): string
    {
        return trim(Str::before($this->name, ' - '));
    }

    public function versionName(): string
    {
        return Str::contains($this->name, ' - ') ? trim(Str::after($this->name, ' - ')) : $this->name;
    }

    public function versions(): Collection
    {
        if (! Str::contains($this->name, ' - ')) {
            return new Collection;
        }

        return static::active()
            ->where('category_id', $this->category_id)
            ->where('name', 'like', $this->familyName().' - %')
            ->get();
    }
}
