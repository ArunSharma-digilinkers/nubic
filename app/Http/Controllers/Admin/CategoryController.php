<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends ResourceController
{
    protected string $model = Category::class;
    protected string $route = 'categories';
    protected string $title = 'Product Categories';
    protected string $singular = 'Category';
    protected string $orderBy = 'sort_order';
    protected string $orderDir = 'asc';

    protected function query(): Builder
    {
        return Category::withCount('products');
    }

    protected function fields(): array
    {
        return [
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
            ['name' => 'products_count', 'label' => 'Products'],
            ['name' => 'sort_order', 'label' => 'Order'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'status'],
        ];
    }
}
