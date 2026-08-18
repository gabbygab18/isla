import { useState } from 'react';
import { Link, useForm, usePage } from '@inertiajs/react';
import { Download, Upload } from 'lucide-react';
import AdminProfileLayout from '@/Layouts/AdminProfileLayout';

export default function StaffProfilesImport() {
    const { props } = usePage();
    const flashSuccess = props?.flash?.success;
    const flashError = props?.flash?.error;
    const [fileName, setFileName] = useState('');

    const form = useForm({ file: null });

    const submit = (e) => {
        e.preventDefault();
        form.post('/admin/staff-profiles/import', { forceFormData: true });
    };

    return (
        <AdminProfileLayout title="Import Staff Profiles">
            <section className="pb-20 pt-14 md:pt-20">
                <div className="container-site max-w-2xl">
                    <div className="mb-6">
                        <Link href="/admin/staff-profiles" className="text-[13.5px] font-semibold text-ink-soft transition-colors hover:text-ink">← All profiles</Link>
                    </div>
                    <h1 className="t-display-lg mb-3">Import from CSV</h1>
                    <p className="mb-8 text-[15px] leading-relaxed text-ink-soft">
                        Bulk create or update staff profiles from a spreadsheet. Works with Excel, Google Sheets or Numbers — export/save as CSV before uploading. Rows with a <code className="rounded bg-cream px-1.5 py-0.5 font-mono text-[12.5px]">slug</code> matching an existing profile update it in place; everything else is created new.
                    </p>

                    {flashSuccess && (
                        <div className="mb-6 rounded-lg bg-sage-soft px-5 py-4 text-[14px] font-semibold text-sage-deep">{flashSuccess}</div>
                    )}
                    {flashError && (
                        <div className="mb-6 rounded-lg bg-rose-soft px-5 py-4 text-[14px] font-semibold text-rose-deep">{flashError}</div>
                    )}

                    <div className="rounded-lg border border-hairline-soft bg-white p-6 md:p-7">
                        <h3 className="mb-3 text-[15px] font-bold">1. Get the template</h3>
                        <p className="mb-4 text-[14px] text-ink-soft">
                            Pre-filled headers with one example row. Multi-value fields (skills, software, certifications, affiliations, and each job's bullet points) are pipe-separated (<code className="rounded bg-cream px-1.5 py-0.5 font-mono text-[12.5px]">Skill A | Skill B</code>) within a single cell. Education and work experience each get a fixed set of numbered columns (2 education slots, 4 experience slots) — leave the ones you don't need blank.
                        </p>
                        <a
                            href="/admin/staff-profiles/import/template"
                            className="inline-flex items-center gap-2 rounded-md border border-hairline px-4 py-2.5 text-[14px] font-semibold text-ink transition-colors hover:bg-cream"
                        >
                            <Download className="h-4 w-4" strokeWidth={2.2} />
                            Download CSV template
                        </a>

                        <div className="my-7 border-t border-hairline-soft" />

                        <h3 className="mb-3 text-[15px] font-bold">2. Upload your file</h3>
                        <form onSubmit={submit} className="flex flex-col gap-4">
                            <label
                                htmlFor="file"
                                className="flex cursor-pointer items-center justify-between gap-3 rounded-md border border-dashed border-hairline bg-cream/40 px-4 py-4 text-[14.5px] transition-colors hover:border-ink/40"
                            >
                                <span className={fileName ? 'font-medium text-ink' : 'text-ink-soft/70'}>
                                    {fileName || 'Choose a CSV file'}
                                </span>
                                <span className="shrink-0 rounded-pill bg-white px-3 py-1.5 text-[12.5px] font-semibold text-ink-soft">Browse</span>
                            </label>
                            <input
                                id="file"
                                type="file"
                                accept=".csv,text/csv"
                                className="sr-only"
                                onChange={(e) => {
                                    const file = e.target.files?.[0] ?? null;
                                    form.setData('file', file);
                                    setFileName(file?.name || '');
                                }}
                            />
                            {form.errors.file && <span className="text-[12.5px] text-[#b23b3b]">{form.errors.file}</span>}

                            <button
                                type="submit"
                                disabled={form.processing || !form.data.file}
                                className="inline-flex w-fit items-center gap-2 rounded-md bg-ink px-6 py-3 text-[14.5px] font-semibold text-cream transition-colors hover:bg-ink/90 disabled:opacity-50"
                            >
                                <Upload className="h-4 w-4" strokeWidth={2.2} />
                                {form.processing ? 'Importing…' : 'Import'}
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </AdminProfileLayout>
    );
}
