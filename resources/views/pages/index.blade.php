@extends('layouts.frontend')

@section('content')
{{-- Hero --}}
@if ($sliders->count())
<section class="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
        @if ($sliders->count() > 1)
            <div class="carousel-indicators">
                @foreach ($sliders as $i => $s)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-label="Slide {{ $i + 1 }}"></button>
                @endforeach
            </div>
        @endif
        <div class="carousel-inner">
            @foreach ($sliders as $i => $s)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <div class="slide-bg" @if($s->image) style="background-image:url('{{ asset('storage/'.$s->image) }}')" @endif></div>
                    <div class="container">
                        <div class="hero-inner">
                            <div class="hero-content">
                                <h1>{{ $s->title }}</h1>
                                <p class="lead">{{ $s->subtitle ?: 'Switchgear, Wires & Cables, Fans, Modular Switches, Motors and other Domestic Appliances.' }}</p>
                                <a href="{{ $s->button_text ? ($s->button_url ?: route('products')) : route('products') }}" class="btn btn-primary btn-lg">{{ $s->button_text ?: 'Explore Products' }} <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($sliders->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" aria-label="Previous"><span><i class="bi bi-chevron-left"></i></span></button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" aria-label="Next"><span><i class="bi bi-chevron-right"></i></span></button>
        @endif
    </div>
</section>
@else
<section class="hero hero-default">
    <div class="container">
        <div class="hero-inner">
            <div>
                <span class="hero-eyebrow">Safe · Reliable · Certified</span>
                <h1>Powering Every <em>Connection</em></h1>
                <p class="lead">MCBs, RCCBs, isolators, distribution boards and more — engineered for homes, industries and infrastructure.</p>
                <a href="{{ route('products') }}" class="btn btn-primary btn-lg me-2">Explore Products</a>
                <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">Get a Quote</a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Quick access --}}
<section class="quick-access">
    <div class="container">
        <div class="row g-3">
            @foreach ([
                ['grid-3x3-gap-fill', 'Browse Products', 'See the full range', route('products')],
                ['file-earmark-arrow-down-fill', 'Download Catalogue', 'Get the latest PDF', $S['catalogue_url'] ?? route('products')],
                ['chat-dots-fill', 'Get a Quote', 'Tell us your need', route('contact')],
                ['telephone-fill', 'Call Us', $S['phone'] ?? 'Talk to our team', !empty($S['phone']) ? 'tel:'.preg_replace('/\s+/', '', $S['phone']) : route('contact')],
            ] as [$icon, $title, $sub, $url])
                <div class="col-6 col-lg-3">
                    <a href="{{ $url }}" class="qa-item" @if (str_ends_with($url, '.pdf')) target="_blank" @endif>
                        <i class="bi bi-{{ $icon }}"></i>
                        <span><strong>{{ $title }}</strong><small>{{ $sub }}</small></span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="section">
    <div class="container">
        <div class="reveal section-title text-center">
            <span class="eyebrow">Our Range</span>
            <h2>Product Categories</h2>
            <p class="sub">Pick a category to find the right product for your home, shop or industry.</p>
        </div>
        <div class="row g-4 reveal">
            @foreach ($categories as $c)
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('products.category', $c->slug) }}" class="category-card">
                        <div class="thumb">
                            @if ($c->image)<img src="{{ asset('storage/'.$c->image) }}" alt="{{ $c->name }}" loading="lazy">@else<i class="bi bi-lightning-charge-fill"></i>@endif
                        </div>
                        <div class="body">
                            <h3>{{ $c->name }}</h3>
                            <span class="go">View Products <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- About --}}
@if ($about)
@php
    preg_match('/<p[^>]*>(.*?)<\/p>/s', $about->content, $firstPara);
    $aboutText = strip_tags($firstPara[1] ?? \Illuminate\Support\Str::limit(strip_tags($about->content), 380));
@endphp
<section class="section bg-soft about-block">
    <div class="container">
        <div class="row g-5 align-items-center reveal">
            <div class="col-lg-6">
                <div class="about-photo"><img src="{{ asset('img/mcb-box.png') }}" alt="Nubic MCB"></div>
            </div>
            <div class="col-lg-6">
                <div class="reveal section-title mb-3"><span class="eyebrow">About Nubic</span><h2>Leading Electrical Equipment Manufacturer</h2></div>
                <p class="about-text">{{ $aboutText }}</p>
                <div class="about-tags">
                    @foreach (['MCB', 'RCCB', 'Isolators', 'Distribution Boards', 'Changeover Switches', 'Energy Meters'] as $point)
                        <span><i class="bi bi-check-lg"></i>{{ $point }}</span>
                    @endforeach
                </div>
                <a href="{{ route('page', $about->slug) }}" class="btn btn-primary mt-4">Read More <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Featured --}}
@if ($featured->count())
<section class="section">
    <div class="container">
        <div class="reveal section-title text-center"><span class="eyebrow">Best Sellers</span><h2>Featured Products</h2><p class="sub">Our most popular products, trusted by customers across India.</p></div>
        <div class="row g-4 reveal">
            @foreach ($featured as $p)
                <div class="col-sm-6 col-lg-3">@include('pages._product-card', ['product' => $p])</div>
            @endforeach
        </div>
        <div class="text-center mt-5"><a href="{{ route('products') }}" class="btn btn-primary">View All Products</a></div>
    </div>
</section>
@endif

{{-- Why us --}}
<section class="section why-dark">
    <div class="container">
        <div class="reveal section-title text-center"><span class="eyebrow">Why Nubic</span><h2>Built On Trust</h2><p class="sub">Four good reasons to choose Nubic for your next project.</p></div>
        <div class="row g-4 reveal">
            @foreach ([['shield-check','Safety First','Every device is tested to meet international safety standards.'],['lightning-charge','High Performance','Reliable breaking capacity and long service life.'],['award','Certified Quality','Approved by leading certification bodies.'],['headset','Dealer Support','Responsive support and bulk pricing for partners.']] as [$icon,$t,$d])
                <div class="col-sm-6 col-lg-3"><div class="feature-card"><i class="bi bi-{{ $icon }}"></i><h3>{{ $t }}</h3><p>{{ $d }}</p></div></div>
            @endforeach
        </div>
    </div>
</section>

{{-- Latest posts --}}
@if ($latestPosts->count())
<section class="section">
    <div class="container">
        <div class="reveal section-title text-center"><span class="eyebrow">News &amp; Updates</span><h2>From Our Blog</h2><p class="sub">Tips, news and updates from the Nubic team.</p></div>
        <div class="row g-4 reveal">
            @foreach ($latestPosts as $post)
                <div class="col-md-6 col-lg-4">@include('pages._post-card', ['post' => $post])</div>
            @endforeach
        </div>
        <div class="text-center mt-5"><a href="{{ route('blog') }}" class="btn btn-primary">View All Posts</a></div>
    </div>
</section>
@endif

{{-- Certifications --}}
@if ($certifications->count())
<section class="section bg-soft">
    <div class="container">
        <div class="reveal section-title text-center"><span class="eyebrow">Internationally Approved</span><h2>Certifications</h2><p class="sub">Quality you can verify.</p></div>
        <div class="row g-3 justify-content-center reveal">
            @foreach ($certifications as $c)
                <div class="col-6 col-md-3"><div class="cert-item">
                    <div class="logo-wrap">@if ($c->image)<img src="{{ asset('storage/'.$c->image) }}" alt="{{ $c->name }}">@else<i class="bi bi-patch-check-fill"></i>@endif</div>
                    <span>{{ $c->name }}</span>
                </div></div>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('pages._cta')
@endsection
