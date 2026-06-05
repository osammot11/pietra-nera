<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Sgranar per Colli' }}</title>
    <meta name="description" content="{{ $description ?? 'Sito ufficiale Sgranar per Colli.' }}">
    @isset($canonical)
        <link rel="canonical" href="{{ $canonical }}">
    @endisset
    <link rel="icon" type="image/svg+xml" href="/images/sgranar/asino-rosso.svg">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? 'Sgranar per Colli' }}">
    <meta property="og:description" content="{{ $description ?? 'Sito ufficiale Sgranar per Colli.' }}">
    <meta property="og:url" content="{{ $canonical ?? url()->current() }}">
    <meta property="og:image" content="https://sgranarpercolli.it/images/2023/copertina_sito.jpg">
    <meta property="og:locale" content="it_IT">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'Sgranar per Colli' }}">
    <meta name="twitter:description" content="{{ $description ?? 'Sito ufficiale Sgranar per Colli.' }}">
    <meta name="twitter:image" content="https://sgranarpercolli.it/images/2023/copertina_sito.jpg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/style.css?v=60">
    <link rel="stylesheet" href="/iscritti-home.css?v=1.3">
    @stack('head')
</head>

<body class="has-topbar sgranar-theme {{ $bodyClass ?? '' }}">
    <div class="site-header">
        <div class="center-text topbar center-items">
            <img class="topbar-logo" src="/images/sgranar/logo-bianco-rosso.svg" alt="Sgranar per Colli">
        </div>

        @include('partials.navbar')
    </div>

    @yield('content')

    @include('partials.footer')
    @include('partials.cookie-banner')

    @stack('scripts')
</body>
</html>
