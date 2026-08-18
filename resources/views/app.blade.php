<!DOCTYPE html>
<html lang="en-AU">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Search Console ownership verification.
         Keep permanently — removing it un-verifies the property. --}}
    <meta name="google-site-verification" content="WddVXjae_q2Ax214dYSSBSM23UhKwiXP8ULgjp3Pvoo">

    {{-- Title, description, canonical, Open Graph and JSON-LD.
         Server-rendered so non-JS crawlers (Facebook, LinkedIn, Slack)
         see real metadata. Edit copy in app/Support/Seo.php or override
         per page from admin Settings. --}}
    @include('partials.seo')

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icon-192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Satoshi (Fontshare) — display / headings --}}
    <link rel="preconnect" href="https://api.fontshare.com">
    <link rel="preconnect" href="https://cdn.fontshare.com" crossorigin>
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@300,400,500,700,900,1&display=swap" rel="stylesheet">

    {{-- Geist + Geist Mono (Google Fonts) — body / UI / captions --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@300..900&family=Geist+Mono:wght@400;500;700&display=swap"
        rel="stylesheet">

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @inertiaHead
</head>

<body class="antialiased">
    @inertia
</body>

</html>
