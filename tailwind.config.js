/** @type {import('tailwindcss').Config} */
export default {
    // next-themes toggles `class="dark"` on <html>, so the variants must be
    // class-driven rather than the default `media` (which follows the OS).
    darkMode: 'class',
    content: [
        './resources/views/app.blade.php',
        './resources/js/**/*.{js,jsx}',
    ],
    theme: {
        container: {
            center: true,
            padding: '2rem',
            screens: { '2xl': '1280px' },
        },
        extend: {
            colors: {
                // ── Isla brand swatches, driven by the channel variables in
                // app.css so `.dark` can repaint the whole palette. The
                // <alpha-value> placeholder keeps modifiers like bg-ink/40 working.
                cream: 'rgb(var(--c-cream) / <alpha-value>)',
                white: 'rgb(var(--c-white) / <alpha-value>)',
                rose: {
                    DEFAULT: 'rgb(var(--c-rose) / <alpha-value>)',
                    deep: 'rgb(var(--c-rose-deep) / <alpha-value>)',
                    soft: 'rgb(var(--c-rose-soft) / <alpha-value>)',
                },
                sage: {
                    DEFAULT: 'rgb(var(--c-sage) / <alpha-value>)',
                    deep: 'rgb(var(--c-sage-deep) / <alpha-value>)',
                    soft: 'rgb(var(--c-sage-soft) / <alpha-value>)',
                },
                ink: {
                    DEFAULT: 'rgb(var(--c-ink) / <alpha-value>)',
                    soft: 'rgb(var(--c-ink-soft) / <alpha-value>)',
                },
                hairline: {
                    DEFAULT: 'rgb(var(--c-hairline) / var(--hairline-alpha))',
                    soft: 'rgb(var(--c-hairline) / var(--hairline-soft-alpha))',
                },
                'on-inverse-soft': 'rgb(var(--c-cream) / 0.14)',

                // ── shadcn/scrollxui semantic tokens, mapped onto the Isla
                // brand palette above so imported ui/ components (Table,
                // Pagination, Button, Badge, DropdownMenu…) match the rest
                // of the site instead of shadcn's default neutral theme.
                // Driven by the same channel variables as the brand colours, so
                // imported ui/ components repaint with `.dark` too (the talent
                // deck is the only place that flips) instead of staying light.
                background: 'rgb(var(--c-cream) / <alpha-value>)',
                foreground: 'rgb(var(--c-ink) / <alpha-value>)',
                card: { DEFAULT: 'rgb(var(--c-white) / <alpha-value>)', foreground: 'rgb(var(--c-ink) / <alpha-value>)' },
                popover: { DEFAULT: 'rgb(var(--c-white) / <alpha-value>)', foreground: 'rgb(var(--c-ink) / <alpha-value>)' },
                primary: { DEFAULT: 'rgb(var(--c-ink) / <alpha-value>)', foreground: 'rgb(var(--c-cream) / <alpha-value>)' },
                secondary: { DEFAULT: 'rgb(var(--c-rose-soft) / <alpha-value>)', foreground: 'rgb(var(--c-rose-deep) / <alpha-value>)' },
                muted: { DEFAULT: 'rgb(var(--c-muted) / <alpha-value>)', foreground: 'rgb(var(--c-ink-soft) / <alpha-value>)' },
                accent: { DEFAULT: 'rgb(var(--c-sage-soft) / <alpha-value>)', foreground: 'rgb(var(--c-ink) / <alpha-value>)' },
                destructive: { DEFAULT: '#b23b3b', foreground: '#ffffff' },
                border: 'rgb(var(--c-hairline) / var(--hairline-alpha))',
                input: 'rgb(var(--c-hairline) / var(--hairline-alpha))',
                ring: 'rgb(var(--c-ink) / <alpha-value>)',
            },
            fontFamily: {
                // Satoshi → display / headings, Geist → body / UI
                display: ['Satoshi', 'Geist', 'system-ui', 'sans-serif'],
                sans: ['Geist', 'system-ui', '-apple-system', 'sans-serif'],
                mono: ['"Geist Mono"', 'SF Mono', 'menlo', 'monospace'],
            },
            borderRadius: {
                xs: '2px',
                sm: '6px',
                md: '8px',
                lg: '24px',
                xl: '32px',
                pill: '50px',
            },
            maxWidth: {
                container: '1280px',
            },
            boxShadow: {
                card: '0 14px 32px rgba(43,39,35,.09)',
                float: '0 24px 60px rgba(43,39,35,.12)',
                deep: '0 18px 36px rgba(43,39,35,.22)',
            },
            keyframes: {
                marquee: {
                    from: { transform: 'translateX(0)' },
                    to: { transform: 'translateX(-50%)' },
                },
                'marquee-y': {
                    from: { transform: 'translateY(0)' },
                    to: { transform: 'translateY(-50%)' },
                },
                'marquee-y-reverse': {
                    from: { transform: 'translateY(-50%)' },
                    to: { transform: 'translateY(0)' },
                },
                'spin-slow': {
                    from: { transform: 'rotate(0deg)' },
                    to: { transform: 'rotate(360deg)' },
                },
                'orb-pulse': {
                    '0%, 100%': { transform: 'scale(1)', opacity: '0.85' },
                    '50%': { transform: 'scale(1.18)', opacity: '1' },
                },
            },
            animation: {
                marquee: 'marquee 28s linear infinite',
                'marquee-y': 'marquee-y 36s linear infinite',
                'marquee-y-reverse': 'marquee-y-reverse 36s linear infinite',
                'spin-slow': 'spin-slow 8s linear infinite',
                'orb-pulse': 'orb-pulse 3.2s ease-in-out infinite',
            },
        },
    },
    plugins: [require('tailwindcss-animate')],
};
