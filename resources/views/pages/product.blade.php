@extends('layouts.frontend')
@section('title', $product->name.' | '.($S['site_name'] ?? 'Nubic'))
@section('description', \Illuminate\Support\Str::limit(strip_tags($product->description), 150))

@php
    $showPrices = ($S['show_prices'] ?? '1') === '1';
    $hasSpec = $product->variants->contains(fn ($v) => filled($v->spec));
    $hasPack = $product->variants->contains(fn ($v) => filled($v->packing));
    $hasEnc = $product->variants->contains(fn ($v) => $v->mrp_enclosure !== null);
@endphp

@section('content')
<div class="page-banner">
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ \Illuminate\Support\Str::limit($product->name, 40) }}</li>
        </ol></nav>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row g-5 reveal">
            <div class="col-lg-5">
                <div class="detail-image">
                    @if ($product->image)<img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">@else<i class="bi bi-lightning-charge placeholder"></i>@endif
                </div>
            </div>
            <div class="col-lg-7">
                <a href="{{ route('products.category', $product->category->slug) }}" class="detail-cat">{{ $product->category->name }}</a>
                <h2 class="detail-title">{{ $product->name }}</h2>

                @if ($product->description)<div class="cms-content mb-3">{!! $product->description !!}</div>@endif

                @if ($product->featureList())
                    <h4 class="mt-4">Key Features</h4>
                    <ul class="feature-list">@foreach ($product->featureList() as $f)<li>{{ $f }}</li>@endforeach</ul>
                @endif

                <div class="detail-actions">
                    <a href="{{ route('contact', ['product' => $product->id]) }}" class="btn btn-primary btn-lg"><i class="bi bi-chat-dots me-1"></i> Enquire Now</a>
                    @if (!empty($S['whatsapp']))
                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', $S['whatsapp']) }}?text={{ urlencode('Hi, I am interested in '.$product->name) }}" target="_blank" rel="noopener" class="btn btn-outline-success btn-lg"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
                    @endif
                    @if (!empty($S['phone']))
                        <a href="tel:{{ preg_replace('/\s+/', '', $S['phone']) }}" class="btn btn-outline-dark btn-lg"><i class="bi bi-telephone me-1"></i> Call</a>
                    @endif
                    @if (!empty($S['catalogue_url']))
                        <a href="{{ $S['catalogue_url'] }}" target="_blank" class="btn btn-link text-decoration-none"><i class="bi bi-file-earmark-arrow-down"></i> Catalogue</a>
                    @endif
                </div>
            </div>
        </div>

        @if ($product->variants->count())
            <div class="section-title mt-5 mb-4 reveal" id="models"><span class="eyebrow">Specifications</span><h2>Models &amp; Ratings</h2></div>
            <div class="table-responsive spec-wrap">
                <table class="table spec-table align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Code</th><th>Rating</th>
                        @if ($hasSpec)<th>Execution / Spec</th>@endif
                        @if ($hasPack)<th>Packing Pc.</th>@endif
                        @if ($showPrices)<th class="text-end">M.R.P. (₹)</th>@if ($hasEnc)<th class="text-end">With Enclosure (₹)</th>@endif @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($product->variants as $v)
                        <tr>
                            <td class="code">{{ $v->code }}</td>
                            <td>{{ $v->rating }}</td>
                            @if ($hasSpec)<td>{{ $v->spec }}</td>@endif
                            @if ($hasPack)<td>{{ $v->packing }}</td>@endif
                            @if ($showPrices)
                                <td class="price text-end">{{ $v->mrp !== null ? number_format($v->mrp, 2) : '—' }}</td>
                                @if ($hasEnc)<td class="price text-end">{{ $v->mrp_enclosure !== null ? number_format($v->mrp_enclosure, 2) : '—' }}</td>@endif
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($showPrices)<p class="small text-secondary">M.R.P. as per Product Catalogue 2023, subject to change without prior notice.</p>@endif
        @endif

        @if ($related->count())
            <div class="section-title mt-5 mb-4 reveal"><span class="eyebrow">You May Also Like</span><h2>Related Products</h2></div>
            <div class="row g-4 reveal">@foreach ($related as $p)<div class="col-sm-6 col-lg-3">@include('pages._product-card', ['product' => $p->setRelation('category', $product->category)])</div>@endforeach</div>
        @endif
    </div>
</section>
@endsection
