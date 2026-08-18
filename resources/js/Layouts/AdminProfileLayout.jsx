import { Head, Link } from '@inertiajs/react';
import { ArrowLeft, LayoutGrid } from 'lucide-react';
import ButterflyBackdrop from '@/components/site/ButterflyBackdrop';

/**
 * Standalone shell for the admin-only staff-profile pages. Deliberately not
 * SiteLayout — no public nav/footer — but reuses the same brand tokens,
 * fonts and motion primitives as the public site (loaded globally via
 * app.blade.php / app.css) so the two feel like one system.
 */
export default function AdminProfileLayout({ title, children }) {
    return (
        <div className="isolate min-h-screen bg-cream text-ink">
            <ButterflyBackdrop />
            <Head>
                <title>{title ? `${title} — Isla Staff Profiles` : 'Isla Staff Profiles'}</title>
            </Head>

            <header className="sticky top-0 z-50 border-b border-hairline-soft bg-cream/90 backdrop-blur-md">
                <div className="container-site flex h-[64px] items-center justify-between gap-4">
                    <Link href="/admin/staff-profiles" className="flex items-center gap-2.5">
                        <img src="/logo.png" alt="Isla" className="h-9 w-auto" />
                        <span className="t-caption hidden text-ink-soft sm:inline">Staff Profiles</span>
                    </Link>
                    <nav className="flex items-center gap-2.5">
                        <Link
                            href="/admin/staff-profiles"
                            className="inline-flex items-center gap-2 rounded-pill border border-hairline px-4 py-2 text-[13.5px] font-semibold text-ink-soft transition-colors hover:border-ink/40 hover:text-ink"
                        >
                            <LayoutGrid className="h-4 w-4" strokeWidth={2.2} />
                            All profiles
                        </Link>
                        <Link
                            href="/admin"
                            className="inline-flex items-center gap-2 rounded-pill bg-ink px-4 py-2 text-[13.5px] font-semibold text-cream transition-colors hover:bg-ink/90"
                        >
                            <ArrowLeft className="h-4 w-4" strokeWidth={2.2} />
                            Admin
                        </Link>
                    </nav>
                </div>
            </header>

            <main>{children}</main>

            <footer className="border-t border-hairline-soft py-6">
                <div className="container-site">
                    <p className="text-[12.5px] text-ink-soft">
                        Internal talent bench — visible to signed-in Isla admins only. Not indexed, not linked from the public site.
                    </p>
                </div>
            </footer>
        </div>
    );
}
