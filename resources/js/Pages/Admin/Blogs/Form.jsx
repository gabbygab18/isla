import { Link, useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import CKEditorField from '@/components/admin/CKEditorField';

function Field({ label, htmlFor, hint, error, children }) {
    return (
        <div className="grid content-start gap-1.5">
            <label htmlFor={htmlFor} className="font-mono text-[11px] font-medium uppercase tracking-[0.05em] text-ink-soft">{label}</label>
            {children}
            {hint && !error && <span className="text-[12px] text-ink-soft">{hint}</span>}
            {error && <span className="text-[12.5px] text-[#b23b3b]">{error}</span>}
        </div>
    );
}

const inputClass = 'w-full rounded-md border border-hairline bg-white px-3 py-2.5 text-[14px] text-ink outline-none transition-colors focus:border-ink/40';

export default function BlogForm({ blog }) {
    const isEdit = !!blog;

    const form = useForm({
        title: blog?.title ?? '',
        slug: blog?.slug ?? '',
        sort_order: blog?.sort_order ?? 0,
        author: blog?.author ?? '',
        published_at: blog?.published_at ? blog.published_at.slice(0, 10) : '',
        cover_image: blog?.cover_image ?? '',
        excerpt: blog?.excerpt ?? '',
        body: blog?.body ?? '',
        is_active: blog?.is_active ?? true,
    });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) form.put(`/admin/blogs/${blog.slug}`);
        else form.post('/admin/blogs');
    };

    return (
        <AdminLayout title={isEdit ? 'Edit Blog Post' : 'New Blog Post'} heading={isEdit ? 'Edit Blog Post' : 'New Blog Post'}>
            <div className="rounded-lg border border-hairline-soft bg-white p-6 md:p-7">
                <form onSubmit={submit} className="grid max-w-2xl gap-5">
                    <Field label="Title" htmlFor="title" error={form.errors.title}>
                        <input id="title" className={inputClass} value={form.data.title} onChange={(e) => form.setData('title', e.target.value)} required />
                    </Field>

                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field label="Slug" htmlFor="slug" hint="Leave blank to auto-generate.">
                            <input id="slug" className={inputClass} value={form.data.slug} onChange={(e) => form.setData('slug', e.target.value)} />
                        </Field>
                        <Field label="Sort order" htmlFor="sort_order">
                            <input id="sort_order" type="number" className={inputClass} value={form.data.sort_order} onChange={(e) => form.setData('sort_order', e.target.value)} />
                        </Field>
                    </div>

                    <div className="grid gap-5 sm:grid-cols-2">
                        <Field label="Author" htmlFor="author">
                            <input id="author" className={inputClass} value={form.data.author} onChange={(e) => form.setData('author', e.target.value)} />
                        </Field>
                        <Field label="Published date" htmlFor="published_at">
                            <input id="published_at" type="date" className={inputClass} value={form.data.published_at} onChange={(e) => form.setData('published_at', e.target.value)} />
                        </Field>
                    </div>

                    <Field label="Cover image URL" htmlFor="cover_image" error={form.errors.cover_image}>
                        <input id="cover_image" placeholder="https://..." className={inputClass} value={form.data.cover_image} onChange={(e) => form.setData('cover_image', e.target.value)} />
                    </Field>

                    <Field label="Excerpt" htmlFor="excerpt" hint="Short summary shown on the blog listing." error={form.errors.excerpt}>
                        <textarea id="excerpt" rows={2} className={inputClass} value={form.data.excerpt} onChange={(e) => form.setData('excerpt', e.target.value)} />
                    </Field>

                    <Field label="Body" htmlFor="body" hint="Insert images by URL only (stock photo links) — no file upload." error={form.errors.body}>
                        <CKEditorField id="body" value={form.data.body} onChange={(html) => form.setData('body', html)} />
                    </Field>

                    <label className="flex items-center gap-2.5 text-[14px] text-ink">
                        <input type="checkbox" checked={form.data.is_active} onChange={(e) => form.setData('is_active', e.target.checked)} />
                        Active (visible on the site)
                    </label>

                    <div className="flex gap-3 pt-1">
                        <button type="submit" disabled={form.processing} className="rounded-md bg-ink px-5 py-2.5 text-[14px] font-semibold text-cream transition-colors hover:bg-ink/90 disabled:opacity-60">
                            Save
                        </button>
                        <Link href="/admin/blogs" className="rounded-md border border-hairline px-5 py-2.5 text-[14px] font-semibold text-ink transition-colors hover:bg-cream">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </AdminLayout>
    );
}
