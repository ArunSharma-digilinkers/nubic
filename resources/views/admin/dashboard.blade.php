@extends('layouts.admin')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    @foreach ($stats as [$label, $num, $icon, $url])
        <div class="col-6 col-xl-3">
            <a href="{{ $url }}" class="stat-card">
                <div class="icon"><i class="bi {{ $icon }}"></i></div>
                <div><div class="num">{{ $num }}</div><div class="lbl">{{ $label }}</div></div>
            </a>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">Latest Enquiries <a href="{{ route('admin.enquiries.index') }}" class="small">View all</a></div>
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead><tr><th>Name</th><th>Contact</th><th>Message</th><th>Date</th></tr></thead>
                    <tbody>
                    @forelse ($latest as $e)
                        <tr>
                            <td><a href="{{ route('admin.enquiries.show', $e) }}" class="{{ $e->is_read ? '' : 'fw-bold' }}">{{ $e->name }}</a></td>
                            <td>{{ $e->phone ?: $e->email }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($e->message, 50) }}</td>
                            <td class="text-nowrap">{{ $e->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-secondary py-4">No enquiries yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Quick Actions</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action" href="{{ route('admin.products.create') }}"><i class="bi bi-plus-circle text-primary me-2"></i> Add Product</a>
                <a class="list-group-item list-group-item-action" href="{{ route('admin.sliders.create') }}"><i class="bi bi-plus-circle text-primary me-2"></i> Add Slider</a>
                <a class="list-group-item list-group-item-action" href="{{ route('admin.pages.create') }}"><i class="bi bi-plus-circle text-primary me-2"></i> Add Page</a>
                <a class="list-group-item list-group-item-action" href="{{ route('admin.settings') }}"><i class="bi bi-gear text-primary me-2"></i> Site Settings &amp; Logo</a>
            </div>
        </div>
    </div>
</div>
@endsection
