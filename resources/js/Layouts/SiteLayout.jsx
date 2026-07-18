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

const FALLBACK_NAV = [
    { label: 'About Us', url: '/about' },
    { label: 'Team We Build', url: '/team-we-build' },
    { label: 'Industries', url: '/who-we-work-with' },
    { label: 'How it Works', url: '/how-it-works' },
    { label: 'Cost Estimator', url: '/cost-estimator' },
    { label: 'Pricing', url: '/pricing' },
    { label: 'FAQ', url: '/faq' },
    { label: 'Contact', url: '/contact' },
];

export default function SiteLayout({ title, description, children }) {
    const { settings, navItems, url } = usePage().props ?? {};
    const currentUrl = usePage().url;
    const setting = makeSetting(settings);

    const brand = setting('brand_word', 'Isla');
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
            'NDIS-aware onboarding\nFlat management fee\nLifetime replacement guarantee\nAU business-hours overlap',
        ),
    )
        .split(/\r\n|\r|\n/)
        .map((s) => s.trim())
        .filter(Boolean);

    return (
        <div className="isolate min-h-screen bg-cream text-ink">
            <ButterflyBackdrop />
            <Head>
                <title>{title ? `${title} — ${brand}` : `${brand} — Managed Virtual Staffing for Growing Australian Businesses`}</title>
                {description && <meta name="description" content={description} />}
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
                        <img src="/logo.png" alt={brand} className="h-10 w-auto" />
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
                                href={`tel:${String(setting('contact_phone', '+61 00 0000 0000')).replace(/[^0-9+]/g, '')}`}
                                className="transition-colors hover:text-ink"
                            >
                                {setting('contact_phone', '+61 00 0000 0000')}
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
