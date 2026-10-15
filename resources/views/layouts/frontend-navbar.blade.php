@php
    $navCategories = \App\Models\Category::active()->get();
    $navPages = \App\Models\Page::where('is_active', true)->where('slug', '!=', 'about-us')->get();
@endphp

<div class="topbar d-none d-md-block">
    <div class="container d-flex justify-content-between">
        <div>
            @if (!empty($S['phone']))<a href="tel:{{ preg_replace('/\s+/', '', $S['phone']) }}" class="me-3"><i class="bi bi-telephone-fill"></i>{{ $S['phone'] }}</a>@endif
            @if (!empty($S['alt_phone']))<a href="tel:{{ preg_replace('/\s+/', '', $S['alt_phone']) }}" class="me-3"><i class="bi bi-phone-fill"></i>{{ $S['alt_phone'] }}</a>@endif
            @if (!empty($S['email']))<a href="mailto:{{ $S['email'] }}"><i class="bi bi-envelope-fill"></i>{{ $S['email'] }}</a>@endif
        </div>
        <div class="social">
            @foreach (['facebook', 'instagram', 'linkedin', 'youtube'] as $net)
                @if (!empty($S[$net]))<a href="{{ $S[$net] }}" target="_blank" rel="noopener"><i class="bi bi-{{ $net }}"></i></a>@endif
            @endforeach
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg site-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ !empty($S['logo']) ? asset('storage/'.$S['logo']) : asset('img/logo.png') }}" alt="{{ $S['site_name'] ?? 'Nubic' }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Menu"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('page/about-us') ? 'active' : '' }}" href="{{ route('page', 'about-us') }}">About Us</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('products*', 'product') ? 'active' : '' }}" href="{{ route('products') }}" data-bs-toggle="dropdown">Products</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('products') }}">All Products</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach ($navCategories as $c)
                            <li><a class="dropdown-item" href="{{ route('products.category', $c->slug) }}">{{ $c->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @foreach ($navPages as $p)
                    <li class="nav-item"><a class="nav-link {{ request()->is('page/'.$p->slug) ? 'active' : '' }}" href="{{ route('page', $p->slug) }}">{{ $p->title }}</a></li>
                @endforeach
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('blog', 'post') ? 'active' : '' }}" href="{{ route('blog') }}">Blog</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('career*') ? 'active' : '' }}" href="{{ route('careers') }}">Careers</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a></li>
            </ul>
        </div>
    </div>
</nav>
