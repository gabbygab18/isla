import { useState } from 'react';
import { router, useForm } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { ChevronDown, Plus, RefreshCw, Trash2, X } from 'lucide-react';
import AdminLayout from '@/Layouts/AdminLayout';
import CopyLinkButton from '@/components/admin/CopyLinkButton';

const inputClass = 'w-full rounded-md border border-hairline bg-white px-3 py-2 text-[14px] text-ink outline-none transition-colors focus:border-ink/40';

function shareUrl(token) {
    return `${window.location.origin}/talent/${token}`;
}

function RoleEditor({ role, categories, onClose }) {
    const form = useForm({
        name: role.name,
        category: role.category ?? '',
        sort_order: role.sort_order,
        is_active: role.is_active,
    });

    const submit = (e) => {
        e.preventDefault();
        form.put(`/admin/talent-taxonomy/roles/${role.id}`, { preserveScroll: true, onSuccess: onClose });
    };

    return (
        <form onSubmit={submit} className="grid gap-3 rounded-md border border-hairline-soft bg-cream/40 p-4 sm:grid-cols-[2fr_1fr_auto_auto]">
            <input className={inputClass} value={form.data.name} onChange={(e) => form.setData('name', e.target.value)} placeholder="Role name" required />
            <input className={inputClass} list="tx-categories" value={form.data.category} onChange={(e) => form.setData('category', e.target.value)} placeholder="Category" />
            <input type="number" className={`${inputClass} w-20`} value={form.data.sort_order} onChange={(e) => form.setData('sort_order', e.target.value)} />
            <div className="flex items-center gap-2">
                <label className="flex items-center gap-1.5 whitespace-nowrap text-[13px]">
                    <input type="checkbox" checked={form.data.is_active} onChange={(e) => form.setData('is_active', e.target.checked)} />
                    Active
                </label>
                <button type="submit" disabled={form.processing} className="rounded-md bg-ink px-3.5 py-2 text-[13px] font-semibold text-cream disabled:opacity-60">Save</button>
                <button type="button" onClick={onClose} className="rounded-md border border-hairline px-3 py-2 text-[13px] font-semibold text-ink-soft">Cancel</button>
            </div>
            <datalist id="tx-categories">
                {categories.map((c) => <option key={c} value={c} />)}
            </datalist>
        </form>
    );
}

function SubRoleRow({ subRole }) {
    const [editing, setEditing] = useState(false);
    const form = useForm({ name: subRole.name, sort_order: subRole.sort_order, is_active: subRole.is_active });

    const save = (e) => {
        e.preventDefault();
        form.put(`/admin/talent-taxonomy/sub-roles/${subRole.id}`, { preserveScroll: true, onSuccess: () => setEditing(false) });
    };

    const remove = () => {
        if (!confirm(`Delete role "${subRole.name}"?`)) return;
        router.delete(`/admin/talent-taxonomy/sub-roles/${subRole.id}`, { preserveScroll: true });
    };

    const regenerate = () => {
        if (!confirm('Regenerate this link? Any link already sent to a client will stop working.')) return;
        router.post(`/admin/talent-taxonomy/sub-roles/${subRole.id}/token`, {}, { preserveScroll: true });
    };

    if (editing) {
        return (
            <form onSubmit={save} className="flex flex-wrap items-center gap-2 rounded-md bg-cream/50 px-3 py-2">
                <input className={`${inputClass} max-w-xs`} value={form.data.name} onChange={(e) => form.setData('name', e.target.value)} required />
                <input type="number" className={`${inputClass} w-20`} value={form.data.sort_order} onChange={(e) => form.setData('sort_order', e.target.value)} />
                <label className="flex items-center gap-1.5 text-[13px]">
                    <input type="checkbox" checked={form.data.is_active} onChange={(e) => form.setData('is_active', e.target.checked)} />
                    Active
                </label>
                <button type="submit" className="rounded-md bg-ink px-3 py-1.5 text-[12.5px] font-semibold text-cream">Save</button>
                <button type="button" onClick={() => setEditing(false)} className="rounded-md border border-hairline px-3 py-1.5 text-[12.5px] font-semibold text-ink-soft">Cancel</button>
            </form>
        );
    }

    return (
        <div className="flex flex-wrap items-center justify-between gap-2 rounded-md px-3 py-2 hover:bg-cream/60">
            <div className="flex items-center gap-2">
                <span className={`text-[14px] font-medium ${subRole.is_active ? 'text-ink' : 'text-ink-soft line-through'}`}>{subRole.name}</span>
                {!subRole.is_active && <span className="rounded-pill bg-black/5 px-2 py-0.5 text-[10.5px] font-bold uppercase text-ink-soft">Hidden</span>}
            </div>
            <div className="flex items-center gap-1.5">
                <CopyLinkButton url={shareUrl(subRole.share_token)} label="Client link" />
                <button type="button" onClick={regenerate} title="Regenerate link" className="inline-flex h-7 w-7 items-center justify-center rounded-md border border-hairline text-ink-soft hover:border-ink/40 hover:text-ink">
                    <RefreshCw className="h-3.5 w-3.5" />
                </button>
                <button type="button" onClick={() => setEditing(true)} className="rounded-md border border-hairline px-2.5 py-1.5 text-[12.5px] font-semibold text-ink-soft hover:border-ink/40 hover:text-ink">Edit</button>
                <button type="button" onClick={remove} title="Delete" className="inline-flex h-7 w-7 items-center justify-center rounded-md border border-hairline text-[#b23b3b] hover:border-[#b23b3b]/40">
                    <Trash2 className="h-3.5 w-3.5" />
                </button>
            </div>
        </div>
    );
}

function AddSubRole({ roleId }) {
    const form = useForm({ name: '' });

    const submit = (e) => {
        e.preventDefault();
        form.post(`/admin/talent-taxonomy/roles/${roleId}/sub-roles`, {
            preserveScroll: true,
            onSuccess: () => form.reset('name'),
        });
    };

    return (
        <form onSubmit={submit} className="flex items-center gap-2 px-3 pt-2">
            <input
                className={`${inputClass} max-w-xs`}
                value={form.data.name}
                onChange={(e) => form.setData('name', e.target.value)}
                placeholder="Add role (e.g. Bookkeeping)"
                required
            />
            <button type="submit" disabled={form.processing} className="inline-flex items-center gap-1.5 rounded-md border border-hairline px-3 py-2 text-[13px] font-semibold text-ink-soft hover:border-ink/40 hover:text-ink disabled:opacity-60">
                <Plus className="h-3.5 w-3.5" /> Add
            </button>
        </form>
    );
}

function RoleCard({ role, categories }) {
    const [open, setOpen] = useState(false);
    const [editing, setEditing] = useState(false);

    const remove = () => {
        if (!confirm(`Delete industry "${role.name}" and all its roles? Profiles keep their text role title.`)) return;
        router.delete(`/admin/talent-taxonomy/roles/${role.id}`, { preserveScroll: true });
    };

    const regenerate = () => {
        if (!confirm('Regenerate this link? Any link already sent to a client will stop working.')) return;
        router.post(`/admin/talent-taxonomy/roles/${role.id}/token`, {}, { preserveScroll: true });
    };

    return (
        <div className="rounded-lg border border-hairline-soft bg-white">
            <div className="flex flex-wrap items-center justify-between gap-3 p-4">
                <button type="button" onClick={() => setOpen((o) => !o)} className="flex min-w-0 items-center gap-2.5 text-left">
                    <ChevronDown className={`h-4 w-4 shrink-0 text-ink-soft transition-transform ${open ? 'rotate-180' : ''}`} />
                    <span>
                        <span className={`text-[15.5px] font-bold ${role.is_active ? 'text-ink' : 'text-ink-soft line-through'}`}>{role.name}</span>
                        <span className="ml-2 text-[12.5px] text-ink-soft">
                            {role.category && role.category !== role.name && (
                                <span className="rounded-pill bg-sage-soft px-2 py-0.5 font-bold uppercase text-sage-deep">{role.category}</span>
                            )}
                            <span className="ml-2">{role.sub_roles.length} roles · {role.profiles_count} profiles</span>
                        </span>
                    </span>
                </button>
                <div className="flex flex-wrap items-center gap-1.5">
                    <CopyLinkButton url={shareUrl(role.share_token)} label="Client link" />
                    <button type="button" onClick={regenerate} title="Regenerate link" className="inline-flex h-8 w-8 items-center justify-center rounded-md border border-hairline text-ink-soft hover:border-ink/40 hover:text-ink">
                        <RefreshCw className="h-3.5 w-3.5" />
                    </button>
                    <button type="button" onClick={() => setEditing((v) => !v)} className="rounded-md border border-hairline px-3 py-1.5 text-[12.5px] font-semibold text-ink-soft hover:border-ink/40 hover:text-ink">
                        {editing ? 'Close' : 'Edit'}
                    </button>
                    <button type="button" onClick={remove} title="Delete role" className="inline-flex h-8 w-8 items-center justify-center rounded-md border border-hairline text-[#b23b3b] hover:border-[#b23b3b]/40">
                        <Trash2 className="h-3.5 w-3.5" />
                    </button>
                </div>
            </div>

            {editing && <div className="px-4 pb-4"><RoleEditor role={role} categories={categories} onClose={() => setEditing(false)} /></div>}

            <AnimatePresence initial={false}>
                {open && (
                    <motion.div
                        initial={{ height: 0, opacity: 0 }}
                        animate={{ height: 'auto', opacity: 1 }}
                        exit={{ height: 0, opacity: 0 }}
                        transition={{ duration: 0.25 }}
                        className="overflow-hidden border-t border-hairline-soft"
                    >
                        <div className="py-2">
                            {role.sub_roles.length === 0 && <p className="px-3 py-2 text-[13.5px] text-ink-soft">No roles yet.</p>}
                            {role.sub_roles.map((sr) => <SubRoleRow key={sr.id} subRole={sr} />)}
                            <AddSubRole roleId={role.id} />
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>
        </div>
    );
}

export default function TalentTaxonomyIndex({ roles = [], categories = [] }) {
    const [adding, setAdding] = useState(false);
    const form = useForm({ name: '', category: '' });

    const submit = (e) => {
        e.preventDefault();
        form.post('/admin/talent-taxonomy/roles', {
            preserveScroll: true,
            onSuccess: () => { form.reset(); setAdding(false); },
        });
    };

    return (
        <AdminLayout
            title="Talent Taxonomy"
            heading="Talent Taxonomy"
            actions={
                <button type="button" onClick={() => setAdding((v) => !v)} className="inline-flex items-center gap-1.5 rounded-md bg-ink px-3.5 py-2 text-[13.5px] font-semibold text-cream transition-colors hover:bg-ink/90">
                    {adding ? <X className="h-4 w-4" /> : <Plus className="h-4 w-4" strokeWidth={2.4} />}
                    {adding ? 'Cancel' : 'New role'}
                </button>
            }
        >
            <p className="mb-5 max-w-2xl text-[14.5px] leading-relaxed text-ink-soft">
                Industries and the roles inside them. Each has its own private, unguessable client link — an industry link lets the client pick the role themselves, a role link goes straight to those candidates. Regenerate a token to revoke access.
            </p>

            {adding && (
                <form onSubmit={submit} className="mb-5 grid gap-3 rounded-lg border border-hairline-soft bg-white p-4 sm:grid-cols-[2fr_1fr_auto]">
                    <input className={inputClass} value={form.data.name} onChange={(e) => form.setData('name', e.target.value)} placeholder="Role name" required />
                    <input className={inputClass} list="tx-categories-new" value={form.data.category} onChange={(e) => form.setData('category', e.target.value)} placeholder="Category" />
                    <button type="submit" disabled={form.processing} className="rounded-md bg-ink px-5 py-2 text-[13.5px] font-semibold text-cream disabled:opacity-60">Add role</button>
                    <datalist id="tx-categories-new">
                        {categories.map((c) => <option key={c} value={c} />)}
                    </datalist>
                </form>
            )}

            <div className="flex flex-col gap-3">
                {roles.map((role) => <RoleCard key={role.id} role={role} categories={categories} />)}
            </div>
        </AdminLayout>
    );
}
