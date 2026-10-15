@extends('layouts.admin')
@section('title', 'My Account')
@section('heading', 'My Account')

@section('content')
<form method="POST" action="{{ route('admin.account.update') }}" class="card" style="max-width: 640px">
    @csrf
    <div class="card-body">
        <div class="mb-3"><label class="form-label fw-semibold">Name</label>
            <input class="form-control" name="name" value="{{ old('name', auth()->user()->name) }}" required></div>
        <div class="mb-3"><label class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', auth()->user()->email) }}" required></div>
        <hr>
        <p class="text-secondary small">Leave the password fields empty to keep your current password.</p>
        <div class="mb-3"><label class="form-label fw-semibold">Current Password</label>
            <input type="password" class="form-control" name="current_password" autocomplete="current-password"></div>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label fw-semibold">New Password</label>
                <input type="password" class="form-control" name="password" autocomplete="new-password"></div>
            <div class="col-md-6"><label class="form-label fw-semibold">Confirm New Password</label>
                <input type="password" class="form-control" name="password_confirmation" autocomplete="new-password"></div>
        </div>
    </div>
    <div class="card-footer bg-white"><button class="btn btn-primary">Update Account</button></div>
</form>
@endsection
