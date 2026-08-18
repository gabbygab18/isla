import { Link, useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

function Field({ label, htmlFor, hint, error, children }) {
    return (
        <div className="grid gap-1.5">
            <label htmlFor={htmlFor} className="font-mono text-[11px] font-medium uppercase tracking-[0.05em] text-ink-soft">
                {label}
            </label>
            {children}
            {hint && !error && <span className="text-[12px] text-ink-soft">{hint}</span>}
            {error && <span className="text-[12.5px] text-[#b23b3b]">{error}</span>}
        </div>
    );
}

const inputClass = 'w-full rounded-md border border-hairline bg-white px-3 py-2.5 text-[14px] text-ink outline-none transition-colors focus:border-ink/40';

export default function ServiceForm({ service }) {
    const isEdit = !!service;

    const form = useForm({
        title: service?.title ?? '',
        icon: service?.icon ?? 'i-calendar',
        slug: service?.slug ?? '',
        sort_order: service?.sort_order ?? 0,
        summary: service?.summary ?? '',
        body: service?.body ?? '',
        deliverables_text: (service?.deliverables ?? []).join('\n'),
        is_active: service?.is_active ?? true,
    });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) {
            form.put(`/admin/services/${service.slug}`);
        } else {
            form.post('/admin/services');
        }
    };

    return (
        <AdminLayout title={isEdit ? 'Edit Service' : 'New Service'} heading={isEdit ? 'Edit Service' : 'New Service'}>
            <div className="rounded-lg border border-hairline-soft bg-white p-6 md:p-7">
                <form onSubmit={submit} className="grid max-w-2xl gap-5">
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field label="Title" htmlFor="title" error={form.errors.title}>
                            <input id="title" className={inputClass} value={form.data.title} onChange={(e) => form.setData('title', e.target.value)} required />
                        </Field>
                        <Field label="Icon (SVG symbol id)" htmlFor="icon">
                            <input id="icon" className={inputClass} value={form.data.icon} onChange={(e) => form.setData('icon', e.target.value)} />
                        </Field>
                    </div>

                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field label="Slug" htmlFor="slug" hint="Leave blank to auto-generate from the title.">
                            <input id="slug" className={inputClass} value={form.data.slug} onChange={(e) => form.setData('slug', e.target.value)} />
                        </Field>
                        <Field label="Sort order" htmlFor="sort_order">
                            <input id="sort_order" type="number" className={inputClass} value={form.data.sort_order} onChange={(e) => form.setData('sort_order', e.target.value)} />
                        </Field>
                    </div>

                    <Field label="Card summary" htmlFor="summary">
                        <textarea id="summary" rows={2} className={inputClass} value={form.data.summary} onChange={(e) => form.setData('summary', e.target.value)} />
                    </Field>

                    <Field label="Detail page body" htmlFor="body" hint="Separate paragraphs with a blank line.">
                        <textarea id="body" rows={6} className={inputClass} value={form.data.body} onChange={(e) => form.setData('body', e.target.value)} />
                    </Field>

                    <Field label="What's included" htmlFor="deliverables_text" hint="One item per line.">
                        <textarea id="deliverables_text" rows={4} className={inputClass} value={form.data.deliverables_text} onChange={(e) => form.setData('deliverables_text', e.target.value)} />
                    </Field>

                    <label className="flex items-center gap-2.5 text-[14px] text-ink">
                        <input type="checkbox" checked={form.data.is_active} onChange={(e) => form.setData('is_active', e.target.checked)} />
                        Active (visible on the site)
                    </label>

                    <div className="flex gap-3 pt-1">
                        <button
                            type="submit"
                            disabled={form.processing}
                            className="rounded-md bg-ink px-5 py-2.5 text-[14px] font-semibold text-cream transition-colors hover:bg-ink/90 disabled:opacity-60"
                        >
                            Save
                        </button>
                        <Link href="/admin/services" className="rounded-md border border-hairline px-5 py-2.5 text-[14px] font-semibold text-ink transition-colors hover:bg-cream">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </AdminLayout>
    );
}
