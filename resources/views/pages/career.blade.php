@extends('layouts.frontend')
@section('title', $job->title.' | Careers | '.($S['site_name'] ?? 'Nubic'))

@section('content')
<div class="page-banner">
    <div class="container">
        <h1>{{ $job->title }}</h1>
        <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('careers') }}">Careers</a></li><li class="breadcrumb-item active">{{ $job->title }}</li></ol></nav>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="job-meta mb-4">
                    @if ($job->department)<div><small>Department</small><strong>{{ $job->department }}</strong></div>@endif
                    @if ($job->location)<div><small>Location</small><strong>{{ $job->location }}</strong></div>@endif
                    <div><small>Type</small><strong>{{ $job->job_type }}</strong></div>
                    @if ($job->experience)<div><small>Experience</small><strong>{{ $job->experience }}</strong></div>@endif
                    <div><small>Vacancies</small><strong>{{ $job->vacancies }}</strong></div>
                    @if ($job->closing_date)<div><small>Apply Before</small><strong>{{ $job->closing_date->format('d M Y') }}</strong></div>@endif
                </div>
                @if ($job->summary)<p class="lead">{{ $job->summary }}</p>@endif
                <div class="cms-content">{!! $job->description !!}</div>
            </div>
            <div class="col-lg-5">
                <div class="apply-card" id="apply">
                    <h3 class="text-uppercase mb-3">Apply Now</h3>
                    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                    <form method="POST" action="{{ route('career.apply', $job->slug) }}" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="d-none"><input type="text" name="website_url" tabindex="-1" autocomplete="off"></div>
                        <div class="col-12"><label class="form-label">Full Name *</label><input name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="col-md-6"><label class="form-label">Email *</label><input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">@error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="col-12"><label class="form-label">Total Experience</label><input name="experience" value="{{ old('experience') }}" class="form-control" placeholder="e.g. 3 years"></div>
                        <div class="col-12"><label class="form-label">Resume (PDF / DOC, max 4 MB) *</label><input type="file" name="resume" accept=".pdf,.doc,.docx" class="form-control @error('resume') is-invalid @enderror" required>@error('resume')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="col-12"><label class="form-label">Cover Letter</label><textarea name="cover_letter" rows="4" class="form-control">{{ old('cover_letter') }}</textarea></div>
                        <div class="col-12"><button class="btn btn-primary btn-lg w-100">Submit Application</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
