<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends ResourceController
{
    protected string $model = Category::class;
    protected string $route = 'categories';
    protected string $title = 'Product Categories';
    protected string $singular = 'Category';
    protected string $orderBy = 'sort_order';
    protected string $orderDir = 'asc';

    /** Tree view: each main category followed by its sub-categories. */
    public function index(Request $request): View
    {
        $tree = Category::withCount('products')->whereNull('parent_id')->orderBy('sort_order')->get();
        $subs = Category::withCount('products')->whereNotNull('parent_id')->orderBy('sort_order')->get()->groupBy('parent_id');
        $tree->each(fn ($c) => $c->setRelation('subs', $subs->get($c->id, collect())));

        return view('admin.categories.index', ['tree' => $tree, 'meta' => $this->meta()]);
    }

    protected function query(): Builder
    {
        return Category::with('parent')->withCount('products');
    }

    protected function fields(): array
    {
        return [
            ['name' => 'parent_id', 'label' => 'Parent Category (leave empty for a main category)', 'type' => 'select', 'rules' => 'nullable|exists:categories,id', 'default' => request('parent'),
                'options' => Category::topLevel()->orderBy('sort_order')->pluck('name', 'id')->all()],
            ['name' => 'name', 'label' => 'Category Name', 'type' => 'text', 'rules' => 'required|string|max:255'],
            ['name' => 'slug', 'label' => 'Slug (auto if empty)', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rules' => 'nullable|string'],
            ['name' => 'image', 'label' => 'Image', 'type' => 'image'],
            ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 6, 'default' => 0, 'rules' => 'nullable|integer'],
            ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox', 'col' => 6],
        ];
    }

    protected function columns(): array
    {
        return [
            ['name' => 'image', 'label' => 'Image', 'type' => 'image'],
            ['name' => 'name', 'label' => 'Name'],
            ['name' => 'parent.name', 'label' => 'Parent'],
            ['name' => 'products_count', 'label' => 'Products'],
            ['name' => 'sort_order', 'label' => 'Order'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'status'],
        ];
    }
}
