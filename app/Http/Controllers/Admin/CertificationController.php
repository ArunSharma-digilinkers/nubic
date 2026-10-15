<?php

namespace App\Http\Controllers\Admin;

use App\Models\Certification;

class CertificationController extends ResourceController
{
    protected string $model = Certification::class;
    protected string $route = 'certifications';
    protected string $title = 'Certifications';
    protected string $singular = 'Certification';
    protected string $orderBy = 'sort_order';
    protected string $orderDir = 'asc';

    protected function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'rules' => 'required|string|max:255'],
            ['name' => 'image', 'label' => 'Logo / Badge', 'type' => 'image'],
            ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 6, 'default' => 0, 'rules' => 'nullable|integer'],
            ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox', 'col' => 6],
        ];
    }

    protected function columns(): array
    {
        return [
            ['name' => 'image', 'label' => 'Logo', 'type' => 'image'],
            ['name' => 'name', 'label' => 'Name'],
            ['name' => 'sort_order', 'label' => 'Order'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'status'],
        ];
    }
}
