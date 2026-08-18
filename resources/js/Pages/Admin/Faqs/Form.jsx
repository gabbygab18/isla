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

export default function FaqForm({ faq }) {
    const isEdit = !!faq;

    const form = useForm({
        question: faq?.question ?? '',
        slug: faq?.slug ?? '',
        answer: faq?.answer ?? '',
        sort_order: faq?.sort_order ?? 0,
        is_active: faq?.is_active ?? true,
    });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) form.put(`/admin/faqs/${faq.slug}`);
        else form.post('/admin/faqs');
    };

    return (
        <AdminLayout title={isEdit ? 'Edit FAQ' : 'New FAQ'} heading={isEdit ? 'Edit FAQ' : 'New FAQ'}>
            <div className="rounded-lg border border-hairline-soft bg-white p-6 md:p-7">
                <form onSubmit={submit} className="grid max-w-2xl gap-5">
                    <Field label="Question" htmlFor="question" error={form.errors.question}>
                        <input id="question" className={inputClass} value={form.data.question} onChange={(e) => form.setData('question', e.target.value)} required />
                    </Field>

                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field label="Slug" htmlFor="slug" hint="Leave blank to auto-generate.">
                            <input id="slug" className={inputClass} value={form.data.slug} onChange={(e) => form.setData('slug', e.target.value)} />
                        </Field>
                        <Field label="Sort order" htmlFor="sort_order">
                            <input id="sort_order" type="number" className={inputClass} value={form.data.sort_order} onChange={(e) => form.setData('sort_order', e.target.value)} />
                        </Field>
                    </div>

                    <Field label="Answer" htmlFor="answer" hint="Separate paragraphs with a blank line." error={form.errors.answer}>
                        <textarea id="answer" rows={8} className={inputClass} value={form.data.answer} onChange={(e) => form.setData('answer', e.target.value)} required />
                    </Field>

                    <label className="flex items-center gap-2.5 text-[14px] text-ink">
                        <input type="checkbox" checked={form.data.is_active} onChange={(e) => form.setData('is_active', e.target.checked)} />
                        Active (visible on the site)
                    </label>

                    <div className="flex gap-3 pt-1">
                        <button type="submit" disabled={form.processing} className="rounded-md bg-ink px-5 py-2.5 text-[14px] font-semibold text-cream transition-colors hover:bg-ink/90 disabled:opacity-60">
                            Save
                        </button>
                        <Link href="/admin/faqs" className="rounded-md border border-hairline px-5 py-2.5 text-[14px] font-semibold text-ink transition-colors hover:bg-cream">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </AdminLayout>
    );
}
