@extends('layouts.frontend')
@section('title', 'Careers | '.($S['site_name'] ?? 'Nubic'))

@section('content')
<div class="page-banner">
    <div class="container">
        <h1>Careers</h1>
        <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Careers</li></ol></nav>
    </div>
</div>
{{-- Intro --}}
<section class="section">
    <div class="container">
        <div class="row g-5 align-items-center reveal">
            <div class="col-lg-6">
                <div class="section-title mb-3"><span class="eyebrow">Join Our Team</span><h2>Build Your Career With Nubic</h2></div>
                <p class="about-text">Nubic Group has emerged as the preferred choice for a discerning range of individual and industrial consumers both in India and abroad. The essence of its success lies in the expertise of a fine team of professionals, the strong relationship with associates, the ability to change quickly and efficiently and the vision to think ahead.</p>
                <a href="#openings" class="btn btn-primary">See Open Positions <i class="bi bi-arrow-down ms-1"></i></a>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    @foreach ([['people-fill', 'Team of Professionals'], ['lightbulb-fill', 'Research &amp; Innovation'], ['diagram-3-fill', 'Strong Relationships'], ['rocket-takeoff-fill', 'Vision to Think Ahead']] as [$icon, $label])
                        <div class="col-6"><div class="perk-card"><i class="bi bi-{{ $icon }}"></i><span>{!! $label !!}</span></div></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Openings --}}
<section class="section bg-soft" id="openings">
    <div class="container">
        <div class="reveal section-title text-center">
            <span class="eyebrow">Careers</span>
            <h2>Current Openings</h2>
            <p class="sub">@if ($jobs->count()){{ $jobs->count() }} {{ \Illuminate\Support\Str::plural('position', $jobs->count()) }} open right now. Pick a role to read the details and apply.@else No positions are open right now, but we would love to hear from you.@endif</p>
        </div>
        <div class="row g-4 justify-content-center reveal">
            @forelse ($jobs as $j)
                <div class="col-lg-10">
                    <div class="job-card">
                        <div class="info">
                            <h3><a href="{{ route('career', $j->slug) }}">{{ $j->title }}</a></h3>
                            <div class="tags">
                                @if ($j->department)<span><i class="bi bi-diagram-3"></i> {{ $j->department }}</span>@endif
                                @if ($j->location)<span><i class="bi bi-geo-alt"></i> {{ $j->location }}</span>@endif
                                <span><i class="bi bi-clock"></i> {{ $j->job_type }}</span>
                                @if ($j->experience)<span><i class="bi bi-briefcase"></i> {{ $j->experience }}</span>@endif
                                @if ($j->closing_date)<span><i class="bi bi-calendar-event"></i> Apply before {{ $j->closing_date->format('d M Y') }}</span>@endif
                            </div>
                            @if ($j->summary)<p>{{ $j->summary }}</p>@endif
                        </div>
                        <a href="{{ route('career', $j->slug) }}" class="btn btn-primary">View &amp; Apply <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            @empty
                <div class="col-lg-7 text-center">
                    <div class="empty-jobs"><i class="bi bi-briefcase"></i><p>Please check back soon, or send us your details and we will keep them on file.</p><a href="{{ route('contact') }}" class="btn btn-primary">Contact Us</a></div>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- How to apply --}}
<section class="section">
    <div class="container">
        <div class="reveal section-title text-center"><span class="eyebrow">Simple Process</span><h2>How To Apply</h2></div>
        <div class="row g-4 reveal">
            @foreach ([['search', 'Choose a Role', 'Browse the open positions and pick the one that suits you.'], ['file-earmark-person', 'Submit Your Application', 'Fill in the short form and attach your resume (PDF or DOC).'], ['telephone-inbound', 'We Get In Touch', 'If you are shortlisted, our team will contact you.']] as $i => [$icon, $t, $d])
                <div class="col-md-4"><div class="step-card"><span class="n">{{ $i + 1 }}</span><i class="bi bi-{{ $icon }}"></i><h3>{{ $t }}</h3><p>{{ $d }}</p></div></div>
            @endforeach
        </div>
    </div>
</section>
@endsection
