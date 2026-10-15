<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.frontend-header')
</head>
<body>
    @include('layouts.frontend-navbar')

    <main>
        @if (session('success'))
            <div class="container mt-3"><div class="alert alert-success mb-0">{{ session('success') }}</div></div>
        @endif
        @yield('content')
    </main>

    @include('layouts.frontend-footer')
</body>
</html>
