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

export default function TestimonialForm({ testimonial }) {
    const isEdit = !!testimonial;

    const form = useForm({
        author: testimonial?.author ?? '',
        role: testimonial?.role ?? '',
        quote: testimonial?.quote ?? '',
        sort_order: testimonial?.sort_order ?? 0,
        is_active: testimonial?.is_active ?? true,
    });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) form.put(`/admin/testimonials/${testimonial.id}`);
        else form.post('/admin/testimonials');
    };

    return (
        <AdminLayout title={isEdit ? 'Edit Testimonial' : 'New Testimonial'} heading={isEdit ? 'Edit Testimonial' : 'New Testimonial'}>
            <div className="rounded-lg border border-hairline-soft bg-white p-6 md:p-7">
                <form onSubmit={submit} className="grid max-w-2xl gap-5">
                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field label="Author" htmlFor="author" error={form.errors.author}>
                            <input id="author" className={inputClass} value={form.data.author} onChange={(e) => form.setData('author', e.target.value)} required />
                        </Field>
                        <Field label="Role" htmlFor="role">
                            <input id="role" className={inputClass} value={form.data.role} onChange={(e) => form.setData('role', e.target.value)} />
                        </Field>
                    </div>
                    <Field label="Quote" htmlFor="quote" error={form.errors.quote}>
                        <textarea id="quote" rows={5} className={inputClass} value={form.data.quote} onChange={(e) => form.setData('quote', e.target.value)} required />
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
                        <Link href="/admin/testimonials" className="rounded-md border border-hairline px-5 py-2.5 text-[14px] font-semibold text-ink transition-colors hover:bg-cream">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </AdminLayout>
    );
}
