import { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import { Eye, Pencil, Plus, Trash2 } from 'lucide-react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

function StatusPill({ active }) {
    return (
        <span className={`rounded-pill px-2.5 py-1 text-[11px] font-bold ${active ? 'bg-sage-soft text-sage-deep' : 'bg-black/5 text-ink-soft'}`}>
            {active ? 'Active' : 'Hidden'}
        </span>
    );
}

export default function BlogsIndex({ blogs = [] }) {
    const [pendingDelete, setPendingDelete] = useState(null);

    const destroy = (blog) => {
        if (!confirm(`Delete "${blog.title}"? This can't be undone.`)) return;
        setPendingDelete(blog.id);
        router.delete(`/admin/blogs/${blog.slug}`, { preserveScroll: true, onFinish: () => setPendingDelete(null) });
    };

    return (
        <AdminLayout
            title="Blog"
            heading="Blog"
            actions={
                <Link href="/admin/blogs/create" className="inline-flex items-center gap-1.5 rounded-md bg-ink px-3.5 py-2 text-[13.5px] font-semibold text-cream transition-colors hover:bg-ink/90">
                    <Plus className="h-4 w-4" strokeWidth={2.4} />
                    New post
                </Link>
            }
        >
            <div className="mb-5"><h2 className="text-[22px] font-bold">Blog posts</h2></div>

            {blogs.length === 0 ? (
                <div className="rounded-lg border border-hairline-soft bg-white p-6 text-[14.5px] text-ink-soft">No blog posts yet.</div>
            ) : (
                <div className="overflow-x-auto rounded-lg border border-hairline-soft bg-white">
                    <Table>
                        <TableHeader>
                            <TableRow className="border-hairline-soft bg-cream/60 hover:bg-cream/60">
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Title</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Author</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Published</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Status</TableHead>
                                <TableHead className="text-right font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {blogs.map((b) => (
                                <TableRow key={b.id} className="border-hairline-soft">
                                    <TableCell className="whitespace-normal">
                                        <p className="font-bold text-ink">{b.title}</p>
                                        {b.excerpt && <p className="mt-0.5 max-w-md text-[13px] text-ink-soft">{b.excerpt.length > 80 ? `${b.excerpt.slice(0, 80)}…` : b.excerpt}</p>}
                                    </TableCell>
                                    <TableCell className="text-[13.5px] text-ink-soft">{b.author || '—'}</TableCell>
                                    <TableCell className="text-[13.5px] text-ink-soft">{b.published_at ? new Date(b.published_at).toLocaleDateString('en-AU', { day: 'numeric', month: 'short', year: 'numeric' }) : '—'}</TableCell>
                                    <TableCell><StatusPill active={b.is_active} /></TableCell>
                                    <TableCell className="text-right">
                                        <div className="flex justify-end gap-2">
                                            <a href={`/blog/${b.slug}`} target="_blank" rel="noopener" className="inline-flex h-8 w-8 items-center justify-center rounded-md border border-hairline text-ink-soft transition-colors hover:border-ink/40 hover:text-ink" title="View on site">
                                                <Eye className="h-4 w-4" />
                                            </a>
                                            <Link href={`/admin/blogs/${b.slug}/edit`} className="inline-flex h-8 w-8 items-center justify-center rounded-md border border-hairline text-ink-soft transition-colors hover:border-ink/40 hover:text-ink" title="Edit">
                                                <Pencil className="h-4 w-4" />
                                            </Link>
                                            <button type="button" onClick={() => destroy(b)} disabled={pendingDelete === b.id} className="inline-flex h-8 w-8 items-center justify-center rounded-md border border-hairline text-[#b23b3b] transition-colors hover:border-[#b23b3b]/40 disabled:opacity-50" title="Delete">
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
