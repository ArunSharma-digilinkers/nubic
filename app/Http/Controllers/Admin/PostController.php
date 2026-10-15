<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PostController extends ResourceController
{
    protected string $model = Post::class;
    protected string $route = 'posts';
    protected string $title = 'Blog Posts';
    protected string $singular = 'Post';
    protected array $searchable = ['title', 'author'];

    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
            ['name' => 'slug', 'label' => 'Slug (auto if empty)', 'type' => 'text', 'col' => 6, 'rules' => 'nullable|string|max:255'],
            ['name' => 'author', 'label' => 'Author', 'type' => 'text', 'col' => 6, 'rules' => 'nullable|string|max:255'],
            ['name' => 'excerpt', 'label' => 'Short Excerpt', 'type' => 'textarea', 'rules' => 'nullable|string|max:500'],
            ['name' => 'content', 'label' => 'Content', 'type' => 'editor', 'rules' => 'nullable|string'],
            ['name' => 'image', 'label' => 'Featured Image', 'type' => 'image'],
            ['name' => 'published_at', 'label' => 'Publish Date (YYYY-MM-DD, blank = now)', 'type' => 'text', 'col' => 6, 'rules' => 'nullable|date'],
            ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 6],
            ['name' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            ['name' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rules' => 'nullable|string|max:500'],
        ];
    }

    protected function columns(): array
    {
        return [
            ['name' => 'image', 'label' => 'Image', 'type' => 'image'],
            ['name' => 'title', 'label' => 'Title'],
            ['name' => 'author', 'label' => 'Author'],
            ['name' => 'published_at', 'label' => 'Published'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'status'],
        ];
    }

    protected function afterSave(Model $item, Request $request): void
    {
        if (! $item->published_at) {
            $item->update(['published_at' => now()]);
        }
    }
}
