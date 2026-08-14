@php
    $seo = \App\Support\Seo::build(request());
@endphp

{{--
  head-key attributes let Inertia's client-side <Head> (SiteLayout.jsx) take
  ownership of these tags and keep them in sync on SPA navigation, instead of
  duplicating them. Tags that never change per-route (og:type, locale, twitter:card)
  are left Blade-only since there's nothing for the client to update.
--}}
<title inertia>{{ $seo['title'] }}</title>
<meta head-key="description" name="description" content="{{ $seo['description'] }}">
<link head-key="canonical" rel="canonical" href="{{ $seo['canonical'] }}">

@if ($seo['noindex'])
    <meta name="robots" content="noindex, nofollow">
@else
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
@endif

{{-- Open Graph — used by Facebook, LinkedIn, Slack, WhatsApp link previews --}}
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $seo['brand'] }}">
<meta property="og:locale" content="{{ $seo['locale'] }}">
<meta head-key="og:title" property="og:title" content="{{ $seo['title'] }}">
<meta head-key="og:description" property="og:description" content="{{ $seo['description'] }}">
<meta head-key="og:url" property="og:url" content="{{ $seo['canonical'] }}">
<meta head-key="og:image" property="og:image" content="{{ $seo['image'] }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $seo['brand'] }} — managed virtual staffing for Australian businesses">

<meta name="twitter:card" content="summary_large_image">
<meta head-key="twitter:title" name="twitter:title" content="{{ $seo['title'] }}">
<meta head-key="twitter:description" name="twitter:description" content="{{ $seo['description'] }}">
<meta head-key="twitter:image" name="twitter:image" content="{{ $seo['image'] }}">

<script type="application/ld+json">{!! json_encode($seo['schema'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
