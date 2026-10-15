@extends('layouts.admin')
@section('title', 'Application')
@section('heading', 'Application #'.$item->id)

@section('content')
<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Position</dt><dd class="col-sm-9">{{ $item->job?->title ?? '— (job removed)' }}</dd>
            <dt class="col-sm-3">Name</dt><dd class="col-sm-9">{{ $item->name }}</dd>
            <dt class="col-sm-3">Email</dt><dd class="col-sm-9"><a href="mailto:{{ $item->email }}">{{ $item->email }}</a></dd>
            <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $item->phone ?: '—' }}</dd>
            <dt class="col-sm-3">Experience</dt><dd class="col-sm-9">{{ $item->experience ?: '—' }}</dd>
            <dt class="col-sm-3">Applied</dt><dd class="col-sm-9">{{ $item->created_at->format('d M Y, h:i A') }}</dd>
            <dt class="col-sm-3">Resume</dt><dd class="col-sm-9">@if($item->resume)<a href="{{ route('admin.applications.resume', $item) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i> Download</a>@else — @endif</dd>
            <dt class="col-sm-3">Cover Letter</dt><dd class="col-sm-9">{!! $item->cover_letter ? nl2br(e($item->cover_letter)) : '—' !!}</dd>
        </dl>
    </div>
</div>
<a href="{{ route('admin.applications.index') }}" class="btn btn-outline-secondary mt-3">&larr; Back</a>
@endsection
