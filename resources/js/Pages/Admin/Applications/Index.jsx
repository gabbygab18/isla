import { Link, router } from '@inertiajs/react';
import { Trash2 } from 'lucide-react';
import AdminLayout from '@/Layouts/AdminLayout';
import LaravelPagination from '@/components/admin/LaravelPagination';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

export default function ApplicationsIndex({ applications }) {
    const rows = applications.data ?? [];

    const destroy = (a) => {
        if (!confirm(`Delete application from "${a.full_name}"? This can't be undone.`)) return;
        router.delete(`/admin/applications/${a.id}`);
    };

    return (
        <AdminLayout title="Careers" heading="Career applications">
            {rows.length === 0 ? (
                <div className="rounded-lg border border-hairline-soft bg-white p-6 text-[14.5px] text-ink-soft">No applications yet.</div>
            ) : (
                <div className="overflow-x-auto rounded-lg border border-hairline-soft bg-white">
                    <Table>
                        <TableHeader>
                            <TableRow className="border-hairline-soft bg-cream/60 hover:bg-cream/60">
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Name</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Role</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Email</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Received</TableHead>
                                <TableHead className="text-right font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {rows.map((a) => (
                                <TableRow key={a.id} className="border-hairline-soft">
                                    <TableCell className="whitespace-normal">
                                        <p className="font-bold text-ink">
                                            {a.full_name}
                                            {!a.is_read && <span className="ml-2 rounded-pill bg-rose-soft px-2 py-0.5 text-[10.5px] font-bold text-rose-deep">New</span>}
                                            {a.resume_path && <span className="ml-2 rounded-pill bg-sage-soft px-2 py-0.5 text-[10.5px] font-bold text-sage-deep">CV</span>}
                                        </p>
                                        <p className="mt-0.5 text-[13px] text-ink-soft">{a.phone}</p>
                                    </TableCell>
                                    <TableCell className="text-[13.5px] text-ink-soft">{a.role}</TableCell>
                                    <TableCell className="text-[13.5px] text-ink-soft">{a.email}</TableCell>
                                    <TableCell className="text-[13.5px] text-ink-soft">{new Date(a.created_at).toLocaleDateString('en-AU', { day: 'numeric', month: 'short', year: 'numeric' })}</TableCell>
                                    <TableCell className="text-right">
                                        <div className="flex justify-end gap-2">
                                            <Link href={`/admin/applications/${a.id}`} className="rounded-md border border-hairline px-3 py-1.5 text-[13px] font-semibold text-ink-soft transition-colors hover:border-ink/40 hover:text-ink">
                                                Open
                                            </Link>
                                            <button type="button" onClick={() => destroy(a)} className="inline-flex h-8 w-8 items-center justify-center rounded-md border border-hairline text-[#b23b3b] transition-colors hover:border-[#b23b3b]/40" title="Delete">
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
            <LaravelPagination links={applications.links ?? []} />
        </AdminLayout>
    );
}
