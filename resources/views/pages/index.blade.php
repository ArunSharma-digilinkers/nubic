@extends('layouts.frontend')
@section('body_class', 'page-grey')

@section('content')
{{-- Hero --}}
<section class="home-hero">
        <div id="heroCarousel" class="carousel slide carousel-fade hero-frame" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-inner">
                @forelse ($sliders as $i => $s)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                        @if ($s->image)<img class="hero-img" src="{{ asset('storage/'.$s->image) }}" alt="">@endif
                        <div class="container h-100"><div class="hero-copy">
                            <h1>{{ $s->title }}</h1>
                            <p>{{ $s->subtitle ?: 'MCBs, isolators, RCCBs, distribution boards, changeovers and energy meters, made in-house in Delhi.' }}</p>
                            <div class="hero-actions">
                                <a href="{{ $s->button_text ? ($s->button_url ?: route('products')) : route('products') }}" class="btn btn-light btn-lg">{{ $s->button_text ?: 'Explore Products' }}</a>
                                @if (!empty($S['catalogue_url']))<a href="{{ $S['catalogue_url'] }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-lg">Download Catalogue</a>@endif
                            </div>
                        </div></div>
                    </div>
                @empty
                    <div class="carousel-item active">
                        <div class="container h-100"><div class="hero-copy">
                            <span class="hero-tag">ISI marked · 10 kA</span>
                            <h1>Electrical protection, made in India</h1>
                            <p>MCBs, isolators, RCCBs, distribution boards, changeovers and energy meters.</p>
                            <div class="hero-actions"><a href="{{ route('products') }}" class="btn btn-primary btn-lg">Explore Products</a></div>
                        </div></div>
                    </div>
                @endforelse
            </div>
            @if ($sliders->count() > 1)
                <div class="carousel-indicators">
                    @foreach ($sliders as $i => $s)
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-label="Slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    <div class="container">
        <div class="info-strip">
            Dealer and bulk pricing available across India. <a href="{{ route('contact') }}">Talk to our sales team</a>
        </div>
    </div>
</section>

{{-- Range --}}
<section class="home-section" id="range">
    <div class="container">
        <div class="section-head">
            <h2>Explore Our Range</h2>
            <a href="{{ route('products') }}">View all products <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="range-grid">
            @foreach ($categories as $i => $c)
                @if ($i === 0)
                    <a href="{{ route('products.category', $c->slug) }}" class="range-tile range-feature">
                        <img src="{{ asset('img/mcb-box.png') }}" alt="">
                        <span class="range-feature-copy">
                            <span class="kicker">Protection devices</span>
                            <span class="title">{{ $c->name }}</span>
                            <span class="desc">{{ $c->products_count }} products, from single pole to four pole.</span>
                            <span class="btn btn-light btn-sm">View range</span>
                        </span>
                    </a>
                @else
                    <a href="{{ route('products.category', $c->slug) }}" class="range-tile">
                        <span class="range-media"><img src="{{ $c->imageUrl() }}" alt="" loading="lazy"></span>
                        <span class="range-body">
                            <span class="title">{{ $c->name }}</span>
                            <span class="desc">{{ \Illuminate\Support\Str::limit($c->description, 90) }}</span>
                            <span class="count">{{ $c->products_count }} {{ \Illuminate\Support\Str::plural('product', $c->products_count) }}</span>
                        </span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>

{{-- Popular products --}}
@if ($popular->count())
<section class="home-section">
    <div class="container">
        <div class="section-head">
            <h2>Popular Products</h2>
            <a href="{{ route('products') }}">View all products <i class="bi bi-arrow-right"></i></a>
        </div>
        @if ($popular->count() > 1)
            <div class="nav pill-tabs" role="tablist">
                @foreach ($popular as $catId => $items)
                    <button class="{{ $loop->first ? 'active' : '' }}" type="button" role="tab" data-bs-toggle="pill" data-bs-target="#pop-{{ $catId }}" aria-controls="pop-{{ $catId }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $categories->firstWhere('id', $catId)->name }}</button>
                @endforeach
            </div>
        @endif
        <div class="tab-content">
            @foreach ($popular as $catId => $items)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pop-{{ $catId }}" role="tabpanel">
                    <div class="card-grid">
                        @foreach ($items as $p)@include('pages._product-card', ['product' => $p])@endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Stats --}}
<section class="home-section">
    <div class="container">
        <div class="stats-band">
            <div><strong>{{ $categories->count() }}</strong><span>Product categories</span></div>
            <div><strong>{{ $codeCount }}</strong><span>Product codes in the catalogue</span></div>
            <div><strong>14</strong><span>Export countries</span></div>
            <div><strong>ISI</strong><span>Marked, BIS-certified products</span></div>
        </div>
    </div>
</section>

{{-- Manufacturing --}}
<section class="home-section">
    <div class="container">
        <div class="make-block">
            <div class="make-media">
                <img src="{{ asset('img/factory.jpg') }}" alt="Production line" loading="lazy">
            </div>
            <div class="make-copy">
                <span class="kicker">Made by Nubic</span>
                <h2>Designed, built and tested in our own plant</h2>
                <p>Every Nubic product is made in-house, from tooling to final testing, so quality is controlled at each step.</p>
                <ul class="check-list">
                    <li>Tool room with wire-cut and EDM machines</li>
                    <li>In-house press shop</li>
                    <li>Electroplating and powder coating</li>
                    <li>Test lab for HV, CT/PT and relay testing</li>
                </ul>
                @if ($about)<a href="{{ route('page', $about->slug) }}" class="btn btn-outline-primary">About Nubic</a>@endif
            </div>
        </div>
    </div>
</section>

{{-- Certifications --}}
@if ($certifications->count())
<section class="home-section">
    <div class="container">
        <div class="section-head"><h2>Certified &amp; Trusted</h2></div>
    </div>
        @php $reps = max(1, (int) ceil(8 / $certifications->count())); @endphp
        <div class="cert-marquee">
            <div class="cert-track">
                @foreach ([0, 1] as $half)
                    @for ($r = 0; $r < $reps; $r++)
                        @foreach ($certifications as $c)
                            <div class="cert-card" @if ($half || $r) aria-hidden="true" @endif>
                                <span class="cert-logo">@if ($c->image)<img src="{{ asset('storage/'.$c->image) }}" alt="">@else<i class="bi bi-patch-check"></i>@endif</span>
                                <strong>{{ $c->name }}</strong>
                            </div>
                        @endforeach
                    @endfor
                @endforeach
            </div>
        </div>
</section>
@endif

{{-- Downloads + dealer --}}
<section class="home-section pb-5">
    <div class="container">
        <div class="duo-grid">
            <div class="duo-card">
                <i class="bi bi-file-earmark-arrow-down" aria-hidden="true"></i>
                <h2>Product catalogue</h2>
                <p>Every product code, rating and MRP in one PDF, free to download with no form to fill.</p>
                @if (!empty($S['catalogue_url']))<a href="{{ $S['catalogue_url'] }}" target="_blank" rel="noopener" class="btn btn-primary">Download catalogue</a>@endif
            </div>
            <div class="duo-card dark">
                <i class="bi bi-shop" aria-hidden="true"></i>
                <h2>Become a Nubic dealer</h2>
                <p>Stock an ISI-marked range with dealer margins and direct support from the factory.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('contact') }}" class="btn btn-light">Apply now</a>
                    @if (!empty($S['phone']))<a href="tel:{{ preg_replace('/\s+/', '', $S['phone']) }}" class="btn btn-outline-light">Call {{ $S['phone'] }}</a>@endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
