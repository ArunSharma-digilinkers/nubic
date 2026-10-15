<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;

class PageController extends ResourceController
{
    protected string $model = Page::class;
    protected string $route = 'pages';
    protected string $title = 'Pages';
    protected string $singular = 'Page';
    protected array $searchable = ['title', 'slug'];

    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
            ['name' => 'slug', 'label' => 'Slug (auto if empty)', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            ['name' => 'content', 'label' => 'Content', 'type' => 'editor', 'rules' => 'nullable|string'],
            ['name' => 'image', 'label' => 'Banner / Image', 'type' => 'image'],
            ['name' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rules' => 'nullable|string|max:500'],
            ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox'],
        ];
    }

    protected function columns(): array
    {
        return [
            ['name' => 'title', 'label' => 'Title'],
            ['name' => 'slug', 'label' => 'URL', 'type' => 'slug'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'status'],
        ];
    }
}
