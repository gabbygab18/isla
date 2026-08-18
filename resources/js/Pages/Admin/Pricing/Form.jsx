import { Link, useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

function Field({ label, htmlFor, hint, error, children }) {
    return (
        <div className="grid gap-1.5">
            <label htmlFor={htmlFor} className="font-mono text-[11px] font-medium uppercase tracking-[0.05em] text-ink-soft">{label}</label>
            {children}
            {hint && !error && <span className="text-[12px] text-ink-soft">{hint}</span>}
            {error && <span className="text-[12.5px] text-[#b23b3b]">{error}</span>}
        </div>
    );
}

const inputClass = 'w-full rounded-md border border-hairline bg-white px-3 py-2.5 text-[14px] text-ink outline-none transition-colors focus:border-ink/40';

export default function PricingForm({ plan }) {
    const isEdit = !!plan;

    const form = useForm({
        name: plan?.name ?? '',
        slug: plan?.slug ?? '',
        tag: plan?.tag ?? '',
        detail: plan?.detail ?? '',
        summary: plan?.summary ?? '',
        body: plan?.body ?? '',
        features_text: (plan?.features ?? []).join('\n'),
        ribbon: plan?.ribbon ?? '',
        sort_order: plan?.sort_order ?? 0,
        is_featured: plan?.is_featured ?? false,
        is_active: plan?.is_active ?? true,
    });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) form.put(`/admin/pricing-plans/${plan.slug}`);
        else form.post('/admin/pricing-plans');
    };

    return (
        <AdminLayout title={isEdit ? 'Edit Plan' : 'New Plan'} heading={isEdit ? 'Edit Plan' : 'New Plan'}>
            <div className="rounded-lg border border-hairline-soft bg-white p-6 md:p-7">
                <form onSubmit={submit} className="grid max-w-2xl gap-5">
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field label="Name" htmlFor="name" error={form.errors.name}>
                            <input id="name" className={inputClass} value={form.data.name} onChange={(e) => form.setData('name', e.target.value)} required />
                        </Field>
                        <Field label="Slug" htmlFor="slug" hint="Leave blank to auto-generate.">
                            <input id="slug" className={inputClass} value={form.data.slug} onChange={(e) => form.setData('slug', e.target.value)} />
                        </Field>
                    </div>

                    <div className="grid gap-5 sm:grid-cols-3">
                        <Field label="Tag" htmlFor="tag" hint='e.g. "Part-time support"'>
                            <input id="tag" className={inputClass} value={form.data.tag} onChange={(e) => form.setData('tag', e.target.value)} />
                        </Field>
                        <Field label="Detail" htmlFor="detail" hint='e.g. "20 hrs / week"'>
                            <input id="detail" className={inputClass} value={form.data.detail} onChange={(e) => form.setData('detail', e.target.value)} />
                        </Field>
                        <Field label="Ribbon" htmlFor="ribbon" hint='e.g. "Most popular"'>
                            <input id="ribbon" className={inputClass} value={form.data.ribbon} onChange={(e) => form.setData('ribbon', e.target.value)} />
                        </Field>
                    </div>

                    <Field label="Card summary" htmlFor="summary">
                        <textarea id="summary" rows={2} className={inputClass} value={form.data.summary} onChange={(e) => form.setData('summary', e.target.value)} />
                    </Field>

                    <Field label="Detail page body" htmlFor="body" hint="Separate paragraphs with a blank line.">
                        <textarea id="body" rows={6} className={inputClass} value={form.data.body} onChange={(e) => form.setData('body', e.target.value)} />
                    </Field>

                    <Field label="Feature checklist" htmlFor="features_text" hint="One feature per line.">
                        <textarea id="features_text" rows={4} className={inputClass} value={form.data.features_text} onChange={(e) => form.setData('features_text', e.target.value)} />
                    </Field>

                    <Field label="Sort order" htmlFor="sort_order">
                        <input id="sort_order" type="number" className={inputClass} value={form.data.sort_order} onChange={(e) => form.setData('sort_order', e.target.value)} />
                    </Field>

                    <div className="flex flex-col gap-2.5">
                        <label className="flex items-center gap-2.5 text-[14px] text-ink">
                            <input type="checkbox" checked={form.data.is_featured} onChange={(e) => form.setData('is_featured', e.target.checked)} />
                            Featured plan
                        </label>
                        <label className="flex items-center gap-2.5 text-[14px] text-ink">
                            <input type="checkbox" checked={form.data.is_active} onChange={(e) => form.setData('is_active', e.target.checked)} />
                            Active (visible on the site)
                        </label>
                    </div>

                    <div className="flex gap-3 pt-1">
                        <button type="submit" disabled={form.processing} className="rounded-md bg-ink px-5 py-2.5 text-[14px] font-semibold text-cream transition-colors hover:bg-ink/90 disabled:opacity-60">
                            Save
                        </button>
                        <Link href="/admin/pricing-plans" className="rounded-md border border-hairline px-5 py-2.5 text-[14px] font-semibold text-ink transition-colors hover:bg-cream">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </AdminLayout>
    );
}
