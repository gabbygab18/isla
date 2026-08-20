import { useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

const inputClass = 'w-full rounded-md border border-hairline bg-white px-3 py-2.5 text-[14px] text-ink outline-none transition-colors focus:border-ink/40';

export default function SettingsIndex({ groups = {}, settings = {} }) {
    const initial = {};
    Object.values(groups).forEach((fields) => {
        Object.keys(fields).forEach((key) => { initial[key] = settings[key] ?? ''; });
    });

    const form = useForm({ settings: initial });

    const submit = (e) => {
        e.preventDefault();
        form.post('/admin/settings');
    };

    return (
        <AdminLayout title="Settings" heading="Site settings">
            <form onSubmit={submit} className="flex flex-col gap-5">
                {Object.entries(groups).map(([groupName, fields]) => (
                    <div key={groupName} className="rounded-lg border border-hairline-soft bg-white p-6">
                        <h3 className="mb-4 text-[16px] font-bold">{groupName}</h3>
                        <div className="grid gap-5">
                            {Object.entries(fields).map(([key, [label, type]]) => (
                                <div key={key} className="grid content-start gap-1.5">
                                    <label htmlFor={`s_${key}`} className="font-mono text-[11px] font-medium uppercase tracking-[0.05em] text-ink-soft">
                                        {label}
                                    </label>
                                    {type === 'textarea' ? (
                                        <textarea
                                            id={`s_${key}`}
                                            rows={3}
                                            className={inputClass}
                                            value={form.data.settings[key] ?? ''}
                                            onChange={(e) => form.setData('settings', { ...form.data.settings, [key]: e.target.value })}
                                        />
                                    ) : (
                                        <input
                                            id={`s_${key}`}
                                            type="text"
                                            className={inputClass}
                                            value={form.data.settings[key] ?? ''}
                                            onChange={(e) => form.setData('settings', { ...form.data.settings, [key]: e.target.value })}
                                        />
                                    )}
                                </div>
                            ))}
                        </div>
                    </div>
                ))}

                <div className="sticky bottom-0 -mx-5 bg-cream px-5 py-4 lg:-mx-7 lg:px-7">
                    <button
                        type="submit"
                        disabled={form.processing}
                        className="rounded-md bg-ink px-5 py-2.5 text-[14px] font-semibold text-cream transition-colors hover:bg-ink/90 disabled:opacity-60"
                    >
                        Save all settings
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
