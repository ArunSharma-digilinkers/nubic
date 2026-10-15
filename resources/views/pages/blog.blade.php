@extends('layouts.frontend')
@section('title', 'Blog | '.($S['site_name'] ?? 'Nubic'))

@section('content')
<div class="page-banner">
    <div class="container">
        <h1>Blog &amp; News</h1>
        <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Blog</li></ol></nav>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="row g-4">
            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-4">@include('pages._post-card', ['post' => $post])</div>
            @empty
                <div class="col-12 text-center text-secondary py-5"><i class="bi bi-journal-text display-3 d-block mb-3"></i>No posts yet. Please check back soon.</div>
            @endforelse
        </div>
        @if ($posts->hasPages())<div class="mt-5 d-flex justify-content-center">{{ $posts->links('pagination::bootstrap-5') }}</div>@endif
    </div>
</section>
@endsection
