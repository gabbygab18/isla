import { Link, useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

function Field({ label, htmlFor, error, children }) {
    return (
        <div className="grid content-start gap-1.5">
            <label htmlFor={htmlFor} className="font-mono text-[11px] font-medium uppercase tracking-[0.05em] text-ink-soft">{label}</label>
            {children}
            {error && <span className="text-[12.5px] text-[#b23b3b]">{error}</span>}
        </div>
    );
}

const inputClass = 'w-full rounded-md border border-hairline bg-white px-3 py-2.5 text-[14px] text-ink outline-none transition-colors focus:border-ink/40';

export default function BenefitForm({ benefit }) {
    const isEdit = !!benefit;

    const form = useForm({
        title: benefit?.title ?? '',
        summary: benefit?.summary ?? '',
        sort_order: benefit?.sort_order ?? 0,
        is_active: benefit?.is_active ?? true,
    });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) form.put(`/admin/benefits/${benefit.id}`);
        else form.post('/admin/benefits');
    };

    return (
        <AdminLayout title={isEdit ? 'Edit Benefit' : 'New Benefit'} heading={isEdit ? 'Edit Benefit' : 'New Benefit'}>
            <div className="rounded-lg border border-hairline-soft bg-white p-6 md:p-7">
                <form onSubmit={submit} className="grid max-w-2xl gap-5">
                    <Field label="Title" htmlFor="title" error={form.errors.title}>
                        <input id="title" className={inputClass} value={form.data.title} onChange={(e) => form.setData('title', e.target.value)} required />
                    </Field>
                    <Field label="Summary" htmlFor="summary">
                        <textarea id="summary" rows={3} className={inputClass} value={form.data.summary} onChange={(e) => form.setData('summary', e.target.value)} />
                    </Field>
                    <Field label="Sort order" htmlFor="sort_order">
                        <input id="sort_order" type="number" className={inputClass} value={form.data.sort_order} onChange={(e) => form.setData('sort_order', e.target.value)} />
                    </Field>
                    <label className="flex items-center gap-2.5 text-[14px] text-ink">
                        <input type="checkbox" checked={form.data.is_active} onChange={(e) => form.setData('is_active', e.target.checked)} />
                        Active (visible on the site)
                    </label>
                    <div className="flex gap-3 pt-1">
                        <button type="submit" disabled={form.processing} className="rounded-md bg-ink px-5 py-2.5 text-[14px] font-semibold text-cream transition-colors hover:bg-ink/90 disabled:opacity-60">
                            Save
                        </button>
                        <Link href="/admin/benefits" className="rounded-md border border-hairline px-5 py-2.5 text-[14px] font-semibold text-ink transition-colors hover:bg-cream">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </AdminLayout>
    );
}
