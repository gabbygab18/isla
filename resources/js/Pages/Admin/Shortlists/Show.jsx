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

export default function ShortlistShow({ shortlist, candidates = [] }) {
    const destroy = () => {
        if (!confirm('Delete this shortlist?')) return;
        router.delete(`/admin/shortlists/${shortlist.id}`);
    };

    return (
        <AdminLayout title="Shortlist" heading="Client shortlist">
            <div className="mb-5 flex items-center justify-between">
                <h2 className="text-[22px] font-bold">{shortlist.client_name}</h2>
                <Link href="/admin/shortlists" className="rounded-md border border-hairline px-3.5 py-2 text-[13.5px] font-semibold text-ink transition-colors hover:bg-cream">← Back</Link>
            </div>

            <div className="rounded-lg border border-hairline-soft bg-white p-6 md:p-7">
                <div className="grid gap-5">
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Detail label="Email"><a href={`mailto:${shortlist.client_email}`} className="font-semibold text-rose-deep">{shortlist.client_email}</a></Detail>
                        <Detail label="Business">{shortlist.client_company || '—'}</Detail>
                    </div>
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Detail label="Industry">{shortlist.role || '—'}</Detail>
                        <Detail label="Role">{shortlist.subRole || '—'}</Detail>
                    </div>
                    {shortlist.interview_schedule?.length > 0 ? (
                        <Detail label="Requested interviews">
                            <div className="mt-1 flex flex-col gap-2">
                                {shortlist.interview_schedule.map((slot, i) => {
                                    const who = candidates.find((c) => c.id === slot.profile_id);
                                    return (
                                        <div key={i} className="rounded-md border border-hairline-soft bg-cream/40 p-3">
                                            <p className="text-[14px] font-bold">{i + 1}. {who?.name || 'Candidate'}</p>
                                            <p className="mt-0.5 text-[13.5px] text-ink-soft">
                                                <span className="font-semibold text-ink">{slot.date || '—'}</span>
                                                {slot.times && <span> · {slot.times}</span>}
                                            </p>
                                            {slot.note && <p className="mt-1 text-[13px] italic text-ink-soft">“{slot.note}”</p>}
                                        </div>
                                    );
                                })}
                            </div>
                        </Detail>
                    ) : (
                        <div className="grid gap-5 sm:grid-cols-2">
                            <Detail label="Interview date">{shortlist.interview_date || '—'}</Detail>
                            <Detail label="Time availability">{shortlist.interview_time_availability || '—'}</Detail>
                        </div>
                    )}
                    {shortlist.notes && (
                        <Detail label="Notes from client">
                            <p className="whitespace-pre-wrap leading-relaxed">{shortlist.notes}</p>
                        </Detail>
                    )}
                    <p className="text-[13.5px] text-ink-soft">
                        Received {new Date(shortlist.created_at).toLocaleDateString('en-AU', { day: 'numeric', month: 'short', year: 'numeric', hour: 'numeric', minute: '2-digit' })}
                    </p>
                </div>

                <div className="mt-7 border-t border-hairline-soft pt-6">
                    <h3 className="t-caption mb-4 text-ink-soft">Ranked candidates</h3>
                    <div className="flex flex-col gap-3">
                        {candidates.map((c, i) => (
                            <div key={c.id} className="flex flex-wrap items-center gap-3.5 rounded-lg border border-hairline-soft bg-cream/40 p-3.5">
                                <span className="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-ink text-[12px] font-bold text-cream">{i + 1}</span>
                                <span className="h-11 w-11 shrink-0 overflow-hidden rounded-full border border-rose-deep/25 bg-gradient-to-br from-rose-soft to-rose-deep/30">
                                    {c.photo_display_url
                                        ? <img src={c.photo_display_url} alt={c.name} className="h-full w-full object-cover" />
                                        : <span className="flex h-full w-full items-center justify-center"><img src="/butterfly.png" alt="" className="h-5 w-5 opacity-70" /></span>}
                                </span>
                                <span className="min-w-0 flex-1">
                                    <span className="block text-[15px] font-bold">{c.name}</span>
                                    <span className="block text-[13px] text-ink-soft">{c.role_title}</span>
                                </span>
                                <span className="text-[13px] text-ink-soft">
                                    {c.rate && <span className="font-bold text-ink">{c.rate}</span>}
                                    {c.availability && <span> · {c.availability}</span>}
                                </span>
                                <Link href={`/admin/staff-profiles/${c.slug}`} className="rounded-md border border-hairline bg-white px-3 py-1.5 text-[12.5px] font-semibold text-ink-soft transition-colors hover:border-ink/40 hover:text-ink">
                                    Profile
                                </Link>
                            </div>
                        ))}
                    </div>
                </div>

                <div className="mt-6 flex gap-3">
                    <a href={`mailto:${shortlist.client_email}`} className="rounded-md bg-ink px-5 py-2.5 text-[14px] font-semibold text-cream transition-colors hover:bg-ink/90">Reply by email</a>
                    <button type="button" onClick={destroy} className="rounded-md border border-[#b23b3b]/30 px-5 py-2.5 text-[14px] font-semibold text-[#b23b3b] transition-colors hover:bg-[#fbeaea]">Delete</button>
                </div>
            </div>
        </AdminLayout>
    );
}
