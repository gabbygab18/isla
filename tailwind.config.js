/** @type {import('tailwindcss').Config} */
export default {
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
                // ── Isla brand swatches (unchanged from the Blade build) ──
                cream: '#fdf7ef',
                rose: {
                    DEFAULT: '#db9496',
                    deep: '#c17579',
                    soft: '#f2dcdd',
                },
                sage: {
                    DEFAULT: '#8f9d77',
                    deep: '#6f7d5c',
                    soft: '#e6e9db',
                },
                ink: {
                    DEFAULT: '#2b2723',
                    soft: '#6b6259',
                },
                hairline: {
                    DEFAULT: 'rgba(43, 39, 35, 0.16)',
                    soft: 'rgba(43, 39, 35, 0.09)',
                },
                'on-inverse-soft': 'rgba(253, 247, 239, 0.14)',

                // ── shadcn/scrollxui semantic tokens, mapped onto the Isla
                // brand palette above so imported ui/ components (Table,
                // Pagination, Button, Badge, DropdownMenu…) match the rest
                // of the site instead of shadcn's default neutral theme.
                background: '#fdf7ef',
                foreground: '#2b2723',
                card: { DEFAULT: '#ffffff', foreground: '#2b2723' },
                popover: { DEFAULT: '#ffffff', foreground: '#2b2723' },
                primary: { DEFAULT: '#2b2723', foreground: '#fdf7ef' },
                secondary: { DEFAULT: '#f2dcdd', foreground: '#c17579' },
                muted: { DEFAULT: '#f1ece3', foreground: '#6b6259' },
                accent: { DEFAULT: '#e6e9db', foreground: '#2b2723' },
                destructive: { DEFAULT: '#b23b3b', foreground: '#ffffff' },
                border: 'rgba(43, 39, 35, 0.16)',
                input: 'rgba(43, 39, 35, 0.16)',
                ring: '#2b2723',
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
