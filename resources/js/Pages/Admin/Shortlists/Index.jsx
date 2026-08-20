import { Link, router } from '@inertiajs/react';
import { Trash2 } from 'lucide-react';
import AdminLayout from '@/Layouts/AdminLayout';
import LaravelPagination from '@/components/admin/LaravelPagination';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

export default function ShortlistsIndex({ shortlists }) {
    const rows = shortlists.data ?? [];

    const destroy = (s) => {
        if (!confirm(`Delete the shortlist from "${s.client_name}"? This can't be undone.`)) return;
        router.delete(`/admin/shortlists/${s.id}`);
    };

    return (
        <AdminLayout title="Shortlists" heading="Client shortlists">
            <p className="mb-5 max-w-2xl text-[14.5px] text-ink-soft">
                Candidate shortlists submitted from the private talent links you shared with clients.
            </p>

            {rows.length === 0 ? (
                <div className="rounded-lg border border-hairline-soft bg-white p-6 text-[14.5px] text-ink-soft">No shortlists yet.</div>
            ) : (
                <div className="overflow-x-auto rounded-lg border border-hairline-soft bg-white">
                    <Table>
                        <TableHeader>
                            <TableRow className="border-hairline-soft bg-cream/60 hover:bg-cream/60">
                                {['Client', 'Role', 'Picks', 'Received', ''].map((h, i) => (
                                    <TableHead key={i} className={`font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft ${i === 4 ? 'text-right' : ''}`}>{h || 'Actions'}</TableHead>
                                ))}
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {rows.map((s) => (
                                <TableRow key={s.id} className="border-hairline-soft">
                                    <TableCell className="whitespace-normal">
                                        <p className="font-bold text-ink">
                                            {s.client_name}
                                            {!s.is_read && <span className="ml-2 rounded-pill bg-rose-soft px-2 py-0.5 text-[10.5px] font-bold text-rose-deep">New</span>}
                                        </p>
                                        <p className="mt-0.5 text-[13px] text-ink-soft">{s.client_email}{s.client_company ? ` · ${s.client_company}` : ''}</p>
                                    </TableCell>
                                    <TableCell className="whitespace-normal text-[13.5px] text-ink-soft">
                                        {s.role}{s.subRole ? <span className="block text-[12.5px] text-ink-soft/70">{s.subRole}</span> : null}
                                    </TableCell>
                                    <TableCell className="text-[13.5px] text-ink-soft">{s.picks}</TableCell>
                                    <TableCell className="text-[13.5px] text-ink-soft">
                                        {new Date(s.created_at).toLocaleDateString('en-AU', { day: 'numeric', month: 'short', year: 'numeric' })}
                                    </TableCell>
                                    <TableCell className="text-right">
                                        <div className="flex justify-end gap-2">
                                            <Link href={`/admin/shortlists/${s.id}`} className="rounded-md border border-hairline px-3 py-1.5 text-[13px] font-semibold text-ink-soft transition-colors hover:border-ink/40 hover:text-ink">Open</Link>
                                            <button type="button" onClick={() => destroy(s)} className="inline-flex h-8 w-8 items-center justify-center rounded-md border border-hairline text-[#b23b3b] transition-colors hover:border-[#b23b3b]/40" title="Delete">
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
            <LaravelPagination links={shortlists.links ?? []} />
        </AdminLayout>
    );
}
