<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Hiking della Pietra Nera' }}</title>
    <meta name="description" content="{{ $description ?? 'Sito ufficiale Hiking della Pietra Nera.' }}">
    @isset($canonical)
        <link rel="canonical" href="{{ $canonical }}">
    @endisset
    <link rel="icon" type="image/png" href="/images/hiking/logo.png">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? 'Hiking della Pietra Nera' }}">
    <meta property="og:description" content="{{ $description ?? 'Sito ufficiale Hiking della Pietra Nera.' }}">
    <meta property="og:url" content="{{ $canonical ?? url()->current() }}">
    <meta property="og:image" content="{{ url('/images/hiking/logo.png') }}">
    <meta property="og:locale" content="it_IT">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'Hiking della Pietra Nera.' }}">
    <meta name="twitter:description" content="{{ $description ?? 'Sito ufficiale Hiking della Pietra Nera.' }}">
    <meta name="twitter:image" content="{{ url('/images/hiking/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/style.css?v=72">
    <link rel="stylesheet" href="/iscritti-home.css?v=1.3">
    @stack('head')
</head>

<body class="has-topbar sgranar-theme {{ $bodyClass ?? '' }}">
    <div class="site-header">
        <div class="center-text topbar center-items">
            <img class="topbar-logo" src="/images/hiking/logo.png" alt="Hiking della Pietra Nera">
        </div>

        @include('partials.navbar')
    </div>

    @yield('content')

    @include('partials.footer')
    @include('partials.cookie-banner')

    @stack('scripts')
</body>
</html>
