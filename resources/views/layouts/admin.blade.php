<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | {{ $S['site_name'] ?? 'Nubic' }} Admin</title>
    <link rel="icon" type="image/png" href="{{ !empty($S['favicon']) ? asset('storage/'.$S['favicon']) : asset('img/fevicon.png') }}">
    @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])
</head>
<body class="admin">
@php
    $menu = [
        ['Main', null],
        ['Dashboard', 'admin.dashboard', 'bi-speedometer2', 'admin.dashboard'],
        ['Catalogue', null],
        ['Categories', 'admin.categories.index', 'bi-grid', 'admin.categories.*'],
        ['Products', 'admin.products.index', 'bi-box-seam', 'admin.products.*'],
        ['Website', null],
        ['Home Sliders', 'admin.sliders.index', 'bi-images', 'admin.sliders.*'],
        ['Pages', 'admin.pages.index', 'bi-file-earmark-text', 'admin.pages.*'],
        ['Certifications', 'admin.certifications.index', 'bi-patch-check', 'admin.certifications.*'],
        ['Blog Posts', 'admin.posts.index', 'bi-journal-text', 'admin.posts.*'],
        ['Job Openings', 'admin.jobs.index', 'bi-briefcase', 'admin.jobs.*'],
        ['Applications', 'admin.applications.index', 'bi-person-lines-fill', 'admin.applications.*'],
        ['Enquiries', 'admin.enquiries.index', 'bi-envelope', 'admin.enquiries.*'],
        ['System', null],
        ['Site Settings', 'admin.settings', 'bi-gear', 'admin.settings*'],
        ['My Account', 'admin.account', 'bi-person-circle', 'admin.account*'],
    ];
@endphp

<aside class="admin-sidebar">
    <div class="brand"><img src="{{ asset('img/logo.png') }}" alt="Nubic" style="max-height:44px;max-width:100%"><small>Admin Panel</small></div>
    <nav class="nav flex-column pb-4">
        @foreach ($menu as $m)
            @if ($m[1] === null)
                <div class="nav-label">{{ $m[0] }}</div>
            @else
                <a class="nav-link {{ request()->routeIs($m[3]) ? 'active' : '' }}" href="{{ route($m[1]) }}">
                    <i class="bi {{ $m[2] }}"></i> {{ $m[0] }}
                    @if ($m[1] === 'admin.applications.index' && $unreadApplications)
                        <span class="badge bg-primary">{{ $unreadApplications }}</span>
                    @endif
                    @if ($m[1] === 'admin.enquiries.index' && $unreadEnquiries)
                        <span class="badge bg-primary">{{ $unreadEnquiries }}</span>
                    @endif
                </a>
            @endif
        @endforeach
    </nav>
</aside>

<div class="admin-main">
    <header class="admin-topbar">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" data-sidebar-toggle type="button"><i class="bi bi-list"></i></button>
        <h1>@yield('heading', 'Dashboard')</h1>
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-box-arrow-up-right"></i> View Site</a>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="btn btn-sm btn-dark"><i class="bi bi-power"></i> Logout</button>
            </form>
        </div>
    </header>

    <main class="admin-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger"><strong>Please fix the following:</strong><ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
