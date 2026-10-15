<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Nubic</title>
    <link rel="icon" type="image/png" href="{{ asset('img/fevicon.png') }}">
    @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])
</head>
<body class="admin">
<div class="login-wrap px-3">
    <div class="login-card shadow-lg">
        <div class="brand mb-4"><span>N</span>UBIC<small>Admin Panel</small></div>

        @if ($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" required autofocus autocomplete="username">
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control form-control-lg" required autocomplete="current-password">
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button class="btn btn-primary w-100 btn-lg">Sign In</button>
        </form>
        <div class="text-center mt-3"><a href="{{ route('home') }}" class="small text-secondary">&larr; Back to website</a></div>
    </div>
</div>
</body>
</html>
