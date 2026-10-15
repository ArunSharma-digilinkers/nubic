@extends('layouts.frontend')
@section('title', ($category->name ?? 'Products').' | '.($S['site_name'] ?? 'Nubic'))

@section('content')
<div class="page-banner">
    <div class="container">
        <h1>{{ $category->name ?? 'Our Products' }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item {{ $category ? '' : 'active' }}">@if($category)<a href="{{ route('products') }}">Products</a>@else Products @endif</li>
            @if ($category)<li class="breadcrumb-item active">{{ $category->name }}</li>@endif
        </ol></nav>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row g-4">
            <aside class="col-lg-3">
                <form method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, code or rating">
                        <button class="btn btn-primary px-3"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <div class="list-group side-list">
                    <a href="{{ route('products') }}" class="list-group-item list-group-item-action {{ $category ? '' : 'active' }}">All Products</a>
                    @foreach ($categories as $c)
                        <a href="{{ route('products.category', $c->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $category?->id === $c->id ? 'active' : '' }}">
                            {{ $c->name }} <span class="badge rounded-pill">{{ $c->products_count }}</span>
                        </a>
                    @endforeach
                </div>
            </aside>
            <div class="col-lg-9">
                @if ($category && $category->description)<p class="text-secondary mb-4">{{ $category->description }}</p>@endif
                <div class="row g-4">
                    @forelse ($products as $p)
                        <div class="col-sm-6 col-xl-4">@include('pages._product-card', ['product' => $p])</div>
                    @empty
                        <div class="col-12"><div class="alert alert-light border">No products found.</div></div>
                    @endforelse
                </div>
                <div class="mt-4">{{ $products->links('pagination::bootstrap-5') }}</div>
            </div>
        </div>
    </div>
</section>
@endsection
