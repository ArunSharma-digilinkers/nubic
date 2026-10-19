<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductController extends ResourceController
{
    protected string $model = Product::class;

    protected string $route = 'products';

    protected string $title = 'Products';

    protected string $singular = 'Product';

    protected array $searchable = ['name'];

    protected function query(): Builder
    {
        return Product::with('category')->withCount('variants');
    }

    protected function fields(): array
    {
        return [
            ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'col' => 6, 'rules' => 'required|exists:categories,id',
                'options' => Category::with('parent')->orderBy('sort_order')->get()->mapWithKeys(fn ($c) => [$c->id => $c->parent ? $c->parent->name.' › '.$c->name : $c->name])->all()],
            ['name' => 'name', 'label' => 'Product Name', 'type' => 'text', 'col' => 6, 'rules' => 'required|string|max:255'],
            ['name' => 'slug', 'label' => 'Slug (auto if empty)', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'editor', 'rules' => 'nullable|string'],
            ['name' => 'features', 'label' => 'Features (one per line)', 'type' => 'textarea', 'rules' => 'nullable|string'],
            ['name' => 'specs', 'label' => 'Specifications (one "Label: value" per line)', 'type' => 'textarea', 'rules' => 'nullable|string'],
            ['name' => 'image', 'label' => 'Product Image', 'type' => 'image'],
            ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 4, 'default' => 0, 'rules' => 'nullable|integer'],
            ['name' => 'is_featured', 'label' => 'Featured on Home', 'type' => 'checkbox', 'col' => 4],
            ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox', 'col' => 4],
        ];
    }

    protected function columns(): array
    {
        return [
            ['name' => 'image', 'label' => 'Image', 'type' => 'image'],
            ['name' => 'name', 'label' => 'Name'],
            ['name' => 'category.name', 'label' => 'Category'],
            ['name' => 'variants_count', 'label' => 'Variants'],
            ['name' => 'is_featured', 'label' => 'Featured', 'type' => 'status'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'status'],
        ];
    }

    protected function formData(?Model $item): array
    {
        return ['extra' => 'admin.products._variants'];
    }

    protected function afterSave(Model $item, Request $request): void
    {
        $rows = collect($request->input('variants', []))
            ->filter(fn ($r) => filled($r['code'] ?? null) || filled($r['rating'] ?? null))
            ->values();

        $item->variants()->delete();
        foreach ($rows as $i => $r) {
            $item->variants()->create([
                'code' => ($r['code'] ?? null) ?: null,
                'rating' => ($r['rating'] ?? null) ?: null,
                'spec' => ($r['spec'] ?? null) ?: null,
                'packing' => ($r['packing'] ?? null) ?: null,
                'mrp' => is_numeric($r['mrp'] ?? null) ? $r['mrp'] : null,
                'mrp_enclosure' => is_numeric($r['mrp_enclosure'] ?? null) ? $r['mrp_enclosure'] : null,
                'sort_order' => $i,
            ]);
        }
    }
}
