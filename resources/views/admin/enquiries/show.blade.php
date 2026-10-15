@extends('layouts.admin')
@section('title', 'Enquiry')
@section('heading', 'Enquiry #'.$item->id)

@section('content')
<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Name</dt><dd class="col-sm-9">{{ $item->name }}</dd>
            <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $item->phone ?: '—' }}</dd>
            <dt class="col-sm-3">Email</dt><dd class="col-sm-9">@if($item->email)<a href="mailto:{{ $item->email }}">{{ $item->email }}</a>@else — @endif</dd>
            <dt class="col-sm-3">Product</dt><dd class="col-sm-9">{{ $item->product?->name ?: '—' }}</dd>
            <dt class="col-sm-3">Subject</dt><dd class="col-sm-9">{{ $item->subject ?: '—' }}</dd>
            <dt class="col-sm-3">Received</dt><dd class="col-sm-9">{{ $item->created_at->format('d M Y, h:i A') }}</dd>
            <dt class="col-sm-3">Message</dt><dd class="col-sm-9">{!! nl2br(e($item->message)) !!}</dd>
        </dl>
    </div>
</div>
<a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-secondary mt-3">&larr; Back</a>
@endsection
