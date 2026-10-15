<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', $S['meta_title'] ?? ($S['site_name'] ?? config('app.name')))</title>
<meta name="description" content="@yield('description', $S['meta_description'] ?? '')">
<link rel="icon" type="image/png" href="{{ !empty($S['favicon']) ? asset('storage/'.$S['favicon']) : asset('img/fevicon.png') }}">
@vite(['resources/scss/app.scss', 'resources/js/app.js'])
