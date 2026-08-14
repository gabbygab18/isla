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
