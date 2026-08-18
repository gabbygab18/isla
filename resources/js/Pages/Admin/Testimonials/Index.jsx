import { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import { Pencil, Plus, Trash2 } from 'lucide-react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

function StatusPill({ active }) {
    return (
        <span className={`rounded-pill px-2.5 py-1 text-[11px] font-bold ${active ? 'bg-sage-soft text-sage-deep' : 'bg-black/5 text-ink-soft'}`}>
            {active ? 'Active' : 'Hidden'}
        </span>
    );
}

export default function TestimonialsIndex({ testimonials = [] }) {
    const [pendingDelete, setPendingDelete] = useState(null);

    const destroy = (t) => {
        if (!confirm(`Delete testimonial from "${t.author}"? This can't be undone.`)) return;
        setPendingDelete(t.id);
        router.delete(`/admin/testimonials/${t.id}`, { preserveScroll: true, onFinish: () => setPendingDelete(null) });
    };

    return (
        <AdminLayout
            title="Testimonials"
            heading="Testimonials"
            actions={
                <Link href="/admin/testimonials/create" className="inline-flex items-center gap-1.5 rounded-md bg-ink px-3.5 py-2 text-[13.5px] font-semibold text-cream transition-colors hover:bg-ink/90">
                    <Plus className="h-4 w-4" strokeWidth={2.4} />
                    New testimonial
                </Link>
            }
        >
            <div className="mb-5"><h2 className="text-[22px] font-bold">Testimonials</h2></div>

            {testimonials.length === 0 ? (
                <div className="rounded-lg border border-hairline-soft bg-white p-6 text-[14.5px] text-ink-soft">No testimonials yet.</div>
            ) : (
                <div className="overflow-x-auto rounded-lg border border-hairline-soft bg-white">
                    <Table>
                        <TableHeader>
                            <TableRow className="border-hairline-soft bg-cream/60 hover:bg-cream/60">
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">#</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Author</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Quote</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Status</TableHead>
                                <TableHead className="text-right font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {testimonials.map((t, i) => (
                                <TableRow key={t.id} className="border-hairline-soft">
                                    <TableCell className="text-[13.5px] text-ink-soft/70">{i + 1}</TableCell>
                                    <TableCell className="whitespace-normal">
                                        <p className="font-bold text-ink">{t.author}</p>
                                        {t.role && <p className="mt-0.5 text-[13px] text-ink-soft">{t.role}</p>}
                                    </TableCell>
                                    <TableCell className="max-w-md whitespace-normal text-[13px] text-ink-soft">
                                        {t.quote.length > 100 ? `${t.quote.slice(0, 100)}…` : t.quote}
                                    </TableCell>
                                    <TableCell><StatusPill active={t.is_active} /></TableCell>
                                    <TableCell className="text-right">
                                        <div className="flex justify-end gap-2">
                                            <Link href={`/admin/testimonials/${t.id}/edit`} className="inline-flex h-8 w-8 items-center justify-center rounded-md border border-hairline text-ink-soft transition-colors hover:border-ink/40 hover:text-ink" title="Edit">
                                                <Pencil className="h-4 w-4" />
                                            </Link>
                                            <button type="button" onClick={() => destroy(t)} disabled={pendingDelete === t.id} className="inline-flex h-8 w-8 items-center justify-center rounded-md border border-hairline text-[#b23b3b] transition-colors hover:border-[#b23b3b]/40 disabled:opacity-50" title="Delete">
                                                <Trash2 className="h-4 w-4" />
                                            </button>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            )}
        </AdminLayout>
    );
}
