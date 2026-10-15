@extends('layouts.frontend')
@section('title', ($page->meta_title ?: $page->title).' | '.($S['site_name'] ?? 'Nubic'))
@section('description', $page->meta_description ?? '')

@section('content')
@php $vision = ''; @endphp
<div class="page-banner">
    <div class="container">
        <h1>{{ $page->title }}</h1>
        <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">{{ $page->title }}</li></ol></nav>
    </div>
</div>
<section class="section">
    <div class="container">
        @if ($page->slug === 'about-us')
            @php
                $split = strpos($page->content, '<h2>Vision');
                $intro = $split === false ? $page->content : substr($page->content, 0, $split);
                $vision = $split === false ? '' : substr($page->content, $split);
            @endphp
            <div class="row g-5 align-items-center reveal">
                <div class="col-lg-6"><div class="why-photo"><img src="{{ asset('img/why-us.png') }}" alt="{{ $page->title }}"></div></div>
                <div class="col-lg-6">
                    <div class="section-title mb-3"><span class="eyebrow">About Nubic</span><h2>Leading Electrical Equipment Manufacturer</h2></div>
                    <div class="cms-content about-intro">{!! $intro !!}</div>
                </div>
            </div>
        @else
            <div class="row g-5">
                @if ($page->image)<div class="col-lg-5"><img src="{{ asset('storage/'.$page->image) }}" class="img-fluid rounded" alt="{{ $page->title }}"></div>@endif
                <div class="col-lg-{{ $page->image ? 7 : 12 }}"><div class="cms-content">{!! $page->content !!}</div></div>
            </div>
        @endif
    </div>
</section>

@if (($vision ?? '') !== '')
@php
    preg_match('/<h2>(.*?)<\/h2>/s', $vision, $h2);
    preg_match('/<h4>(.*?)<\/h4>/s', $vision, $h4);
    preg_match_all('/<p>(.*?)<\/p>/s', $vision, $paras);
    $icons = ['bullseye', 'graph-up-arrow', 'trophy'];
    $heads = ['Who We Are', 'Our Promise', 'Our Strength'];
@endphp
<section class="section bg-soft vision-block">
    <div class="container">
        <div class="reveal section-title text-center">
            <span class="eyebrow">{!! $h4[1] ?? 'Our Thinking and Future Plan' !!}</span>
            <h2>{!! $h2[1] ?? 'Vision &amp; Mission' !!}</h2>
        </div>
        <div class="row g-4 reveal">
            @foreach ($paras[1] as $i => $para)
                <div class="col-lg-4">
                    <div class="vision-card">
                        <span class="num">{{ sprintf('%02d', $i + 1) }}</span>
                        <i class="bi bi-{{ $icons[$i] ?? 'check2-circle' }}"></i>
                        <h3>{{ $heads[$i] ?? '' }}</h3>
                        <p>{!! $para !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if ($page->slug === 'about-us')
    @include('pages._cta')
@endif
@endsection
