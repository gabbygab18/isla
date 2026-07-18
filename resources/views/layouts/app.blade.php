<!DOCTYPE html>
<html lang="en-AU">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Isla — Managed Virtual Staffing for Growing Australian Businesses')</title>
    <meta name="description" content="@yield('meta_description', 'Isla places dedicated virtual assistants for NDIS providers, healthcare and allied health practices, and growing Australian businesses. Flat management fee, lifetime replacement guarantee.')">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@320;330;340;400;450;480;540;700;800&family=Cormorant+Garamond:wght@400;500&family=JetBrains+Mono:wght@400;500;700&display=swap"
        rel="stylesheet">
    <style>
        /* ==========================================================================
     TOKENS
     Palette = the four supplied brand swatches (cream / white / rose / sage).
     --ink is a supporting dark neutral derived to carry body text and the
     "primary" chrome role that the design.md system assigns to black —
     the brand sheet has no dark swatch of its own, so this is the one
     addition, kept strictly neutral (no hue lifted from rose or sage).
     Everything else below is a literal port of design.md's token set:
     spacing scale, radius scale, and the full type hierarchy.
     ========================================================================== */
        /* ==========================================================
     BRAND FONTS — self-hosted (licensed webfonts)
     Drop the purchased font files into public/fonts/ using the
     exact filenames below — .otf works fine (each @font-face
     lists .woff2 first, then falls back to .otf if that file
     isn't present). Until either is present, fallbacks render.
     Note: .otf files are larger/uncompressed vs .woff2, so swap
     in real .woff2 later if you get them (e.g. via a converter)
     for faster page loads — no other change needed to do so.
     ========================================================== */
        @font-face {
            font-family: 'Latom Grotesque';
            src: url('/fonts/LatomGrotesque-Regular.woff2') format('woff2'),
                url('/fonts/LatomGrotesque-Regular.otf') format('opentype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Latom Grotesque';
            src: url('/fonts/LatomGrotesque-Medium.woff2') format('woff2'),
                url('/fonts/LatomGrotesque-Medium.otf') format('opentype');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Latom Grotesque';
            src: url('/fonts/LatomGrotesque-SemiBold.woff2') format('woff2'),
                url('/fonts/LatomGrotesque-SemiBold.otf') format('opentype');
            font-weight: 600;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Latom Grotesque';
            src: url('/fonts/LatomGrotesque-Bold.woff2') format('woff2'),
                url('/fonts/LatomGrotesque-Bold.otf') format('opentype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'LTS Raela Pro';
            src: url('/fonts/LTSRaelaPro-Regular.woff2') format('woff2'),
                url('/fonts/LTSRaelaPro-Regular.otf') format('opentype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'LTS Raela Pro';
            src: url('/fonts/LTSRaelaPro-Italic.woff2') format('woff2'),
                url('/fonts/LTSRaelaPro-Italic.otf') format('opentype');
            font-weight: 400;
            font-style: italic;
            font-display: swap;
        }

        @font-face {
            font-family: 'LTS Raela Pro';
            src: url('/fonts/LTSRaelaPro-Medium.woff2') format('woff2'),
                url('/fonts/LTSRaelaPro-Medium.otf') format('opentype');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'LTS Raela Pro';
            src: url('/fonts/LTSRaelaPro-SemiBold.woff2') format('woff2'),
                url('/fonts/LTSRaelaPro-SemiBold.otf') format('opentype');
            font-weight: 600;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'LTS Raela Pro';
            src: url('/fonts/LTSRaelaPro-Bold.woff2') format('woff2'),
                url('/fonts/LTSRaelaPro-Bold.otf') format('opentype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        :root {
            /* brand */
            --cream: #fdf7ef;
            --white: #ffffff;
            --rose: #db9496;
            --sage: #8f9d77;

            /* supporting neutral + derived tints (never used as a 5th "accent") */
            --ink: #2b2723;
            --ink-soft: #6b6259;
            --rose-deep: #c17579;
            --rose-soft: #f2dcdd;
            --sage-deep: #6f7d5c;
            --sage-soft: #e6e9db;
            --hairline: rgba(43, 39, 35, 0.16);
            --hairline-soft: rgba(43, 39, 35, 0.09);
            --on-inverse-soft: rgba(253, 247, 239, 0.14);

            /* spacing — design.md spacing scale */
            --sp-hair: 1px;
            --sp-xxs: 4px;
            --sp-xs: 8px;
            --sp-sm: 12px;
            --sp-md: 16px;
            --sp-lg: 24px;
            --sp-xl: 32px;
            --sp-xxl: 48px;
            --sp-section: 96px;

            /* radius — design.md radius scale */
            --r-xs: 2px;
            --r-sm: 6px;
            --r-md: 8px;
            --r-lg: 24px;
            --r-xl: 32px;
            --r-pill: 50px;
            --r-full: 9999px;

            --font-sans: 'LTS Raela Pro', 'Inter', system-ui, -apple-system, sans-serif;
            --font-head: 'Latom Grotesque', 'LTS Raela Pro', 'Inter', system-ui, sans-serif;
            --font-mono: 'JetBrains Mono', 'SF Mono', menlo, monospace;
            --container: 1280px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 76px;
        }

        body {
            margin: 0;
            background: var(--cream);
            color: var(--ink);
            font-family: var(--font-sans);
            font-weight: 320;
            font-size: 18px;
            line-height: 1.45;
            letter-spacing: -0.26px;
            -webkit-font-smoothing: antialiased;
        }

        img {
            max-width: 100%;
            display: block;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
            background: none;
        }

        :focus-visible {
            outline: 2.5px solid var(--ink);
            outline-offset: 3px;
            border-radius: 4px;
        }

        .container {
            max-width: var(--container);
            margin: 0 auto;
            padding: 0 32px;
        }

        /* ==========================================================================
     TYPE HIERARCHY — exact tokens from design.md, substituting figmaSans /
     figmaMono for Inter / JetBrains Mono per the documented substitute note.
     ========================================================================== */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-head);
        }

        .t-display-xl,
        .t-display-lg,
        .t-headline,
        .t-subhead,
        .t-card-title {
            font-family: var(--font-head);
        }

        .t-display-xl {
            font-size: clamp(2.6rem, 6vw, 5.375rem);
            font-weight: 340;
            line-height: 1.00;
            letter-spacing: -1.72px;
            margin: 0;
        }

        .t-display-lg {
            font-size: clamp(2.1rem, 4.4vw, 4rem);
            font-weight: 340;
            line-height: 1.10;
            letter-spacing: -0.96px;
            margin: 0;
        }

        .t-headline {
            font-size: 26px;
            font-weight: 540;
            line-height: 1.35;
            letter-spacing: -0.26px;
            margin: 0;
        }

        .t-subhead {
            font-size: 26px;
            font-weight: 340;
            line-height: 1.35;
            letter-spacing: -0.26px;
            margin: 0;
        }

        .t-card-title {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.45;
            letter-spacing: 0;
            margin: 0;
        }

        .t-body-lg {
            font-size: 20px;
            font-weight: 330;
            line-height: 1.40;
            letter-spacing: -0.14px;
            margin: 0;
        }

        .t-body {
            font-size: 18px;
            font-weight: 320;
            line-height: 1.45;
            letter-spacing: -0.26px;
            margin: 0;
        }

        .t-body-sm {
            font-size: 16px;
            font-weight: 330;
            line-height: 1.45;
            letter-spacing: -0.14px;
            margin: 0;
        }

        .t-link {
            font-size: 20px;
            font-weight: 480;
            line-height: 1.40;
            letter-spacing: -0.10px;
        }

        .t-eyebrow {
            font-family: var(--font-mono);
            font-size: 18px;
            font-weight: 400;
            line-height: 1.30;
            letter-spacing: 0.54px;
            text-transform: uppercase;
            margin: 0 0 16px;
        }

        .t-caption {
            font-family: var(--font-mono);
            font-size: 12px;
            font-weight: 400;
            line-height: 1.00;
            letter-spacing: 0.60px;
            text-transform: uppercase;
        }

        /* ==========================================================================
     BUTTONS — pill is the only shape. Ink carries "primary" the way the
     spec's black does; white/cream carries "secondary".
     ========================================================================== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            font-family: var(--font-sans);
            font-size: 20px;
            font-weight: 480;
            letter-spacing: -0.10px;
            border-radius: var(--r-pill);
            transition: transform .16s ease, background .16s ease, color .16s ease;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--ink);
            color: var(--cream);
            padding: 10px 24px;
        }

        .btn-primary:hover {
            background: var(--rose-deep);
            color: var(--white);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--ink);
            padding: 8px 22px 10px;
        }

        .btn-secondary:hover {
            background: var(--ink);
            color: var(--cream);
            transform: translateY(-2px);
        }

        .btn-on-dark {
            background: var(--cream);
            color: var(--ink);
            padding: 10px 24px;
        }

        .btn-on-dark:hover {
            background: var(--white);
            transform: translateY(-2px);
        }

        .btn-sm {
            font-size: 16px;
            padding: 8px 18px;
        }

        .btn-block {
            width: 100%;
        }

        .btn-text {
            font-size: 20px;
            font-weight: 480;
            letter-spacing: -0.10px;
            border-radius: var(--r-full);
            padding: 8px 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-text:hover {
            color: var(--rose-deep);
        }

        .icon {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        .icon-lg {
            width: 26px;
            height: 26px;
        }

        .icon-btn {
            width: 44px;
            height: 44px;
            border-radius: var(--r-full);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--white);
            color: var(--ink);
            flex-shrink: 0;
        }

        .icon-btn-inverse {
            background: var(--on-inverse-soft);
            color: var(--cream);
        }

        /* ==========================================================================
     NAV — canvas surface, sticky.
     ========================================================================== */
        .nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(253, 247, 239, 0.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid transparent;
            transition: border-color .2s ease;
        }

        .nav.is-scrolled {
            border-bottom-color: var(--hairline);
        }

        .nav__inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 32px;
            gap: 24px;
        }

        /* ==========================================================================
     BRAND — the supplied logo mark, paired with the wordmark reproduced in
     Cormorant Garamond (matching the uploaded lockup's thin, wide-tracked
     serif) so it stays crisp at any size instead of embedding flattened text.
     ========================================================================== */
        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .brand__icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            flex-shrink: 0;
        }

        .brand__word {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-size: 22px;
            letter-spacing: 0.30em;
            text-transform: uppercase;
            color: var(--ink);
            padding-left: 2px;
        }

        .nav__links {
            display: flex;
            align-items: center;
            gap: 26px;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .nav__links::-webkit-scrollbar {
            display: none;
        }

        .nav__links a {
            font-size: 15.5px;
            font-weight: 450;
            flex-shrink: 0;
        }

        .nav__links a:hover {
            color: var(--rose-deep);
        }

        .nav__actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nav__toggle {
            display: none;
            color: var(--ink);
        }

        /* ==========================================================================
     MARQUEE STRIP — the one documented inverse-canvas ribbon under the nav.
     ========================================================================== */
        .marquee {
            background: var(--ink);
            color: var(--cream);
            height: 44px;
            overflow: hidden;
            position: relative;
        }

        .marquee__track {
            display: flex;
            align-items: center;
            height: 100%;
            width: max-content;
            animation: marquee 26s linear infinite;
        }

        .marquee__item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 28px;
            white-space: nowrap;
        }

        .marquee__dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--rose);
            flex-shrink: 0;
        }

        @keyframes marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* ==========================================================================
     SECTIONS
     ========================================================================== */
        .section {
            padding: var(--sp-section) 0;
        }

        .section-tight {
            padding: 64px 0;
        }

        .section__head {
            max-width: 640px;
            margin: 0 0 56px;
        }

        .section__head.center {
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        /* color-block sections: full content width, rounded-lg, xxl padding */
        .block {
            border-radius: var(--r-lg);
            padding: var(--sp-xxl);
        }

        .block-rose {
            background: var(--rose);
        }

        .block-sage {
            background: var(--sage);
        }

        .block-ink {
            background: var(--ink);
            color: var(--cream);
        }

        .block .t-eyebrow {
            color: var(--ink);
            opacity: .62;
        }

        .block-ink .t-eyebrow {
            color: var(--cream);
            opacity: .6;
        }

        .block-ink .t-body,
        .block-ink .t-body-lg,
        .block-ink p {
            color: #d9d2c6;
        }

        /* ==========================================================================
     HERO
     ========================================================================== */
        .hero {
            padding: 56px 0 var(--sp-section);
        }

        .hero__grid {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 64px;
            align-items: center;
        }

        .hero__eyebrow {
            color: var(--rose-deep);
        }

        .hero__sub {
            max-width: 520px;
            margin: 20px 0 32px;
            color: var(--ink-soft);
        }

        .hero__ctas {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .hero__visual {
            position: relative;
        }

        .hero__frame {
            border-radius: var(--r-xl);
            overflow: hidden;
            aspect-ratio: 4/4.6;
        }

        .hero__frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero__badge {
            position: absolute;
            left: -20px;
            bottom: -24px;
            background: var(--white);
            border: 1px solid var(--hairline);
            border-radius: var(--r-md);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: 250px;
        }

        .hero__badge strong {
            display: block;
            font-size: 22px;
            font-weight: 700;
        }

        .hero__badge span {
            font-size: 13px;
            color: var(--ink-soft);
            line-height: 1.3;
        }

        /* ==========================================================================
     CARDS
     ========================================================================== */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .card {
            background: var(--white);
            border-radius: var(--r-md);
            padding: var(--sp-lg);
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .svc-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 14px;
        }

        .svc-chip {
            font-family: var(--font-mono);
            font-size: 11px;
            letter-spacing: .4px;
            text-transform: uppercase;
            padding: 6px 12px;
            border-radius: var(--r-pill);
            background: var(--sage-soft);
            color: var(--sage-deep);
        }

        .svc-chip--more {
            background: var(--rose-soft);
            color: var(--rose-deep);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -24px rgba(43, 39, 35, 0.28);
        }

        .card__icon {
            width: 48px;
            height: 48px;
            border-radius: var(--r-md);
            background: var(--rose-soft);
            color: var(--rose-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }

        .card--audience .card__icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: var(--sage-soft);
            color: var(--sage-deep);
        }

        .card h3 {
            font-size: 19px;
            font-weight: 700;
            margin: 0 0 8px;
            letter-spacing: -0.2px;
        }

        .card p {
            margin: 0;
            color: var(--ink-soft);
            font-size: 15px;
            font-weight: 330;
            line-height: 1.5;
        }

        /* process steps inside sage block */
        .process {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
            margin-top: 36px;
        }

        .process__step .t-caption {
            display: inline-block;
            border: 1.5px solid var(--ink);
            border-radius: var(--r-pill);
            padding: 5px 14px;
            margin-bottom: 16px;
            color: var(--ink);
        }

        .process__step h3 {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 8px;
        }

        .process__step p {
            margin: 0;
            color: var(--ink);
            opacity: .75;
            font-size: 15px;
        }

        /* checklist inside rose block */
        .checklist {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 28px;
        }

        .checklist li {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .checklist .icon-wrap {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--ink);
            color: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .checklist strong {
            display: block;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .checklist span {
            font-size: 14.5px;
            opacity: .75;
        }

        /* ==========================================================================
     PRICING
     ========================================================================== */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            align-items: stretch;
        }

        .price-card {
            background: var(--white);
            border: 1px solid var(--hairline);
            border-radius: var(--r-lg);
            padding: var(--sp-lg);
            display: flex;
            flex-direction: column;
            position: relative;
            transition: transform .22s ease;
        }

        .price-card:hover {
            transform: translateY(-6px);
        }

        .price-card--featured {
            background: var(--ink);
            border-color: var(--ink);
            color: var(--cream);
        }

        .price-card--featured .price-card__tag {
            color: var(--rose);
        }

        .price-card--featured .price-card__detail {
            color: var(--cream);
        }

        .price-card--featured p {
            color: #cfc8bd;
        }

        .price-card__ribbon {
            position: absolute;
            top: -13px;
            left: 24px;
            background: var(--rose);
            color: var(--ink);
            font-family: var(--font-mono);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: var(--r-pill);
        }

        .price-card__tag {
            font-weight: 700;
            font-size: 14px;
            color: var(--rose-deep);
            margin: 6px 0 12px;
        }

        .price-card__detail {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 14px;
        }

        .price-card p {
            font-size: 14.5px;
            color: var(--ink-soft);
            flex-grow: 1;
            margin: 0 0 24px;
        }

        /* ==========================================================================
     ACCORDION (inside rose block)
     ========================================================================== */
        .accordion {
            max-width: 760px;
            margin: 32px auto 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .accordion__item {
            background: rgba(253, 247, 239, 0.55);
            border-radius: var(--r-md);
            overflow: hidden;
        }

        .accordion__trigger {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            text-align: left;
            padding: 18px 22px;
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
        }

        .accordion__trigger .icon {
            transition: transform .25s ease;
        }

        .accordion__item.is-open .accordion__trigger .icon {
            transform: rotate(180deg);
        }

        .accordion__panel {
            max-height: 0;
            overflow: hidden;
            transition: max-height .3s ease;
        }

        .accordion__item.is-open .accordion__panel {
            max-height: 220px;
        }

        .accordion__panel p {
            padding: 0 22px 20px;
            font-size: 14.5px;
            color: var(--ink);
            opacity: .8;
            margin: 0;
        }

        /* ==========================================================================
     CTA BAND (ink block)
     ========================================================================== */
        .cta-band__inner {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .cta-band .icon-btn {
            margin-bottom: 20px;
        }

        .cta-band h2 {
            color: var(--cream);
        }

        .cta-band__note {
            margin: 18px 0 0;
            font-size: 14px;
            color: #a89e8f;
        }

        .cta-band__note a {
            color: var(--rose);
            font-weight: 600;
            text-decoration: underline;
        }

        /* ==========================================================================
     CONTACT (rose block)
     ========================================================================== */
        .contact-grid {
            display: grid;
            grid-template-columns: .85fr 1.15fr;
            gap: 56px;
            align-items: start;
        }

        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 24px;
        }

        .contact-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 15px;
        }

        .form input,
        .form select,
        .form textarea {
            width: 100%;
            padding: 12px 14px;
            border-radius: var(--r-md);
            border: 1px solid var(--hairline);
            background: var(--white);
            font-family: var(--font-sans);
            font-size: 15px;
            color: var(--ink);
        }

        .form label {
            display: block;
            font-family: var(--font-mono);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: 7px;
            opacity: .75;
        }

        .form__row {
            margin-bottom: 18px;
        }

        .form__row--split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form textarea {
            resize: vertical;
        }

        .form__success {
            display: none;
            margin-top: 16px;
            padding: 12px 16px;
            background: var(--white);
            color: var(--sage-deep);
            font-weight: 700;
            font-size: 14px;
            border-radius: var(--r-md);
            text-align: center;
        }

        .form__success.is-visible {
            display: block;
        }

        /* ==========================================================================
     FOOTER — canvas surface, dense link grid, per spec (not inverse)
     ========================================================================== */
        .footer {
            background: var(--cream);
            border-top: 1px solid var(--hairline);
            padding-top: var(--sp-section);
        }

        .footer__grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 56px;
        }

        .footer__brand .brand {
            margin-bottom: 16px;
        }

        .footer__brand .brand__icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
        }

        .footer__brand .brand__word {
            font-size: 27px;
        }

        .footer__brand p {
            font-size: 14px;
            color: var(--ink-soft);
            max-width: 230px;
        }

        .footer__social {
            display: flex;
            gap: 10px;
            margin-top: 18px;
        }

        .footer__social a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid var(--hairline);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer__social a:hover {
            background: var(--ink);
            color: var(--cream);
            border-color: var(--ink);
        }

        .footer__col {
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        .footer__col h4 {
            font-family: var(--font-mono);
            font-size: 11px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin: 0 0 6px;
        }

        .footer__col a {
            font-size: 14.5px;
        }

        .footer__col a:hover {
            color: var(--rose-deep);
        }

        .footer__bottom {
            border-top: 1px solid var(--hairline);
            padding: 22px 0;
        }

        .footer__bottom p {
            margin: 0;
            font-size: 13px;
            font-family: var(--font-mono);
            letter-spacing: .02em;
            color: var(--ink-soft);
        }

        /* ==========================================================================
     REVEAL
     ========================================================================== */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ==========================================================================
     RESPONSIVE — breakpoints per design.md (960 tablet, 768 mobile-l, 560 mobile)
     ========================================================================== */
        @media (max-width:960px) {
            .hero__grid {
                grid-template-columns: 1fr;
            }

            .hero__visual {
                order: -1;
                max-width: 420px;
                margin: 0 auto 12px;
            }

            .grid-3,
            .pricing-grid,
            .process {
                grid-template-columns: repeat(2, 1fr);
            }

            .contact-grid {
                grid-template-columns: 1fr;
                gap: 36px;
            }

            .footer__grid {
                grid-template-columns: 1fr 1fr;
            }

            .nav__links {
                position: fixed;
                inset: 70px 0 0 0;
                background: var(--cream);
                flex-direction: column;
                align-items: flex-start;
                gap: 0;
                padding: 8px 32px 24px;
                transform: translateY(-8px);
                opacity: 0;
                pointer-events: none;
                transition: opacity .2s ease, transform .2s ease;
                border-top: 1px solid var(--hairline);
            }

            .nav__links.is-open {
                opacity: 1;
                transform: translateY(0);
                pointer-events: auto;
            }

            .nav__links a {
                width: 100%;
                padding: 14px 0;
                border-bottom: 1px solid var(--hairline);
            }

            .nav__toggle {
                display: block;
            }

            .nav__actions .btn-sm {
                display: none;
            }
        }

        @media (max-width:768px) {
            .block {
                border-radius: 0;
                margin-left: calc(-1 * var(--sp-lg));
                margin-right: calc(-1 * var(--sp-lg));
                padding: var(--sp-xl) var(--sp-lg);
            }
        }

        @media (max-width:560px) {

            .grid-3,
            .grid-2,
            .pricing-grid,
            .process {
                grid-template-columns: 1fr;
            }

            .form__row--split {
                grid-template-columns: 1fr;
            }

            .section {
                padding: 64px 0;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }

            .hero__ctas .btn {
                width: 100%;
            }
        }
    </style>
    <style>
        /* ==========================================================================
     DETAIL PAGES — small additions layered on the same token system.
     ========================================================================== */
        .detail-hero {
            padding: 56px 0 24px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
            font-family: var(--font-mono);
            font-size: 12px;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }

        .breadcrumb a:hover {
            color: var(--rose-deep);
        }

        .breadcrumb svg {
            width: 14px;
            height: 14px;
            opacity: .5;
        }

        .detail__eyebrow {
            color: var(--rose-deep);
        }

        .detail__lede {
            max-width: 640px;
            margin: 18px 0 0;
            color: var(--ink-soft);
        }

        .detail__layout {
            display: grid;
            grid-template-columns: 1.5fr .9fr;
            gap: 56px;
            align-items: start;
            padding-top: 40px;
        }

        .prose p {
            margin: 0 0 18px;
            color: var(--ink-soft);
            font-size: 18px;
            line-height: 1.6;
        }

        .prose p:last-child {
            margin-bottom: 0;
        }

        .detail__icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: var(--rose-soft);
            color: var(--rose-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }

        .detail__list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 8px;
        }

        .detail__list li {
            display: flex;
            gap: 13px;
            align-items: flex-start;
        }

        .detail__list .icon-wrap {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--sage);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .detail__list span {
            font-size: 16px;
            color: var(--ink);
        }

        .detail__aside {
            position: sticky;
            top: 96px;
            background: var(--white);
            border: 1px solid var(--hairline);
            border-radius: var(--r-lg);
            padding: var(--sp-lg);
        }

        .detail__aside h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 8px;
        }

        .detail__aside p {
            font-size: 14.5px;
            color: var(--ink-soft);
            margin: 0 0 18px;
        }

        .related-head {
            margin: 0 0 28px;
        }

        .plan-detail__price {
            font-family: var(--font-mono);
            font-size: 15px;
            font-weight: 500;
            color: var(--rose-deep);
            letter-spacing: .02em;
            margin: 6px 0 0;
        }

        .flash {
            margin-top: 16px;
            padding: 12px 16px;
            background: var(--white);
            color: var(--sage-deep);
            font-weight: 700;
            font-size: 14px;
            border-radius: var(--r-md);
            text-align: center;
        }

        @media (max-width:960px) {
            .detail__layout {
                grid-template-columns: 1fr;
                gap: 36px;
            }

            .detail__aside {
                position: static;
            }
        }
    </style>
    <style>
        /* ==========================================================================
     TRUST BAR — four-up strip of credibility markers, used on lead-gen pages
     (About, Book a Call, Cost Estimator, Contact).
     ========================================================================== */
        .trust-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: var(--hairline);
            border: 1px solid var(--hairline);
            border-radius: var(--r-md);
            overflow: hidden;
        }

        .trust-bar__item {
            background: var(--white);
            padding: 22px 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .trust-bar__item .icon-wrap {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--sage-soft);
            color: var(--sage-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .trust-bar__item span {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.4;
            color: var(--ink);
        }

        .trust-bar--on-dark {
            border-color: var(--on-inverse-soft);
            background: var(--on-inverse-soft);
        }

        .trust-bar--on-dark .trust-bar__item {
            background: var(--ink);
        }

        .trust-bar--on-dark .trust-bar__item span {
            color: var(--cream);
        }

        .trust-bar--on-dark .trust-bar__item .icon-wrap {
            background: var(--on-inverse-soft);
            color: var(--rose);
        }

        @media (max-width:768px) {
            .trust-bar {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width:560px) {
            .trust-bar {
                grid-template-columns: 1fr;
            }
        }

        /* ==========================================================================
     STAT GRID — used on About
     ========================================================================== */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 8px;
        }

        .stat-grid__item strong {
            display: block;
            font-size: clamp(1.9rem, 3.4vw, 2.7rem);
            font-weight: 340;
            letter-spacing: -1px;
        }

        .stat-grid__item span {
            display: block;
            margin-top: 6px;
            font-size: 14px;
            color: var(--ink-soft);
        }

        .block-ink .stat-grid__item span {
            color: #a89e8f;
        }

        @media (max-width:768px) {
            .stat-grid {
                grid-template-columns: 1fr 1fr;
                row-gap: 32px;
            }
        }

        /* ==========================================================================
     ROLE GRID — Team We Build page (services reframed as roles)
     ========================================================================== */
        .role-card {
            background: var(--white);
            border: 1px solid var(--hairline);
            border-radius: var(--r-md);
            padding: var(--sp-lg);
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .role-card .card__icon {
            margin-bottom: 0;
        }

        .role-card h3 {
            font-size: 17px;
            font-weight: 700;
            margin: 0 0 6px;
        }

        .role-card p {
            margin: 0;
            font-size: 14.5px;
            color: var(--ink-soft);
            line-height: 1.5;
        }

        /* ==========================================================================
     COST ESTIMATOR — calculator card + form controls
     ========================================================================== */
        .calc {
            background: var(--white);
            border-radius: var(--r-lg);
            padding: var(--sp-xl);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 44px;
            align-items: start;
        }

        .calc__row {
            margin-bottom: 22px;
        }

        .calc__row label {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            font-family: var(--font-mono);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: 10px;
            opacity: .75;
        }

        .calc__row label span.calc__val {
            font-family: var(--font-sans);
            font-size: 15px;
            text-transform: none;
            letter-spacing: 0;
            font-weight: 700;
            color: var(--rose-deep);
            opacity: 1;
        }

        .calc input[type="range"] {
            width: 100%;
            accent-color: var(--rose-deep);
            height: 4px;
        }

        .calc select {
            width: 100%;
            padding: 12px 14px;
            border-radius: var(--r-md);
            border: 1px solid var(--hairline);
            background: var(--white);
            font-family: var(--font-sans);
            font-size: 15px;
            color: var(--ink);
        }

        .calc__chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .calc__chip {
            padding: 8px 16px;
            border-radius: var(--r-pill);
            border: 1px solid var(--hairline);
            font-size: 13.5px;
            font-weight: 600;
            background: var(--white);
        }

        .calc__chip.is-active {
            background: var(--ink);
            color: var(--cream);
            border-color: var(--ink);
        }

        .calc__result {
            background: var(--cream);
            border-radius: var(--r-lg);
            padding: var(--sp-lg);
        }

        .calc__result-figure {
            font-size: clamp(2rem, 4vw, 2.9rem);
            font-weight: 340;
            letter-spacing: -1px;
            margin: 6px 0 0;
        }

        .calc__result-figure small {
            font-size: 16px;
            font-weight: 450;
            opacity: .6;
        }

        .calc__savings {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            padding: 8px 14px;
            border-radius: var(--r-pill);
            background: var(--sage-soft);
            color: var(--sage-deep);
            font-size: 13.5px;
            font-weight: 700;
        }

        .calc__breakdown {
            list-style: none;
            margin: 20px 0 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
            border-top: 1px solid var(--hairline);
            padding-top: 16px;
        }

        .calc__breakdown li {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: var(--ink-soft);
        }

        .calc__breakdown li strong {
            color: var(--ink);
            font-weight: 600;
        }

        .calc__disclaimer {
            font-size: 12.5px;
            color: var(--ink-soft);
            margin-top: 18px;
            line-height: 1.5;
        }

        @media (max-width:960px) {
            .calc {
                grid-template-columns: 1fr;
                gap: 28px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    @include('partials.icons')

    <header class="nav" id="nav">
        <div class="container nav__inner">
            <a href="{{ route('isla.index') }}" class="brand">
                <img src="{{ asset('logo.png') }}" alt="{{ setting('brand_word', 'Isla') }}" class="brand__icon">
                <span class="brand__word">{{ setting('brand_word', 'Isla') }}</span>
            </a>
            <nav class="nav__links" id="navLinks">
                @forelse ($navItems ?? [] as $item)
                    <a href="{{ $item->url }}">{{ $item->label }}</a>
                @empty
                    <a href="{{ route('isla.services.index') }}">Services</a>
                    <a href="{{ route('isla.contact.page') }}">Contact</a>
                @endforelse
            </nav>
            <div class="nav__actions">
                <a href="{{ route('isla.book-call') }}" class="btn btn-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <!--Boxicons v3.0.8 https://boxicons.com | License  https://docs.boxicons.com/free-->
                        <path
                            d="M19 4h-2V2h-2v2H9V2H7v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2M5 20V8h14V6v14z">
                        </path>
                        <path
                            d="m12.22 11.14-.22.22-.22-.22c-.86-.86-2.23-.86-3.1 0-.86.86-.86 2.21 0 3.07L12 17.5l3.32-3.29c.86-.86.86-2.21 0-3.07-.87-.86-2.23-.86-3.1 0">
                        </path>
                    </svg>
                    {{ setting('hero_cta_label', 'Book a Discovery Call') }}
                </a>
                <button class="nav__toggle" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
                    <svg class="icon icon-lg">
                        <use href="#i-menu" id="menuIcon" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    @php
        $marqueeItems = array_values(
            array_filter(
                array_map(
                    'trim',
                    preg_split(
                        '/\r\n|\r|\n/',
                        setting(
                            'marquee_items',
                            "NDIS-aware onboarding\nFlat management fee\nLifetime replacement guarantee\nAU business-hours overlap",
                        ),
                    ),
                ),
            ),
        );
    @endphp
    <div class="marquee" aria-hidden="true">
        <div class="marquee__track">
            @foreach (array_merge($marqueeItems, $marqueeItems) as $phrase)
                <span class="marquee__item"><span class="marquee__dot"></span><span
                        class="t-caption">{{ $phrase }}</span></span>
            @endforeach
        </div>
    </div>

    @yield('content')

    <footer class="footer">
        <div class="container footer__grid">
            <div class="footer__brand">
                <a href="{{ route('isla.index') }}" class="brand">
                    <img src="{{ asset('logo.png') }}" alt="{{ setting('brand_word', 'Isla') }}" class="brand__icon">
                    <span class="brand__word">{{ setting('brand_word', 'Isla') }}</span>
                </a>
                <p>{{ setting('footer_tagline', 'Managed virtual staffing for growing Australian businesses.') }}</p>
                <div class="footer__social">
                    <a href="#" aria-label="LinkedIn"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="currentColor" viewBox="0 0 24 24">
                            <!--Boxicons v3.0.8 https://boxicons.com | License  https://docs.boxicons.com/free-->
                            <path
                                d="M4.983 2.821a2.188 2.188 0 1 0 0 4.376 2.188 2.188 0 1 0 0-4.376m4.254 6.034v12.139h3.769v-6.003c0-1.584.298-3.118 2.262-3.118 1.937 0 1.961 1.811 1.961 3.218v5.904H21v-6.657c0-3.27-.704-5.783-4.526-5.783-1.835 0-3.065 1.007-3.568 1.96h-.051v-1.66zm-6.142 0H6.87v12.139H3.095z">
                            </path>
                        </svg></a>
                    <a href="#" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="currentColor" viewBox="0 0 24 24">
                            <!--Boxicons v3.0.8 https://boxicons.com | License  https://docs.boxicons.com/free-->
                            <path
                                d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22 22 0 0 0 14.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202z" />
                        </svg></a>
                </div>
            </div>
            <div class="footer__col">
                <h4>Navigate</h4>
                @forelse ($navItems ?? [] as $item)
                    <a href="{{ $item->url }}">{{ $item->label }}</a>
                @empty
                    <a href="{{ route('isla.services.index') }}">Services</a>
                @endforelse
            </div>
            <div class="footer__col">
                <h4>Legal</h4>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Confidentiality Statement</a>
            </div>
            <div class="footer__col">
                <h4>Contact</h4>
                <a
                    href="mailto:{{ setting('contact_email', 'hello@isla.com.au') }}">{{ setting('contact_email', 'hello@isla.com.au') }}</a>
                <a
                    href="tel:{{ preg_replace('/[^0-9+]/', '', setting('contact_phone', '+61 00 0000 0000')) }}">{{ setting('contact_phone', '+61 00 0000 0000') }}</a>
                <a href="{{ route('isla.book-call') }}">{{ setting('hero_cta_label', 'Book a Discovery Call') }}</a>
                <a href="{{ route('isla.contact.page') }}">General enquiry</a>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="container">
                <p>&copy; <span id="year">{{ date('Y') }}</span> {{ setting('brand_word', 'Isla') }}. All
                    rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        const navToggle = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');
        const menuIcon = document.getElementById('menuIcon');
        navToggle.addEventListener('click', () => {
            const isOpen = navLinks.classList.toggle('is-open');
            navToggle.setAttribute('aria-expanded', isOpen);
            menuIcon.setAttribute('href', isOpen ? '#i-x' : '#i-menu');
        });
        navLinks.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
            navLinks.classList.remove('is-open');
            navToggle.setAttribute('aria-expanded', false);
            menuIcon.setAttribute('href', '#i-menu');
        }));

        const nav = document.getElementById('nav');
        window.addEventListener('scroll', () => nav.classList.toggle('is-scrolled', window.scrollY > 12));

        document.querySelectorAll('.accordion__trigger').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = btn.closest('.accordion__item');
                const isOpen = item.classList.contains('is-open');
                item.closest('.accordion').querySelectorAll('.is-open').forEach(el => {
                    el.classList.remove('is-open');
                    el.querySelector('.accordion__trigger').setAttribute('aria-expanded', false);
                });
                if (!isOpen) {
                    item.classList.add('is-open');
                    btn.setAttribute('aria-expanded', true);
                }
            });
        });

        const revealEls = document.querySelectorAll('.reveal');
        if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });
            revealEls.forEach(el => io.observe(el));
        } else {
            revealEls.forEach(el => el.classList.add('is-visible'));
        }
    </script>
    @stack('scripts')
</body>

</html>
