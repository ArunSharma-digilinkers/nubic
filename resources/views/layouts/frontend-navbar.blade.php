@php
    $navCategories = \App\Models\Category::active()->topLevel()->with('children')->get();
    $tel = fn ($n) => 'tel:'.preg_replace('/\s+/', '', $n);
@endphp

<div class="utility-bar d-none d-md-block">
    <div class="container">
        <div class="utility-left">
            @if (!empty($S['phone']))<a href="{{ $tel($S['phone']) }}"><i class="bi bi-telephone"></i>{{ $S['phone'] }}</a>@endif
            @if (!empty($S['email']))<a href="mailto:{{ $S['email'] }}"><i class="bi bi-envelope"></i>{{ $S['email'] }}</a>@endif
            <span class="d-none d-lg-inline">ISI-marked products · Exporting to 14 countries</span>
        </div>
        <div class="utility-right">
            @if (!empty($S['catalogue_url']))<a href="{{ $S['catalogue_url'] }}" target="_blank" rel="noopener">Download Catalogue</a>@endif
            <a href="{{ route('contact') }}">Become a Dealer</a>
            <a href="{{ route('careers') }}">Careers</a>
        </div>
    </div>
</div>

<header class="site-header">
    <nav class="navbar navbar-expand-lg" aria-label="Main">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ !empty($S['logo']) ? asset('storage/'.$S['logo']) : asset('img/logo.png') }}" alt="{{ $S['site_name'] ?? 'Nubic' }}">
            </a>

            <form action="{{ route('products') }}" method="GET" role="search" class="header-search d-none d-xl-flex">
                <i class="bi bi-search" aria-hidden="true"></i>
                <label for="header-q" class="visually-hidden">Search products</label>
                <input id="header-q" type="search" name="q" value="{{ request('q') }}" placeholder="Search MCB, DB, changeover, product code…">
            </form>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Menu">
                <i class="bi bi-list"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <form action="{{ route('products') }}" method="GET" role="search" class="header-search d-xl-none my-3 my-lg-0 me-lg-3">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <label for="header-q-m" class="visually-hidden">Search products</label>
                    <input id="header-q-m" type="search" name="q" value="{{ request('q') }}" placeholder="Search products or codes…">
                </form>
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item dropdown mega">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('products*', 'product') ? 'active' : '' }}" href="{{ route('products') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">Products</a>
                        <div class="dropdown-menu mega-menu">
                            <div class="container">
                                <div class="mega-layout" data-mega>
                                    <div class="mega-tabs" role="tablist" aria-label="Product categories">
                                        @foreach ($navCategories as $c)
                                            <a href="{{ route('products.category', $c->slug) }}" class="mega-tab {{ $loop->first ? 'is-active' : '' }}" data-mega-tab="{{ $c->id }}">
                                                <img src="{{ $c->imageUrl() }}" alt="" loading="lazy">
                                                <span>{{ $c->name }}</span>
                                                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                                            </a>
                                        @endforeach
                                        <a href="{{ route('products') }}" class="mega-all">View all products <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                    <div class="mega-panes">
                                        @foreach ($navCategories as $c)
                                            <div class="mega-pane {{ $loop->first ? 'is-active' : '' }}" data-mega-pane="{{ $c->id }}">
                                                <div class="mega-pane-head">
                                                    <img src="{{ $c->imageUrl() }}" alt="" loading="lazy">
                                                    <div>
                                                        <h4>{{ $c->name }}</h4>
                                                        <a href="{{ route('products.category', $c->slug) }}">Shop all {{ $c->name }} <i class="bi bi-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                                @if ($c->children->isNotEmpty())
                                                    <div class="mega-tiles">
                                                        @foreach ($c->children as $sc)
                                                            <a href="{{ route('products.category', $sc->slug) }}" class="mega-tile">
                                                                <img src="{{ $sc->imageUrl() }}" alt="" loading="lazy">
                                                                <span>{{ $sc->name }}</span>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="mega-empty">Explore the complete {{ $c->name }} range.</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @if (!empty($S['catalogue_url']))<li class="nav-item"><a class="nav-link" href="{{ $S['catalogue_url'] }}" target="_blank" rel="noopener">Downloads</a></li>@endif
                    <li class="nav-item"><a class="nav-link {{ request()->is('page/about-us') ? 'active' : '' }}" href="{{ route('page', 'about-us') }}">About Nubic</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('blog', 'post') ? 'active' : '' }}" href="{{ route('blog') }}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
                </ul>
                <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-sm ms-lg-3 mt-2 mt-lg-0 header-cta">Enquire Now</a>
            </div>
        </div>
    </nav>

    <div class="category-strip">
        <div class="container">
            @foreach ($navCategories as $c)
                <a href="{{ route('products.category', $c->slug) }}" class="{{ request()->is('products/category/'.$c->slug) ? 'active' : '' }}">{{ $c->name }}</a>
            @endforeach
        </div>
    </div>
</header>
