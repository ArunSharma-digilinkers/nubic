@extends('layouts.frontend')
@section('title', 'Contact Us | '.($S['site_name'] ?? 'Nubic'))

@section('content')
<div class="page-banner">
    <div class="container">
        <h1>Contact Us</h1>
        <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Contact</li></ol></nav>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="contact-card">
                    <h3 class="text-uppercase mb-4">Get in Touch</h3>
                    @if (!empty($S['address']))<div class="item"><i class="bi bi-geo-alt-fill"></i><div><strong>Address</strong>{{ $S['address'] }}</div></div>@endif
                    @if (!empty($S['phone']))<div class="item"><i class="bi bi-telephone-fill"></i><div><strong>Phone</strong><a href="tel:{{ preg_replace('/\s+/', '', $S['phone']) }}">{{ $S['phone'] }}</a></div></div>@endif
                    @if (!empty($S['alt_phone']))<div class="item"><i class="bi bi-phone-fill"></i><div><strong>Alternate Mobile</strong><a href="tel:{{ preg_replace('/\s+/', '', $S['alt_phone']) }}">{{ $S['alt_phone'] }}</a></div></div>@endif
                    @if (!empty($S['email']))<div class="item"><i class="bi bi-envelope-fill"></i><div><strong>Email</strong><a href="mailto:{{ $S['email'] }}">{{ $S['email'] }}</a></div></div>@endif
                    @if (!empty($S['website']))<div class="item"><i class="bi bi-globe"></i><div><strong>Website</strong>{{ $S['website'] }}</div></div>@endif
                </div>
            </div>
            <div class="col-lg-7">
                <h3 class="text-uppercase mb-3">Send an Enquiry</h3>
                <form method="POST" action="{{ route('contact.send') }}" class="row g-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ old('product_id', $product?->id) }}">
                    <div class="d-none"><input type="text" name="website_url" tabindex="-1" autocomplete="off"></div>
                    @if ($product)<div class="col-12"><div class="alert alert-light border mb-0">Enquiry about: <strong>{{ $product->name }}</strong></div></div>@endif
                    <div class="col-md-6"><label class="form-label">Name *</label><input name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">@error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Subject</label><input name="subject" value="{{ old('subject') }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label">Message *</label><textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>@error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-12"><button class="btn btn-primary btn-lg">Send Enquiry</button></div>
                </form>
            </div>
        </div>
        @if (!empty($S['map_embed']))
            <div class="ratio ratio-21x9 mt-5"><iframe src="{{ $S['map_embed'] }}" loading="lazy" style="border:0" allowfullscreen></iframe></div>
        @endif
    </div>
</section>
@endsection
