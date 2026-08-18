import { useEffect, useState } from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { LayoutGrid, Menu, X } from 'lucide-react';
import { cn } from '@/lib/utils';

/**
 * React/Inertia layout shared by every admin page — the whole admin panel
 * has been migrated off Blade, so all internal navigation here uses
 * Inertia's <Link> for SPA transitions instead of full page reloads.
 * Only the "View site ↗" link (opens the public site in a new tab) and the
 * logout form (needs a real POST) stay as plain HTML.
 */
const NAV = [
    { group: null, items: [{ label: 'Dashboard', href: '/admin', icon: 'dashboard' }] },
    {
        group: 'Content',
        items: [
            { label: 'Who we work with', href: '/admin/audiences', icon: 'audiences', match: '/admin/audiences' },
            { label: 'Services', href: '/admin/services', icon: 'services' },
            { label: 'How it Works', href: '/admin/process-steps', icon: 'process' },
            { label: 'Why Isla', href: '/admin/benefits', icon: 'benefits' },
            { label: 'Pricing', href: '/admin/pricing-plans', icon: 'pricing' },
            { label: 'FAQ', href: '/admin/faqs', icon: 'faq' },
            { label: 'Testimonials', href: '/admin/testimonials', icon: 'testimonials' },
            { label: 'Blog', href: '/admin/blogs', icon: 'blog' },
        ],
    },
    {
        group: 'Talent',
        items: [{ label: 'Staff Profiles', href: '/admin/staff-profiles', icon: 'staff' }],
    },
    {
        group: 'Site',
        items: [
            { label: 'Navigation Menu', href: '/admin/nav-items', icon: 'nav' },
            { label: 'Settings', href: '/admin/settings', icon: 'settings' },
            { label: 'Messages', href: '/admin/messages', icon: 'messages' },
            { label: 'Careers', href: '/admin/applications', icon: 'careers' },
        ],
    },
];

const ICONS = {
    dashboard: <><rect width="7" height="9" x="3" y="3" rx="1" /><rect width="7" height="5" x="14" y="3" rx="1" /><rect width="7" height="9" x="14" y="12" rx="1" /><rect width="7" height="5" x="3" y="16" rx="1" /></>,
    audiences: <><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /></>,
    services: <><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" /><rect width="20" height="14" x="2" y="6" rx="2" /></>,
    process: <><line x1="10" x2="21" y1="6" y2="6" /><line x1="10" x2="21" y1="12" y2="12" /><line x1="10" x2="21" y1="18" y2="18" /><path d="M4 6h1v4" /><path d="M4 10h2" /><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1" /></>,
    benefits: <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z" />,
    pricing: <><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z" /><circle cx="7.5" cy="7.5" r=".5" fill="currentColor" /></>,
    faq: <><circle cx="12" cy="12" r="10" /><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" /><path d="M12 17h.01" /></>,
    testimonials: <><path d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z" /><path d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z" /></>,
    blog: <><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" /><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" /><line x1="9" x2="15" y1="7" y2="7" /><line x1="9" x2="13" y1="11" y2="11" /></>,
    staff: <><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="m16 3.13 1.42.4a5 5 0 0 1 0 9.66l-1.42.39" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /></>,
    nav: <><line x1="4" x2="20" y1="6" y2="6" /><line x1="4" x2="20" y1="12" y2="12" /><line x1="4" x2="20" y1="18" y2="18" /></>,
    settings: <><line x1="21" x2="14" y1="4" y2="4" /><line x1="10" x2="3" y1="4" y2="4" /><line x1="21" x2="12" y1="12" y2="12" /><line x1="8" x2="3" y1="12" y2="12" /><line x1="21" x2="16" y1="20" y2="20" /><line x1="12" x2="3" y1="20" y2="20" /><line x1="14" x2="14" y1="2" y2="6" /><line x1="8" x2="8" y1="10" y2="14" /><line x1="16" x2="16" y1="18" y2="22" /></>,
    messages: <><rect width="20" height="16" x="2" y="4" rx="2" /><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" /></>,
    careers: <><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><line x1="19" x2="19" y1="8" y2="14" /><line x1="22" x2="16" y1="11" y2="11" /></>,
};

function NavIcon({ name }) {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true" className="h-4 w-4 shrink-0">
            {ICONS[name]}
        </svg>
    );
}

export default function AdminLayout({ title, heading, actions, children }) {
    const { url, props } = usePage();
    const flashSuccess = props?.flash?.success;
    const [mobileOpen, setMobileOpen] = useState(false);

    useEffect(() => setMobileOpen(false), [url]);

    return (
        <div className="min-h-screen bg-cream text-ink" style={{ fontFamily: 'var(--font, Geist, system-ui, sans-serif)' }}>
            <Head><title>{title ? `${title} — Isla Admin` : 'Isla Admin'}</title></Head>

            <div className="grid min-h-screen lg:grid-cols-[250px_1fr]">
                <aside className={cn(
                    'admin-sidebar-scroll z-50 flex flex-col gap-1 overflow-y-auto bg-ink px-4 py-5 text-cream lg:sticky lg:top-0 lg:h-screen',
                    'fixed inset-y-0 left-0 w-[250px] -translate-x-full transition-transform duration-300 lg:translate-x-0',
                    mobileOpen && 'translate-x-0',
                )}>
                    <Link href="/admin" className="mb-3 flex items-center gap-2.5 border-b border-cream/10 px-2 pb-4">
                        <img src="/logo.png" alt="Isla Admin" className="h-9 w-auto" />
                    </Link>

                    {NAV.map((section, si) => (
                        <div key={si}>
                            {section.group && (
                                <p className="mb-2 mt-4 px-2 font-mono text-[10px] uppercase tracking-[0.12em] text-cream/40">{section.group}</p>
                            )}
                            {section.items.map((item) => {
                                const active = item.match ? url.startsWith(item.match) : url === item.href;
                                return (
                                    <Link
                                        key={item.href}
                                        href={item.href}
                                        className={cn(
                                            'flex items-center gap-2.5 rounded-md px-3 py-2 text-[14px] font-medium transition-colors',
                                            active ? 'bg-rose-deep text-white' : 'text-cream/80 hover:bg-white/5 hover:text-white',
                                        )}
                                    >
                                        <NavIcon name={item.icon} />
                                        {item.label}
                                    </Link>
                                );
                            })}
                        </div>
                    ))}
                </aside>

                {mobileOpen && (
                    <div className="fixed inset-0 z-40 bg-ink/40 lg:hidden" onClick={() => setMobileOpen(false)} />
                )}

                <div className="flex min-w-0 flex-col">
                    <div className="sticky top-0 z-30 flex items-center justify-between gap-4 border-b border-hairline bg-white px-5 py-3.5 lg:px-7">
                        <div className="flex items-center gap-3">
                            <button
                                type="button"
                                onClick={() => setMobileOpen(true)}
                                className="flex h-9 w-9 items-center justify-center rounded-md border border-hairline lg:hidden"
                                aria-label="Open menu"
                            >
                                <Menu className="h-4 w-4" />
                            </button>
                            <h1 className="text-[19px] font-bold">{heading || title}</h1>
                        </div>
                        <div className="flex items-center gap-2.5">
                            {actions}
                            <a href="/" target="_blank" rel="noopener" className="rounded-md border border-hairline px-3.5 py-2 text-[13.5px] font-semibold text-ink transition-colors hover:bg-cream">
                                View site ↗
                            </a>
                            <form method="POST" action="/admin/logout">
                                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                                <button type="submit" className="rounded-md border border-hairline px-3.5 py-2 text-[13.5px] font-semibold text-ink transition-colors hover:bg-cream">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>

                    <div className="mx-auto w-full max-w-[1100px] flex-1 p-5 lg:p-7">
                        <AnimatePresence>
                            {flashSuccess && (
                                <motion.div
                                    initial={{ opacity: 0, y: -8 }}
                                    animate={{ opacity: 1, y: 0 }}
                                    exit={{ opacity: 0, y: -8 }}
                                    className="mb-5 rounded-md bg-sage-soft px-4 py-3 text-[14px] font-semibold text-sage-deep"
                                >
                                    {flashSuccess}
                                </motion.div>
                            )}
                        </AnimatePresence>
                        {children}
                    </div>
                </div>
            </div>
        </div>
    );
}
