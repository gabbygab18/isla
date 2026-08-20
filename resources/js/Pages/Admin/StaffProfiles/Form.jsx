import { useState } from 'react';
import { Link, useForm } from '@inertiajs/react';
import { Plus, Trash2 } from 'lucide-react';
import AdminProfileLayout from '@/Layouts/AdminProfileLayout';
import ImageCropper from '@/components/admin/ImageCropper';

const inputClass = 'w-full rounded-md border border-hairline bg-white px-3 py-2.5 text-[14px] text-ink outline-none transition-colors focus:border-ink/40';

// content-start keeps the rows packed to the top: side-by-side fields in a
// grid row stretch to the tallest sibling, so a field without a hint would
// otherwise absorb the leftover height and push its input out of line.
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

function Card({ title, children, onRemove }) {
    return (
        <div className="rounded-lg border border-hairline-soft bg-cream/40 p-5">
            <div className="mb-4 flex items-center justify-between">
                <h4 className="text-[13.5px] font-bold text-ink">{title}</h4>
                <button type="button" onClick={onRemove} className="inline-flex h-7 w-7 items-center justify-center rounded-md border border-hairline text-[#b23b3b] transition-colors hover:border-[#b23b3b]/40">
                    <Trash2 className="h-3.5 w-3.5" />
                </button>
            </div>
            <div className="grid gap-4">{children}</div>
        </div>
    );
}

const emptyEducation = () => ({ school: '', degree: '', period: '' });
const emptyExperience = () => ({ company: '', title: '', period: '', bulletsText: '' });

export default function StaffProfileForm({ profile, roles = [] }) {
    const isEdit = !!profile;

    const [education, setEducation] = useState(
        (profile?.education?.length ? profile.education : []).map((e) => ({ school: e.school || '', degree: e.degree || '', period: e.period || '' })),
    );
    const [experience, setExperience] = useState(
        (profile?.experience?.length ? profile.experience : []).map((e) => ({
            company: e.company || '', title: e.title || '', period: e.period || '', bulletsText: (e.bullets || []).join('\n'),
        })),
    );

    const [photoFile, setPhotoFile] = useState(null);
    const [photoPreview, setPhotoPreview] = useState(profile?.photo_display_url ?? null);
    const [removePhoto, setRemovePhoto] = useState(false);
    const [cropSrc, setCropSrc] = useState(null);
    const [cropName, setCropName] = useState('photo.jpg');

    const form = useForm({
        name: profile?.name ?? '',
        role_title: profile?.role_title ?? '',
        category: profile?.category ?? '',
        rate: profile?.rate ?? '',
        work_preference: profile?.work_preference ?? '',
        availability: profile?.availability ?? '',
        about_me: profile?.about_me ?? '',
        core_skills_text: (profile?.core_skills ?? []).join('\n'),
        software_expertise_text: (profile?.software_expertise ?? []).join('\n'),
        certifications_text: (profile?.certifications ?? []).join('\n'),
        affiliations_text: (profile?.affiliations ?? []).join('\n'),
        talent_role_id: profile?.talent_role_id ?? '',
        talent_sub_role_id: profile?.talent_sub_role_id ?? '',
        sort_order: profile?.sort_order ?? 0,
        is_active: profile?.is_active ?? true,
    });

    const selectedRole = roles.find((r) => String(r.id) === String(form.data.talent_role_id));
    const subRoleOptions = selectedRole?.sub_roles ?? [];

    const toLines = (text) => text.split('\n').map((s) => s.trim()).filter(Boolean);

    const submit = (e) => {
        e.preventDefault();

        const payload = {
            name: form.data.name,
            role_title: form.data.role_title,
            category: form.data.category,
            rate: form.data.rate,
            work_preference: form.data.work_preference,
            availability: form.data.availability,
            about_me: form.data.about_me,
            talent_role_id: form.data.talent_role_id || null,
            talent_sub_role_id: form.data.talent_sub_role_id || null,
            core_skills: toLines(form.data.core_skills_text),
            software_expertise: toLines(form.data.software_expertise_text),
            certifications: toLines(form.data.certifications_text),
            affiliations: toLines(form.data.affiliations_text),
            education: education.filter((e) => e.school.trim()).map((e) => ({ school: e.school, degree: e.degree, period: e.period })),
            experience: experience.filter((e) => e.company.trim()).map((e) => ({
                company: e.company, title: e.title, period: e.period, bullets: toLines(e.bulletsText),
            })),
            sort_order: form.data.sort_order,
            is_active: form.data.is_active,
            remove_photo: removePhoto,
        };

        // transform() returns undefined (it just stores the callback), so it has
        // to be called on its own — chaining .put()/.post() off it throws.
        form.transform(() => payload);

        const options = { onError: () => window.scrollTo({ top: 0, behavior: 'smooth' }) };

        // A file can't be sent over a real PUT, so edits with a new photo go out
        // as POST + _method spoofing over FormData. Without a file we keep the
        // plain JSON path, which serialises the nested education/experience
        // arrays more predictably.
        if (photoFile) {
            payload.photo = photoFile;
            if (isEdit) payload._method = 'put';
            form.post(
                isEdit ? `/admin/staff-profiles/${profile.slug}` : '/admin/staff-profiles',
                { ...options, forceFormData: true },
            );
            return;
        }

        if (isEdit) form.put(`/admin/staff-profiles/${profile.slug}`, options);
        else form.post('/admin/staff-profiles', options);
    };

    return (
        <AdminProfileLayout title={isEdit ? 'Edit Profile' : 'New Profile'}>
            <section className="pb-20 pt-14 md:pt-20">
                <div className="container-site max-w-3xl">
                    <div className="mb-6">
                        <Link href="/admin/staff-profiles" className="text-[13.5px] font-semibold text-ink-soft transition-colors hover:text-ink">← All profiles</Link>
                    </div>
                    <h1 className="t-display-lg mb-8">{isEdit ? `Edit ${profile.name}` : 'New Staff Profile'}</h1>

                    {Object.keys(form.errors).length > 0 && (
                        <div className="mb-6 rounded-lg bg-rose-soft px-5 py-4 text-[14px] text-rose-deep">
                            <p className="font-bold">Couldn't save — please fix the following:</p>
                            <ul className="mt-2 list-disc pl-5">
                                {Object.entries(form.errors).map(([field, message]) => (
                                    <li key={field}>{message}</li>
                                ))}
                            </ul>
                        </div>
                    )}

                    <form onSubmit={submit} className="flex flex-col gap-8">
                        <div className="rounded-lg border border-hairline-soft bg-white p-6">
                            <h3 className="mb-4 text-[15px] font-bold">Basics</h3>
                            <div className="grid gap-5">
                                <Field label="Profile picture" htmlFor="photo" hint="JPG, PNG or WEBP · max 4MB. Square images look best." error={form.errors.photo}>
                                    <div className="flex items-center gap-4">
                                        <span className="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full border border-hairline bg-gradient-to-br from-rose-soft to-rose-deep/30">
                                            {photoPreview ? (
                                                <img src={photoPreview} alt="" className="h-full w-full object-cover" />
                                            ) : (
                                                <img src="/butterfly.png" alt="" className="h-8 w-8 opacity-70" />
                                            )}
                                        </span>
                                        <div className="flex flex-wrap items-center gap-2">
                                            <label
                                                htmlFor="photo"
                                                className="cursor-pointer rounded-md border border-hairline bg-white px-4 py-2 text-[13.5px] font-semibold text-ink transition-colors hover:bg-cream"
                                            >
                                                {photoPreview ? 'Change photo' : 'Upload photo'}
                                            </label>
                                            {photoPreview && (
                                                <button
                                                    type="button"
                                                    onClick={() => {
                                                        setPhotoFile(null);
                                                        setPhotoPreview(null);
                                                        setRemovePhoto(true);
                                                    }}
                                                    className="rounded-md border border-hairline px-4 py-2 text-[13.5px] font-semibold text-[#b23b3b] transition-colors hover:border-[#b23b3b]/40"
                                                >
                                                    Remove
                                                </button>
                                            )}
                                        </div>
                                        <input
                                            id="photo"
                                            type="file"
                                            accept="image/jpeg,image/png,image/webp"
                                            className="sr-only"
                                            onChange={(e) => {
                                                const file = e.target.files?.[0] ?? null;
                                                if (!file) return;
                                                // Straight into the cropper — the file that finally gets
                                                // attached is the cropped square, not the raw upload.
                                                setCropName(file.name);
                                                setCropSrc(URL.createObjectURL(file));
                                                e.target.value = ''; // let the same file be re-picked later
                                            }}
                                        />
                                    </div>
                                </Field>

                                <div className="grid gap-5 sm:grid-cols-2">
                                    <Field label="Name" htmlFor="name" error={form.errors.name}>
                                        <input id="name" className={inputClass} value={form.data.name} onChange={(e) => form.setData('name', e.target.value)} required />
                                    </Field>
                                    <Field label="Role title" htmlFor="role_title" error={form.errors.role_title}>
                                        <input id="role_title" className={inputClass} value={form.data.role_title} onChange={(e) => form.setData('role_title', e.target.value)} required />
                                    </Field>
                                </div>
                                <div className="grid gap-5 sm:grid-cols-2">
                                    <Field label="Industry" htmlFor="talent_role_id" hint="Drives which client link this profile appears under.">
                                        <select
                                            id="talent_role_id"
                                            className={inputClass}
                                            value={form.data.talent_role_id}
                                            onChange={(e) => {
                                                form.setData('talent_role_id', e.target.value);
                                                // Roles belong to an industry — clear the stale one on change.
                                                form.setData('talent_sub_role_id', '');
                                            }}
                                        >
                                            <option value="">— None —</option>
                                            {roles.map((r) => <option key={r.id} value={r.id}>{r.name}</option>)}
                                        </select>
                                    </Field>
                                    <Field label="Role" htmlFor="talent_sub_role_id" hint={selectedRole ? 'Which role the client picks on the industry link.' : 'Pick an industry first.'}>
                                        <select
                                            id="talent_sub_role_id"
                                            className={inputClass}
                                            value={form.data.talent_sub_role_id}
                                            onChange={(e) => form.setData('talent_sub_role_id', e.target.value)}
                                            disabled={!selectedRole || subRoleOptions.length === 0}
                                        >
                                            <option value="">— None —</option>
                                            {subRoleOptions.map((s) => <option key={s.id} value={s.id}>{s.name}</option>)}
                                        </select>
                                    </Field>
                                </div>

                                <div className="grid gap-5 sm:grid-cols-2">
                                    <Field label="Category" htmlFor="category" hint="e.g. Construction, Marketing, NDIS">
                                        <input id="category" list="category-options" className={inputClass} value={form.data.category} onChange={(e) => form.setData('category', e.target.value)} />
                                        <datalist id="category-options">
                                            <option value="Construction" />
                                            <option value="Marketing" />
                                            <option value="NDIS" />
                                        </datalist>
                                    </Field>
                                    <Field label="Sort order" htmlFor="sort_order">
                                        <input id="sort_order" type="number" className={inputClass} value={form.data.sort_order} onChange={(e) => form.setData('sort_order', e.target.value)} />
                                    </Field>
                                </div>
                                <Field label="About" htmlFor="about_me">
                                    <textarea id="about_me" rows={4} className={inputClass} value={form.data.about_me} onChange={(e) => form.setData('about_me', e.target.value)} />
                                </Field>
                            </div>
                        </div>

                        <div className="rounded-lg border border-hairline-soft bg-white p-6">
                            <h3 className="mb-4 text-[15px] font-bold">Engagement Details</h3>
                            <div className="grid gap-5 sm:grid-cols-3">
                                <Field label="Rate" htmlFor="rate" hint="e.g. 16 AUD per hour">
                                    <input id="rate" className={inputClass} value={form.data.rate} onChange={(e) => form.setData('rate', e.target.value)} />
                                </Field>
                                <Field label="Work preference" htmlFor="work_preference" hint="e.g. Full Time (40hrs per week)">
                                    <input id="work_preference" className={inputClass} value={form.data.work_preference} onChange={(e) => form.setData('work_preference', e.target.value)} />
                                </Field>
                                <Field label="Availability" htmlFor="availability" hint="e.g. Immediately">
                                    <input id="availability" className={inputClass} value={form.data.availability} onChange={(e) => form.setData('availability', e.target.value)} />
                                </Field>
                            </div>
                        </div>

                        <div className="rounded-lg border border-hairline-soft bg-white p-6">
                            <h3 className="mb-4 text-[15px] font-bold">Skills &amp; Software</h3>
                            <div className="grid gap-5 sm:grid-cols-2">
                                <Field label="Core skills" htmlFor="core_skills_text" hint="One per line.">
                                    <textarea id="core_skills_text" rows={6} className={inputClass} value={form.data.core_skills_text} onChange={(e) => form.setData('core_skills_text', e.target.value)} />
                                </Field>
                                <Field label="Software expertise" htmlFor="software_expertise_text" hint="One per line.">
                                    <textarea id="software_expertise_text" rows={6} className={inputClass} value={form.data.software_expertise_text} onChange={(e) => form.setData('software_expertise_text', e.target.value)} />
                                </Field>
                                <Field label="Certifications" htmlFor="certifications_text" hint="One per line. Optional.">
                                    <textarea id="certifications_text" rows={4} className={inputClass} value={form.data.certifications_text} onChange={(e) => form.setData('certifications_text', e.target.value)} />
                                </Field>
                                <Field label="Affiliations" htmlFor="affiliations_text" hint="One per line. Optional.">
                                    <textarea id="affiliations_text" rows={4} className={inputClass} value={form.data.affiliations_text} onChange={(e) => form.setData('affiliations_text', e.target.value)} />
                                </Field>
                            </div>
                        </div>

                        <div className="rounded-lg border border-hairline-soft bg-white p-6">
                            <div className="mb-4 flex items-center justify-between">
                                <h3 className="text-[15px] font-bold">Education</h3>
                                <button
                                    type="button"
                                    onClick={() => setEducation([...education, emptyEducation()])}
                                    className="inline-flex items-center gap-1.5 rounded-md border border-hairline px-3 py-1.5 text-[13px] font-semibold text-ink-soft transition-colors hover:border-ink/40 hover:text-ink"
                                >
                                    <Plus className="h-3.5 w-3.5" /> Add
                                </button>
                            </div>
                            <div className="flex flex-col gap-4">
                                {education.length === 0 && <p className="text-[13.5px] text-ink-soft">No education entries yet.</p>}
                                {education.map((edu, i) => (
                                    <Card key={i} title={`Entry ${i + 1}`} onRemove={() => setEducation(education.filter((_, j) => j !== i))}>
                                        <div className="grid gap-4 sm:grid-cols-2">
                                            <Field label="School" htmlFor={`edu-school-${i}`}>
                                                <input id={`edu-school-${i}`} className={inputClass} value={edu.school} onChange={(e) => setEducation(education.map((x, j) => j === i ? { ...x, school: e.target.value } : x))} />
                                            </Field>
                                            <Field label="Period" htmlFor={`edu-period-${i}`}>
                                                <input id={`edu-period-${i}`} className={inputClass} value={edu.period} onChange={(e) => setEducation(education.map((x, j) => j === i ? { ...x, period: e.target.value } : x))} />
                                            </Field>
                                        </div>
                                        <Field label="Degree" htmlFor={`edu-degree-${i}`}>
                                            <input id={`edu-degree-${i}`} className={inputClass} value={edu.degree} onChange={(e) => setEducation(education.map((x, j) => j === i ? { ...x, degree: e.target.value } : x))} />
                                        </Field>
                                    </Card>
                                ))}
                            </div>
                        </div>

                        <div className="rounded-lg border border-hairline-soft bg-white p-6">
                            <div className="mb-4 flex items-center justify-between">
                                <h3 className="text-[15px] font-bold">Work Experience</h3>
                                <button
                                    type="button"
                                    onClick={() => setExperience([...experience, emptyExperience()])}
                                    className="inline-flex items-center gap-1.5 rounded-md border border-hairline px-3 py-1.5 text-[13px] font-semibold text-ink-soft transition-colors hover:border-ink/40 hover:text-ink"
                                >
                                    <Plus className="h-3.5 w-3.5" /> Add
                                </button>
                            </div>
                            <div className="flex flex-col gap-4">
                                {experience.length === 0 && <p className="text-[13.5px] text-ink-soft">No experience entries yet.</p>}
                                {experience.map((job, i) => (
                                    <Card key={i} title={`Entry ${i + 1}`} onRemove={() => setExperience(experience.filter((_, j) => j !== i))}>
                                        <div className="grid gap-4 sm:grid-cols-2">
                                            <Field label="Company" htmlFor={`exp-company-${i}`}>
                                                <input id={`exp-company-${i}`} className={inputClass} value={job.company} onChange={(e) => setExperience(experience.map((x, j) => j === i ? { ...x, company: e.target.value } : x))} />
                                            </Field>
                                            <Field label="Title" htmlFor={`exp-title-${i}`}>
                                                <input id={`exp-title-${i}`} className={inputClass} value={job.title} onChange={(e) => setExperience(experience.map((x, j) => j === i ? { ...x, title: e.target.value } : x))} />
                                            </Field>
                                        </div>
                                        <Field label="Period" htmlFor={`exp-period-${i}`} hint="e.g. Jan 2024 – Present">
                                            <input id={`exp-period-${i}`} className={inputClass} value={job.period} onChange={(e) => setExperience(experience.map((x, j) => j === i ? { ...x, period: e.target.value } : x))} />
                                        </Field>
                                        <Field label="Bullets" htmlFor={`exp-bullets-${i}`} hint="One per line.">
                                            <textarea id={`exp-bullets-${i}`} rows={4} className={inputClass} value={job.bulletsText} onChange={(e) => setExperience(experience.map((x, j) => j === i ? { ...x, bulletsText: e.target.value } : x))} />
                                        </Field>
                                    </Card>
                                ))}
                            </div>
                        </div>

                        <label className="flex items-center gap-2.5 text-[14px] text-ink">
                            <input type="checkbox" checked={form.data.is_active} onChange={(e) => form.setData('is_active', e.target.checked)} />
                            Active (shown in the talent bench)
                        </label>

                        <div className="flex gap-3">
                            <button type="submit" disabled={form.processing} className="rounded-md bg-ink px-6 py-3 text-[14.5px] font-semibold text-cream transition-colors hover:bg-ink/90 disabled:opacity-60">
                                Save profile
                            </button>
                            <Link href="/admin/staff-profiles" className="rounded-md border border-hairline px-6 py-3 text-[14.5px] font-semibold text-ink transition-colors hover:bg-cream">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </section>

            {cropSrc && (
                <ImageCropper
                    src={cropSrc}
                    fileName={cropName}
                    onCancel={() => {
                        URL.revokeObjectURL(cropSrc);
                        setCropSrc(null);
                    }}
                    onApply={(croppedFile) => {
                        URL.revokeObjectURL(cropSrc);
                        setCropSrc(null);
                        setPhotoFile(croppedFile);
                        setRemovePhoto(false);
                        setPhotoPreview(URL.createObjectURL(croppedFile));
                    }}
                />
            )}
        </AdminProfileLayout>
    );
}
