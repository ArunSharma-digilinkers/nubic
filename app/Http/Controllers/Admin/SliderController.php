<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;

class SliderController extends ResourceController
{
    protected string $model = Slider::class;
    protected string $route = 'sliders';
    protected string $title = 'Home Sliders';
    protected string $singular = 'Slider';
    protected array $searchable = ['title', 'subtitle'];
    protected string $orderBy = 'sort_order';
    protected string $orderDir = 'asc';

    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
            ['name' => 'subtitle', 'label' => 'Subtitle', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            ['name' => 'image', 'label' => 'Background Image (1920x800 recommended)', 'type' => 'image'],
            ['name' => 'button_text', 'label' => 'Button Text', 'type' => 'text', 'col' => 6, 'rules' => 'nullable|string|max:100'],
            ['name' => 'button_url', 'label' => 'Button URL', 'type' => 'text', 'col' => 6, 'rules' => 'nullable|string|max:255'],
            ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 6, 'default' => 0, 'rules' => 'nullable|integer'],
            ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox', 'col' => 6],
        ];
    }

    protected function columns(): array
    {
        return [
            ['name' => 'image', 'label' => 'Image', 'type' => 'image'],
            ['name' => 'title', 'label' => 'Title'],
            ['name' => 'sort_order', 'label' => 'Order'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'status'],
        ];
    }
}
