@extends('layouts.frontend')
@section('title', ($post->meta_title ?: $post->title).' | '.($S['site_name'] ?? 'Nubic'))

@section('content')
<div class="page-banner">
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></li><li class="breadcrumb-item active">{{ \Illuminate\Support\Str::limit($post->title, 40) }}</li></ol></nav>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="post-meta mb-3"><i class="bi bi-calendar3"></i> {{ ($post->published_at ?? $post->created_at)->format('d M Y') }}@if ($post->author) &nbsp;·&nbsp; <i class="bi bi-person"></i> {{ $post->author }}@endif</div>
                @if ($post->image)<img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" class="img-fluid rounded mb-4 w-100">@endif
                <div class="cms-content">{!! $post->content !!}</div>
            </div>
            <div class="col-lg-4">
                <h4 class="text-uppercase mb-3">Recent Posts</h4>
                <div class="list-group">
                    @foreach ($recent as $r)
                        <a href="{{ route('post', $r->slug) }}" class="list-group-item list-group-item-action">
                            <strong>{{ $r->title }}</strong><br><small class="text-secondary">{{ ($r->published_at ?? $r->created_at)->format('d M Y') }}</small>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
