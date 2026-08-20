import { useCallback, useEffect, useState } from 'react';
import { createPortal } from 'react-dom';
import { AnimatePresence, motion } from 'framer-motion';
import { CalendarDays, Check, X } from 'lucide-react';
import { Calendar } from '@/components/ui/calendar';

/**
 * One interview per shortlisted candidate — each gets their own date, time
 * window and note, because the client meets the candidates individually rather
 * than booking a single call.
 *
 * Emits `schedule` keyed by profile id: { [id]: { date, slots, times, note } }.
 */
const SLOTS = [
    '8:00 AM – 10:00 AM',
    '10:00 AM – 12:00 PM',
    '12:00 PM – 2:00 PM',
    '2:00 PM – 4:00 PM',
    '4:00 PM – 6:00 PM',
];

const ZONES = ['AEST', 'AEDT', 'AWST', 'PHT', 'NZST', 'GMT', 'PST', 'EST'];

const startOfToday = () => {
    const d = new Date();
    d.setHours(0, 0, 0, 0);
    return d;
};

// Local YYYY-MM-DD — toISOString() shifts to UTC and can land on the day before.
const toISODate = (d) => `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;

const asDate = (iso) => (iso ? new Date(`${iso}T00:00:00`) : undefined);

const shortDate = (iso) => asDate(iso).toLocaleDateString('en-AU', { weekday: 'short', day: 'numeric', month: 'short' });

export default function InterviewScheduler({ candidates = [], schedule = {}, onChange, errors = {} }) {
    const [openFor, setOpenFor] = useState(null);
    const [zone, setZone] = useState('AEST');

    const patch = useCallback((id, changes) => {
        onChange({ ...schedule, [id]: { ...(schedule[id] || {}), ...changes } });
    }, [onChange, schedule]);

    // The timezone is one choice for the whole booking, so changing it has to
    // rewrite every slot line that has already been picked.
    const changeZone = (next) => {
        setZone(next);
        const rewritten = { ...schedule };
        Object.keys(rewritten).forEach((id) => {
            const slots = rewritten[id]?.slots ?? [];
            rewritten[id] = { ...rewritten[id], times: slots.length ? `${slots.join(', ')} (${next})` : '' };
        });
        onChange(rewritten);
    };

    const toggleSlot = (id, slot) => {
        const current = schedule[id]?.slots ?? [];
        const slots = current.includes(slot) ? current.filter((s) => s !== slot) : [...current, slot];
        patch(id, { slots, times: slots.length ? `${slots.join(', ')} (${zone})` : '' });
    };

    useEffect(() => {
        const onKey = (e) => e.key === 'Escape' && setOpenFor(null);
        window.addEventListener('keydown', onKey);
        return () => window.removeEventListener('keydown', onKey);
    }, []);

    const openCandidate = candidates.find((c) => c.id === openFor);

    return (
        <div className="grid gap-2.5">
            <div className="flex items-center justify-between gap-3">
                <span className="t-caption text-ink-soft">Interview date &amp; time — one per candidate</span>
                <select
                    aria-label="Timezone"
                    value={zone}
                    onChange={(e) => changeZone(e.target.value)}
                    className="rounded-md border border-hairline bg-white px-2 py-1 text-[12px] font-semibold text-ink-soft outline-none"
                >
                    {ZONES.map((z) => <option key={z} value={z}>{z}</option>)}
                </select>
            </div>

            {candidates.map((c, i) => {
                const row = schedule[c.id] || {};
                const picked = row.slots ?? [];

                return (
                    <div key={c.id} className="rounded-md border border-hairline-soft bg-white/70 p-3">
                        <div className="mb-2 flex flex-wrap items-center gap-2">
                            <span className="flex h-5 w-5 items-center justify-center rounded-full bg-ink text-[11px] font-bold text-cream">{i + 1}</span>
                            <span className="text-[13.5px] font-bold">{c.name}</span>
                            <button
                                type="button"
                                onClick={() => setOpenFor(c.id)}
                                className={`ml-auto inline-flex items-center gap-1.5 rounded-pill border px-3 py-1 text-[12.5px] font-semibold transition-colors ${
                                    row.date ? 'border-ink/25 text-ink' : 'border-hairline text-ink-soft hover:border-ink/40 hover:text-ink'
                                }`}
                            >
                                <CalendarDays className="h-3.5 w-3.5 text-rose-deep" strokeWidth={2.2} />
                                {row.date ? shortDate(row.date) : 'Pick a date'}
                            </button>
                        </div>

                        <div className="flex flex-wrap gap-1.5">
                            {SLOTS.map((slot) => {
                                const on = picked.includes(slot);
                                return (
                                    <button
                                        key={slot}
                                        type="button"
                                        aria-pressed={on}
                                        onClick={() => toggleSlot(c.id, slot)}
                                        className={`inline-flex items-center gap-1 rounded-pill border px-2.5 py-1 text-[11.5px] font-semibold transition-colors ${
                                            on
                                                ? 'border-sage-deep bg-sage-deep text-white'
                                                : 'border-hairline bg-white text-ink-soft hover:border-ink/40 hover:text-ink'
                                        }`}
                                    >
                                        {on && <Check className="h-3 w-3" strokeWidth={3} />}
                                        {slot}
                                    </button>
                                );
                            })}
                        </div>

                        <input
                            className="mt-2 w-full rounded-md border border-hairline bg-white px-3 py-1.5 text-[13px] text-ink outline-none transition-colors focus:border-ink/50"
                            placeholder={`Note for ${c.name.split(' ')[0]} (optional)`}
                            value={row.note ?? ''}
                            onChange={(e) => patch(c.id, { note: e.target.value })}
                        />

                        {(errors[`schedule.${i}.date`] || errors[`schedule.${i}.times`]) && (
                            <p className="mt-1.5 text-[12px] text-[#b23b3b]">
                                {errors[`schedule.${i}.date`] || errors[`schedule.${i}.times`]}
                            </p>
                        )}
                    </div>
                );
            })}

            {errors.schedule && <p className="text-[12.5px] font-semibold text-[#b23b3b]">{errors.schedule}</p>}

            {/* Portalled to <body>: the deck's slides are overflow-hidden and the
                form sits inside animated ancestors, either of which can trap a
                positioned overlay. The single motion root is deliberate — a plain
                wrapper inside AnimatePresence stays mounted after its animated
                children leave, and an invisible full-screen div swallows every
                click on the page. */}
            {typeof document !== 'undefined' && createPortal(
                <AnimatePresence>
                    {openCandidate && (
                        <motion.div
                            key="interview-date"
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            exit={{ opacity: 0 }}
                            transition={{ duration: 0.2 }}
                            className="fixed inset-0 z-[95] flex items-center justify-center p-6"
                        >
                            <div className="absolute inset-0 bg-ink/50" onClick={() => setOpenFor(null)} />
                            <motion.div
                                initial={{ y: 14, scale: 0.97 }}
                                animate={{ y: 0, scale: 1 }}
                                exit={{ y: 10, scale: 0.98 }}
                                transition={{ duration: 0.28, ease: [0.22, 1, 0.36, 1] }}
                                className="relative rounded-lg bg-cream p-4 shadow-float"
                                role="dialog"
                                aria-label={`Choose an interview date for ${openCandidate.name}`}
                            >
                                <div className="mb-3 flex items-center justify-between gap-6">
                                    <p className="t-caption text-ink-soft">Interview with {openCandidate.name}</p>
                                    <button type="button" onClick={() => setOpenFor(null)} aria-label="Close"
                                        className="flex h-7 w-7 items-center justify-center rounded-full border border-hairline text-ink-soft hover:text-ink">
                                        <X className="h-3.5 w-3.5" />
                                    </button>
                                </div>
                                <Calendar
                                    mode="single"
                                    selected={asDate(schedule[openCandidate.id]?.date)}
                                    defaultMonth={asDate(schedule[openCandidate.id]?.date) || startOfToday()}
                                    fromMonth={startOfToday()}
                                    disabled={{ before: startOfToday(), dayOfWeek: [0, 6] }}
                                    weekStartsOn={1}
                                    showOutsideDays={false}
                                    onSelect={(d) => {
                                        patch(openCandidate.id, { date: toISODate(d) });
                                        setOpenFor(null);
                                    }}
                                    footer="Weekends are unavailable for interviews."
                                />
                            </motion.div>
                        </motion.div>
                    )}
                </AnimatePresence>,
                document.body,
            )}
        </div>
    );
}
