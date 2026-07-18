<!DOCTYPE html>
<html lang="en-AU">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title inertia>{{ setting('brand_word', 'Isla') }} — Managed Virtual Staffing for Growing Australian Businesses
    </title>
    <meta name="description"
        content="Isla places dedicated virtual assistants for NDIS providers, healthcare and allied health practices, and growing Australian businesses. Flat management fee, lifetime replacement guarantee.">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Satoshi (Fontshare) — display / headings --}}
    <link rel="preconnect" href="https://api.fontshare.com">
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
