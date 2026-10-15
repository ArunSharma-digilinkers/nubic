<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\Variant;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'stats' => [
                ['Products', Product::count(), 'bi-box-seam', route('admin.products.index')],
                ['Categories', Category::count(), 'bi-grid', route('admin.categories.index')],
                ['Variants / SKUs', Variant::count(), 'bi-upc-scan', route('admin.products.index')],
                ['Unread Enquiries', Enquiry::where('is_read', false)->count(), 'bi-envelope', route('admin.enquiries.index')],
            ],
            'latest' => Enquiry::latest()->limit(6)->get(),
        ]);
    }
}
