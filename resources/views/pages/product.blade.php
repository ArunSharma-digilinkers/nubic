@extends('layouts.frontend')
@section('title', $product->name.' | '.($S['site_name'] ?? 'Nubic'))
@section('description', \Illuminate\Support\Str::limit(strip_tags($product->description ?: $product->category->description), 150))
@section('body_class', 'page-grey')

@php
    $showPrices = ($S['show_prices'] ?? '1') === '1';
    $variants = $product->variants;
    $first = $variants->first();
    $specs = $product->specList();
    $hasEnc = $showPrices && $variants->contains(fn ($v) => $v->mrp_enclosure !== null);
    $money = fn ($n) => $n !== null ? '₹'.number_format($n) : '—';
    $pack = fn ($v) => filled($v?->packing) ? (int) $v->packing : '—';
    $label = fn ($v) => trim($v->rating.($v->spec ? ' · '.$v->spec : ''));
    $whatsapp = !empty($S['whatsapp'])
        ? 'https://wa.me/'.preg_replace('/\D+/', '', $S['whatsapp']).'?text='.rawurlencode('Hi, I am interested in '.$product->name)
        : null;
@endphp

@section('content')
{{-- Sticky product bar --}}
<div class="product-bar">
    <div class="container">
        <span class="pb-name">{{ $product->name }}@if ($first) <span class="pb-sub">· <span data-v="rating">{{ $label($first) }}</span></span>@endif</span>
        <nav class="pb-links d-none d-lg-flex" aria-label="On this page">
            @if ($specs)<a href="#specs">Specifications</a>@endif
            @if ($variants->count())<a href="#codes">{{ $showPrices ? 'Codes & MRP' : 'Product codes' }}</a>@endif
            @if (!empty($S['catalogue_url']))<a href="#downloads">Downloads</a>@endif
        </nav>
        <div class="pb-actions">
            @if ($whatsapp)<a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm d-none d-sm-inline-block">WhatsApp</a>@endif
            <a href="{{ route('contact', ['product' => $product->id]) }}" class="btn btn-primary btn-sm">Enquire</a>
        </div>
    </div>
</div>

<div class="container pd-wrap">
    <nav aria-label="Breadcrumb">
        <ol class="breadcrumb pd-crumbs">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="pd-main">
        <div class="pd-gallery">
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
        </div>

        <section class="pd-summary" aria-label="Product summary">
            <a href="{{ route('products.category', $product->category->slug) }}" class="pd-cat">{{ $product->category->name }}</a>
            <h1>{{ $product->name }}</h1>
            @if ($first)
                <p class="pd-meta">Code <span data-v="code">{{ $first->code ?: '—' }}</span> · Pack of <span data-v="pack">{{ $pack($first) }}</span></p>
            @endif

            <div class="pd-price">
                @if ($showPrices && $first?->mrp !== null)
                    <strong data-v="mrp">{{ $money($first->mrp) }}</strong><span>MRP per piece, incl. of all taxes</span>
                @else
                    <strong class="on-request">Dealer &amp; bulk pricing on request</strong>
                @endif
            </div>

            @if ($versions->count() > 1)
                <div class="pd-option">
                    <span class="pd-option-label">Type</span>
                    <div class="chip-group">
                        @foreach ($versions as $v)
                            <a href="{{ route('product', $v->slug) }}" class="chip {{ $v->id === $product->id ? 'is-on' : '' }}" @if ($v->id === $product->id) aria-current="page" @endif>{{ $v->versionName() }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($variants->count() > 1)
                <div class="pd-option">
                    <span class="pd-option-label" id="rating-label">Rating</span>
                    <div class="chip-group" role="radiogroup" aria-labelledby="rating-label" data-variant-picker>
                        @foreach ($variants as $v)
                            <button type="button" role="radio" class="chip" aria-checked="{{ $loop->first ? 'true' : 'false' }}"
                                data-variant="{{ $v->id }}" data-code="{{ $v->code ?: '—' }}" data-rating="{{ $label($v) }}"
                                data-pack="{{ $pack($v) }}" data-mrp="{{ $money($v->mrp) }}">{{ $label($v) }}</button>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($product->featureList())
                <ul class="dash-list pd-features">@foreach ($product->featureList() as $f)<li>{{ $f }}</li>@endforeach</ul>
            @endif

            <div class="pd-actions">
                <a href="{{ route('contact', ['product' => $product->id]) }}" class="btn btn-primary btn-lg">Enquire for this product</a>
                @if ($whatsapp)<a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-lg"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>@endif
            </div>
            <div class="pd-dealer">
                <span>Buying in bulk or for a shop?</span>
                <a href="{{ route('contact') }}">Become a dealer</a>
            </div>
        </section>
    </div>

    @if ($product->description)
        <section class="pd-section">
            <h2>Overview</h2>
            <div class="pd-panel cms-content">{!! $product->description !!}</div>
        </section>
    @endif

    @if ($specs)
        <section class="pd-section" id="specs">
            <h2>Specifications</h2>
            <dl class="pd-panel spec-list">
                @foreach ($specs as $k => $v)
                    <div><dt>{{ $k }}</dt><dd>{{ $v }}</dd></div>
                @endforeach
            </dl>
        </section>
    @endif

    @if ($variants->count())
        <section class="pd-section" id="codes">
            <h2>Product codes{{ $showPrices ? ' & MRP' : '' }}</h2>
            <div class="pd-panel table-responsive">
                <table class="table codes-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Pack</th>
                            @if ($showPrices)<th scope="col" class="text-end">MRP</th>@endif
                            @if ($hasEnc)<th scope="col" class="text-end">With enclosure</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($variants as $v)
                            <tr data-variant-row="{{ $v->id }}" class="{{ $loop->first ? 'is-selected' : '' }}">
                                <td class="code">{{ $v->code ?: '—' }}</td>
                                <td>{{ $label($v) }}</td>
                                <td>{{ $pack($v) }}</td>
                                @if ($showPrices)<td class="text-end">{{ $money($v->mrp) }}</td>@endif
                                @if ($hasEnc)<td class="text-end">{{ $money($v->mrp_enclosure) }}</td>@endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($showPrices)<p class="pd-note">MRP as per Product Catalogue 2023, subject to change without notice.</p>@endif
        </section>
    @endif

    @if (!empty($S['catalogue_url']))
        <section class="pd-section" id="downloads">
            <h2>Downloads</h2>
            <div class="dl-grid">
                <a href="{{ $S['catalogue_url'] }}" target="_blank" rel="noopener" class="dl-card">
                    <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                    <span><strong>Product catalogue</strong><small>PDF · all product codes and ratings</small></span>
                </a>
            </div>
        </section>
    @endif

    @if ($related->count())
        <section class="pd-section">
            <h2>More in {{ $product->category->name }}</h2>
            <div class="card-grid">
                @foreach ($related as $p)@include('pages._product-card', ['product' => $p])@endforeach
            </div>
        </section>
    @endif
</div>
@endsection
