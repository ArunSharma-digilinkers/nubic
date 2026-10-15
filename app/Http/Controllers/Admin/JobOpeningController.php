<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobOpening;

class JobOpeningController extends ResourceController
{
    protected string $model = JobOpening::class;
    protected string $route = 'jobs';
    protected string $title = 'Job Openings';
    protected string $singular = 'Job Opening';
    protected array $searchable = ['title', 'department', 'location'];

    protected function fields(): array
    {
        $types = ['Full Time', 'Part Time', 'Contract', 'Internship'];

        return [
            ['name' => 'title', 'label' => 'Job Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
            ['name' => 'department', 'label' => 'Department', 'type' => 'text', 'col' => 6, 'rules' => 'nullable|string|max:255'],
            ['name' => 'location', 'label' => 'Location', 'type' => 'text', 'col' => 6, 'rules' => 'nullable|string|max:255'],
            ['name' => 'job_type', 'label' => 'Job Type', 'type' => 'select', 'col' => 4, 'rules' => 'required|string|max:50',
                'options' => array_combine($types, $types)],
            ['name' => 'experience', 'label' => 'Experience (e.g. 2-4 years)', 'type' => 'text', 'col' => 4, 'rules' => 'nullable|string|max:100'],
            ['name' => 'vacancies', 'label' => 'Vacancies', 'type' => 'number', 'col' => 4, 'default' => 1, 'rules' => 'nullable|integer|min:1'],
            ['name' => 'summary', 'label' => 'Short Summary', 'type' => 'textarea', 'rules' => 'nullable|string|max:500'],
            ['name' => 'description', 'label' => 'Full Description / Requirements', 'type' => 'editor', 'rules' => 'nullable|string'],
            ['name' => 'closing_date', 'label' => 'Last Date to Apply (YYYY-MM-DD)', 'type' => 'text', 'col' => 4, 'rules' => 'nullable|date'],
            ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 4, 'default' => 0, 'rules' => 'nullable|integer'],
            ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox', 'col' => 4],
        ];
    }

    protected function columns(): array
    {
        return [
            ['name' => 'title', 'label' => 'Title'],
            ['name' => 'department', 'label' => 'Department'],
            ['name' => 'location', 'label' => 'Location'],
            ['name' => 'job_type', 'label' => 'Type'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'status'],
        ];
    }
}
