import { Link, router } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

function Detail({ label, children }) {
    return (
        <div>
            <p className="font-mono text-[11px] uppercase tracking-[0.05em] text-ink-soft">{label}</p>
            <div className="mt-1 text-[14.5px] text-ink">{children}</div>
        </div>
    );
}

export default function ApplicationShow({ application: a }) {
    const destroy = () => {
        if (!confirm('Delete this application?')) return;
        router.delete(`/admin/applications/${a.id}`);
    };

    return (
        <AdminLayout title="Application" heading="Career application">
            <div className="mb-5 flex items-center justify-between">
                <h2 className="text-[22px] font-bold">{a.full_name}</h2>
                <Link href="/admin/applications" className="rounded-md border border-hairline px-3.5 py-2 text-[13.5px] font-semibold text-ink transition-colors hover:bg-cream">← Back</Link>
            </div>

            <div className="rounded-lg border border-hairline-soft bg-white p-6 md:p-7">
                <div className="grid gap-5">
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Detail label="Role applied for">{a.role}</Detail>
                        <Detail label="Availability">{a.availability || '—'}</Detail>
                    </div>
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Detail label="Email"><a href={`mailto:${a.email}`} className="font-semibold text-rose-deep">{a.email}</a></Detail>
                        <Detail label="Phone">{a.phone}</Detail>
                    </div>
                    {a.portfolio_url && (
                        <Detail label="Portfolio / LinkedIn link">
                            <a href={a.portfolio_url} target="_blank" rel="noopener" className="font-semibold text-rose-deep">{a.portfolio_url}</a>
                        </Detail>
                    )}
                    {a.resume_path && (
                        <Detail label="Resume / CV">
                            <a href={a.resume_url} target="_blank" rel="noopener" className="inline-block rounded-md border border-hairline px-3.5 py-2 text-[13.5px] font-semibold text-ink transition-colors hover:bg-cream">
                                Download resume
                            </a>
                        </Detail>
                    )}
                    <Detail label="About the applicant">
                        <p className="whitespace-pre-wrap leading-relaxed">{a.message}</p>
                    </Detail>
                    <p className="text-[13.5px] text-ink-soft">
                        Received {new Date(a.created_at).toLocaleDateString('en-AU', { day: 'numeric', month: 'short', year: 'numeric', hour: 'numeric', minute: '2-digit' })}
                    </p>
                </div>

                <div className="mt-6 flex gap-3">
                    <a href={`mailto:${a.email}`} className="rounded-md bg-ink px-5 py-2.5 text-[14px] font-semibold text-cream transition-colors hover:bg-ink/90">
                        Reply by email
                    </a>
                    <button type="button" onClick={destroy} className="rounded-md border border-[#b23b3b]/30 px-5 py-2.5 text-[14px] font-semibold text-[#b23b3b] transition-colors hover:bg-[#fbeaea]">
                        Delete
                    </button>
                </div>
            </div>
        </AdminLayout>
    );
}
