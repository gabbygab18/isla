import { useEffect, useState } from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { CalendarHeart, Menu, X } from 'lucide-react';
import DropdownMenu from '@/components/scrollxui/DropdownMenu';
import ExpandableDock from '@/components/scrollxui/ExpandableDock';
import KineticTestimonials from '@/components/scrollxui/KineticTestimonials';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import ButterflyBackdrop from '@/components/site/ButterflyBackdrop';
import { cn, makeSetting } from '@/lib/utils';

function FacebookIcon(props) {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" {...props}>
            <path d="M12 2.06c-5.5 0-10 4.5-10 10 0 4.94 3.61 9.06 8.33 9.89l.06-.05h-.06v-7.06h-2.5v-2.78h2.5V9.84c0-2.5 1.61-3.89 3.89-3.89.72 0 1.5.11 2.22.22v2.56h-1.28c-1.22 0-1.5.61-1.5 1.39v1.94h2.67l-.44 2.78h-2.22v7.06h-.06l.06.05c4.72-.83 8.33-4.94 8.33-9.89 0-5.5-4.5-10-10-10" />
        </svg>
    );
}

function LinkedInIcon(props) {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" {...props}>
            <path d="M20 3H4a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1M8.339 18.337H5.667v-8.59h2.672zM7.003 8.574a1.548 1.548 0 1 1 0-3.096 1.548 1.548 0 0 1 0 3.096m11.335 9.763h-2.669V14.16c0-.996-.018-2.277-1.388-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248h-2.667v-8.59h2.56v1.174h.037c.355-.675 1.227-1.387 2.524-1.387 2.704 0 3.203 1.778 3.203 4.092v4.71z" />
        </svg>
    );
}

const FALLBACK_NAV = [
    { label: 'About Us', url: '/about' },
    { label: 'Team We Build', url: '/team-we-build' },
    { label: 'Industries', url: '/who-we-work-with' },
    { label: 'How it Works', url: '/how-it-works' },
    { label: 'Cost Estimator', url: '/cost-estimator' },
    { label: 'Pricing', url: '/pricing' },
    { label: 'FAQ', url: '/faq' },
    { label: 'Testimonials', url: '/testimonials' },
    { label: 'Careers', url: '/careers' },
    { label: 'Contact', url: '/contact' },
];

/**
 * `title` / `description` are kept as a fallback for the very first paint,
 * but the canonical values come from the server (app/Support/Seo.php) via
 * the shared `seo` prop, so both the initial Blade-rendered head (see
 * partials/seo.blade.php) and every client-side SPA navigation agree.
 * The `head-key` on each tag below matches the one in the Blade partial so
 * Inertia updates the existing tag in place instead of duplicating it.
 */
export default function SiteLayout({ title, description, children }) {
    const { settings, navItems, url, seo } = usePage().props ?? {};
    const currentUrl = usePage().url;
    const setting = makeSetting(settings);

    const brand = setting('brand_word', 'Isla');

    const origin = typeof window !== 'undefined' ? window.location.origin : '';
    const pageTitle = seo?.title || title || brand;
    const pageDescription = seo?.description || description || '';
    const pageCanonical = seo?.canonical || (origin ? origin + currentUrl : undefined);
    const pageImage = seo?.image || (origin ? origin + '/og-image.png' : undefined);

    // Also feeds the Organization "sameAs" block in app/Support/Seo.php —
    // keep the two in step if these ever move to admin Settings.
    const socials = [
        {
            label: 'LinkedIn',
            href: setting('social_linkedin', 'https://www.linkedin.com/company/islaoutsourcingsolutions'),
            Icon: LinkedInIcon,
        },
        {
            label: 'Facebook',
            href: setting('social_facebook', 'https://www.facebook.com/profile.php?id=61581617805323'),
            Icon: FacebookIcon,
        },
    ].filter((item) => item.href);
    const nav = navItems?.length ? navItems : FALLBACK_NAV;
    const primaryNav = nav.slice(0, 5);
    const moreNav = nav.slice(5);

    const [scrolled, setScrolled] = useState(false);
    const [mobileOpen, setMobileOpen] = useState(false);

    useEffect(() => {
        const onScroll = () => setScrolled(window.scrollY > 12);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
        return () => window.removeEventListener('scroll', onScroll);
    }, []);

    useEffect(() => setMobileOpen(false), [currentUrl]);

    const marqueeItems = String(
        setting(
            'marquee_items',
            'Sector-aware onboarding\nOne inclusive hourly rate\nOngoing replacement support\nAustralian-aligned working hours',
        ),
    )
        .split(/\r\n|\r|\n/)
        .map((s) => s.trim())
        .filter(Boolean);

    return (
        <div className="isolate min-h-screen bg-cream text-ink">
            <ButterflyBackdrop />
            <Head>
                <title>{pageTitle}</title>
                <meta head-key="description" name="description" content={pageDescription} />
                {pageCanonical && <link head-key="canonical" rel="canonical" href={pageCanonical} />}
                <meta head-key="og:title" property="og:title" content={pageTitle} />
                <meta head-key="og:description" property="og:description" content={pageDescription} />
                {pageCanonical && <meta head-key="og:url" property="og:url" content={pageCanonical} />}
                {pageImage && <meta head-key="og:image" property="og:image" content={pageImage} />}
                <meta head-key="twitter:title" name="twitter:title" content={pageTitle} />
                <meta head-key="twitter:description" name="twitter:description" content={pageDescription} />
                {pageImage && <meta head-key="twitter:image" name="twitter:image" content={pageImage} />}
            </Head>

            {/* ── NAV ─────────────────────────────────────────────── */}
            <header
                className={cn(
                    'fixed inset-x-0 top-0 z-50 transition-all duration-300',
                    scrolled ? 'bg-cream/90 shadow-[0_1px_0_rgba(43,39,35,0.08)] backdrop-blur-md' : 'bg-transparent',
                )}
            >
                <div className="container-site flex h-[72px] items-center justify-between gap-4">
                    <Link href="/" className="flex shrink-0 items-center">
                        <img src="/logo.png" alt={brand} className="h-12 w-auto" />
                    </Link>

                    <nav className="hidden items-center gap-0.5 lg:flex" aria-label="Primary">
                        {primaryNav.map((item) => (
                            <Link
                                key={item.url}
                                href={item.url}
                                className={cn(
                                    'rounded-pill px-3.5 py-2 text-[14.5px] font-medium transition-colors',
                                    currentUrl === item.url ? 'bg-white text-ink shadow-sm' : 'text-ink-soft hover:text-ink',
                                )}
                            >
                                {item.label}
                            </Link>
                        ))}
                        {moreNav.length > 0 && <DropdownMenu label="More" items={moreNav} />}
                    </nav>

                    <div className="flex items-center gap-2.5">
                        <StaggerButton
                            href="/book-a-call"
                            icon={CalendarHeart}
                            className="hidden !px-5 !py-2.5 text-[13.5px] sm:inline-flex"
                        >
                            {setting('hero_cta_label', 'Book a Discovery Call')}
                        </StaggerButton>
                        <button
                            type="button"
                            aria-label="Toggle menu"
                            aria-expanded={mobileOpen}
                            onClick={() => setMobileOpen(!mobileOpen)}
                            className="flex h-11 w-11 items-center justify-center rounded-full border border-hairline bg-white lg:hidden"
                        >
                            {mobileOpen ? <X className="h-5 w-5" /> : <Menu className="h-5 w-5" />}
                        </button>
                    </div>
                </div>

                {/* mobile menu */}
                <AnimatePresence>
                    {mobileOpen && (
                        <motion.nav
                            aria-label="Mobile"
                            initial={{ height: 0, opacity: 0 }}
                            animate={{ height: 'auto', opacity: 1 }}
                            exit={{ height: 0, opacity: 0 }}
                            transition={{ duration: 0.28, ease: [0.22, 1, 0.36, 1] }}
                            className="overflow-hidden border-t border-hairline-soft bg-cream lg:hidden"
                        >
                            <div className="container-site flex flex-col gap-1 py-4">
                                {nav.map((item, i) => (
                                    <motion.div
                                        key={item.url}
                                        initial={{ opacity: 0, x: -12 }}
                                        animate={{ opacity: 1, x: 0 }}
                                        transition={{ delay: i * 0.04 }}
                                    >
                                        <Link
                                            href={item.url}
                                            className={cn(
                                                'block rounded-md px-4 py-3 text-[16px] font-medium',
                                                currentUrl === item.url ? 'bg-white text-ink' : 'text-ink-soft',
                                            )}
                                        >
                                            {item.label}
                                        </Link>
                                    </motion.div>
                                ))}
                                <StaggerButton href="/book-a-call" icon={CalendarHeart} className="mt-3">
                                    {setting('hero_cta_label', 'Book a Discovery Call')}
                                </StaggerButton>
                            </div>
                        </motion.nav>
                    )}
                </AnimatePresence>
            </header>

            {/* spacer + brand-promise marquee (scrollxui: kinetic-testimonials) */}
            <div className="h-[72px]" />
            <KineticTestimonials items={marqueeItems} />

            <main>{children}</main>

            {/* ── FOOTER ──────────────────────────────────────────── */}
            <footer className="mt-20 border-t border-hairline-soft bg-white">
                <div className="container-site grid gap-10 py-14 md:grid-cols-[1.4fr_1fr_1fr_1fr]">
                    <div>
                        <Link href="/" className="inline-flex items-center">
                            <img src="/logo.png" alt={brand} className="h-20 w-auto" />
                        </Link>
                        <p className="mt-4 max-w-xs text-[15px] text-ink-soft">
                            {setting('footer_tagline', 'Managed virtual staffing for growing Australian businesses.')}
                        </p>

                        {socials.length > 0 && (
                            <div className="mt-6 flex items-center gap-3">
                                {socials.map(({ label, href, Icon }) => (
                                    <a
                                        key={label}
                                        href={href}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label={`${brand} on ${label}`}
                                        title={label}
                                        className="flex h-10 w-10 items-center justify-center rounded-full border border-hairline-soft text-ink-soft transition-colors hover:border-rose-deep hover:bg-rose-soft hover:text-rose-deep"
                                    >
                                        <Icon className="h-[18px] w-[18px]" />
                                    </a>
                                ))}
                            </div>
                        )}
                    </div>
                    <div>
                        <h4 className="t-caption mb-4 text-ink-soft">Navigate</h4>
                        <div className="flex flex-col gap-2.5">
                            {nav.map((item) => (
                                <Link key={item.url} href={item.url} className="text-[14.5px] text-ink-soft transition-colors hover:text-ink">
                                    {item.label}
                                </Link>
                            ))}
                        </div>
                    </div>
                    <div>
                        <h4 className="t-caption mb-4 text-ink-soft">Legal</h4>
                        <div className="flex flex-col gap-2.5 text-[14.5px] text-ink-soft">
                            <a href="#" className="transition-colors hover:text-ink">Privacy Policy</a>
                            <a href="#" className="transition-colors hover:text-ink">Terms of Service</a>
                            <a href="#" className="transition-colors hover:text-ink">Confidentiality Statement</a>
                        </div>
                    </div>
                    <div>
                        <h4 className="t-caption mb-4 text-ink-soft">Contact</h4>
                        <div className="flex flex-col gap-2.5 text-[14.5px] text-ink-soft">
                            <a href={`mailto:${setting('contact_email', 'hello@isla.com.au')}`} className="transition-colors hover:text-ink">
                                {setting('contact_email', 'hello@isla.com.au')}
                            </a>
                            <a
                                href={`tel:${String(setting('contact_phone', '+61 2 4093 0535')).replace(/[^0-9+]/g, '')}`}
                                className="transition-colors hover:text-ink"
                            >
                                {setting('contact_phone', '+61 2 4093 0535')}
                            </a>
                            <Link href="/book-a-call" className="transition-colors hover:text-ink">
                                {setting('hero_cta_label', 'Book a Discovery Call')}
                            </Link>
                            <Link href="/contact" className="transition-colors hover:text-ink">General enquiry</Link>
                        </div>
                    </div>
                </div>
                <div className="border-t border-hairline-soft py-5">
                    <div className="container-site">
                        <p className="text-[13px] text-ink-soft">
                            © {new Date().getFullYear()} {brand}. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>

            {/* scrollxui: expandable-dock — floating quick actions */}
            <ExpandableDock />
        </div>
    );
}
