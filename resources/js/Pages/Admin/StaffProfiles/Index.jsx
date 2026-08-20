import { useEffect, useMemo, useState } from 'react';
import { Link, router } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, Pencil, Plus, Trash2, Upload } from 'lucide-react';
import AdminProfileLayout from '@/Layouts/AdminProfileLayout';
import RevealText from '@/components/scrollxui/RevealText';
import SpotlightCard from '@/components/scrollxui/SpotlightCard';
import ProfileCard from '@/components/ui/profilecard';
import {
    Pagination,
    PaginationContent,
    PaginationItem,
    PaginationLink,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';

const PAGE_SIZE = 9;

const CATEGORY_STYLE = {
    Construction: 'bg-sage-soft text-sage-deep',
    Marketing: 'bg-rose-soft text-rose-deep',
    NDIS: 'bg-ink/10 text-ink',
};

function CategoryPill({ category }) {
    return (
        <span className={`rounded-pill px-3 py-1 text-[11.5px] font-bold uppercase tracking-wide ${CATEGORY_STYLE[category] || 'bg-ink/10 text-ink'}`}>
            {category || 'General'}
        </span>
    );
}

function HiddenPill() {
    return (
        <span className="rounded-pill bg-black/5 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-ink-soft">Hidden</span>
    );
}

// Shared by both card variants — a profile with a photo gets the ProfileCard,
// one without falls back to the plain content card, but the admin actions are
// identical either way.
function CardActions({ profile, onDelete, pendingDelete }) {
    const iconButton = 'inline-flex h-8 w-8 items-center justify-center rounded-md border border-hairline bg-white transition-colors';

    return (
        <div className="flex items-center gap-1.5">
            <Link href={`/admin/staff-profiles/${profile.slug}`} className={`${iconButton} text-ink-soft hover:border-ink/40 hover:text-ink`} title="View">
                <ArrowRight className="h-3.5 w-3.5" strokeWidth={2.4} />
            </Link>
            <Link href={`/admin/staff-profiles/${profile.slug}/edit`} className={`${iconButton} text-ink-soft hover:border-ink/40 hover:text-ink`} title="Edit">
                <Pencil className="h-3.5 w-3.5" />
            </Link>
            <button
                type="button"
                onClick={() => onDelete(profile)}
                disabled={pendingDelete === profile.id}
                className={`${iconButton} text-[#b23b3b] hover:border-[#b23b3b]/40 disabled:opacity-50`}
                title="Delete"
            >
                <Trash2 className="h-3.5 w-3.5" />
            </button>
        </div>
    );
}

export default function StaffProfilesIndex({ profiles = [] }) {
    const [filter, setFilter] = useState('All');
    const [page, setPage] = useState(1);
    const [pendingDelete, setPendingDelete] = useState(null);

    const categories = useMemo(() => ['All', ...new Set(profiles.map((p) => p.category).filter(Boolean))], [profiles]);
    const filtered = filter === 'All' ? profiles : profiles.filter((p) => p.category === filter);

    const pageCount = Math.max(1, Math.ceil(filtered.length / PAGE_SIZE));
    const paged = filtered.slice((page - 1) * PAGE_SIZE, page * PAGE_SIZE);

    useEffect(() => setPage(1), [filter]);

    const destroy = (profile) => {
        if (!confirm(`Delete "${profile.name}"? This can't be undone.`)) return;
        setPendingDelete(profile.id);
        router.delete(`/admin/staff-profiles/${profile.slug}`, { preserveScroll: true, onFinish: () => setPendingDelete(null) });
    };

    return (
        <AdminProfileLayout title="Staff Profiles">
            <section className="pb-4 pt-14 md:pt-20">
                <div className="container-site">
                    <div className="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p className="t-eyebrow mb-3 text-rose-deep">Internal · Admin only</p>
                            <RevealText text="Isla Talent Bench" as="h1" className="t-display-lg max-w-3xl" />
                            <p className="t-body-lg mt-5 max-w-2xl text-ink-soft">
                                {profiles.length} profile{profiles.length === 1 ? '' : 's'} ready to match against client roles — construction estimating, marketing, and NDIS administration.
                            </p>
                        </div>
                        <div className="flex shrink-0 gap-2.5">
                            <Link
                                href="/admin/staff-profiles/import"
                                className="inline-flex items-center gap-2 rounded-pill border border-hairline bg-white px-4 py-2.5 text-[13.5px] font-semibold text-ink transition-colors hover:border-ink/40"
                            >
                                <Upload className="h-4 w-4" strokeWidth={2.2} />
                                Import CSV
                            </Link>
                            <Link
                                href="/admin/staff-profiles/create"
                                className="inline-flex items-center gap-2 rounded-pill bg-ink px-4 py-2.5 text-[13.5px] font-semibold text-cream transition-colors hover:bg-ink/90"
                            >
                                <Plus className="h-4 w-4" strokeWidth={2.4} />
                                New profile
                            </Link>
                        </div>
                    </div>
                </div>
            </section>

            <section className="pb-6 pt-2">
                <div className="container-site flex flex-wrap gap-2">
                    {categories.map((cat) => (
                        <button
                            key={cat}
                            type="button"
                            onClick={() => setFilter(cat)}
                            className={`rounded-pill border px-4 py-2 text-[13.5px] font-semibold transition-colors ${
                                filter === cat ? 'border-ink bg-ink text-cream' : 'border-hairline bg-white text-ink-soft hover:border-ink/40'
                            }`}
                        >
                            {cat}
                        </button>
                    ))}
                </div>
            </section>

            <section className="pb-20 pt-2">
                <div className="container-site">
                    {paged.length > 0 ? (
                        <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            {paged.map((profile, i) => (
                                <motion.div
                                    key={profile.id}
                                    initial={{ opacity: 0, y: 22 }}
                                    whileInView={{ opacity: 1, y: 0 }}
                                    viewport={{ once: true, margin: '-6% 0px' }}
                                    transition={{ duration: 0.5, delay: (i % 6) * 0.06, ease: [0.22, 1, 0.36, 1] }}
                                >
                                    {profile.photo_display_url ? (
                                        <div className="flex h-full flex-col items-center gap-3">
                                            <ProfileCard
                                                img={profile.photo_display_url}
                                                name={profile.name}
                                                position={profile.role_title}
                                                bio={profile.about_me
                                                    ? (profile.about_me.length > 150 ? `${profile.about_me.slice(0, 150).trim()}…` : profile.about_me)
                                                    : ''}
                                                spotlight
                                            />
                                            <div className="flex w-[17rem] items-center justify-between gap-2">
                                                <div className="flex flex-wrap items-center gap-1.5">
                                                    <CategoryPill category={profile.category} />
                                                    {!profile.is_active && <HiddenPill />}
                                                </div>
                                                <CardActions profile={profile} onDelete={destroy} pendingDelete={pendingDelete} />
                                            </div>
                                        </div>
                                    ) : (
                                        <SpotlightCard className="flex h-full flex-col">
                                            <Link href={`/admin/staff-profiles/${profile.slug}`} className="mb-5 flex items-center gap-3.5">
                                                <span className="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full border border-rose-deep/30 bg-gradient-to-br from-rose-soft to-rose-deep/40">
                                                    <img src="/butterfly.png" alt="" className="h-6 w-6 opacity-80" />
                                                </span>
                                                <div>
                                                    <h3 className="t-card-title leading-tight">{profile.name}</h3>
                                                    <p className="mt-0.5 text-[13px] font-medium text-ink-soft">{profile.role_title}</p>
                                                </div>
                                            </Link>
                                            <div className="flex flex-wrap items-center gap-2">
                                                <CategoryPill category={profile.category} />
                                                {!profile.is_active && <HiddenPill />}
                                            </div>
                                            {profile.about_me && (
                                                <p className="mt-4 flex-1 text-[14.5px] leading-relaxed text-ink-soft">
                                                    {profile.about_me.length > 140 ? `${profile.about_me.slice(0, 140).trim()}…` : profile.about_me}
                                                </p>
                                            )}
                                            <div className="mt-5 flex items-center justify-between border-t border-hairline-soft pt-4">
                                                <div className="text-[12.5px] text-ink-soft">
                                                    {profile.rate && <span className="font-bold text-ink">{profile.rate}</span>}
                                                    {profile.availability && <span> · {profile.availability}</span>}
                                                </div>
                                                <CardActions profile={profile} onDelete={destroy} pendingDelete={pendingDelete} />
                                            </div>
                                        </SpotlightCard>
                                    )}
                                </motion.div>
                            ))}
                        </div>
                    ) : (
                        <p className="py-10 text-center text-[15px] text-ink-soft">No profiles in this category yet.</p>
                    )}

                    {pageCount > 1 && (
                        <Pagination className="mt-12">
                            <PaginationContent>
                                <PaginationItem>
                                    <PaginationPrevious
                                        href="#"
                                        onClick={(e) => { e.preventDefault(); setPage((p) => Math.max(1, p - 1)); }}
                                        aria-disabled={page === 1}
                                        className={page === 1 ? 'pointer-events-none opacity-40' : ''}
                                    />
                                </PaginationItem>
                                {Array.from({ length: pageCount }, (_, i) => i + 1).map((n) => (
                                    <PaginationItem key={n}>
                                        <PaginationLink
                                            href="#"
                                            isActive={n === page}
                                            onClick={(e) => { e.preventDefault(); setPage(n); }}
                                        >
                                            {n}
                                        </PaginationLink>
                                    </PaginationItem>
                                ))}
                                <PaginationItem>
                                    <PaginationNext
                                        href="#"
                                        onClick={(e) => { e.preventDefault(); setPage((p) => Math.min(pageCount, p + 1)); }}
                                        aria-disabled={page === pageCount}
                                        className={page === pageCount ? 'pointer-events-none opacity-40' : ''}
                                    />
                                </PaginationItem>
                            </PaginationContent>
                        </Pagination>
                    )}
                </div>
            </section>
        </AdminProfileLayout>
    );
}
