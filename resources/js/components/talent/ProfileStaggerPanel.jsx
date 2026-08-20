import { AnimatePresence, motion } from 'framer-motion';
import { Briefcase, Check, GraduationCap, Plus, X } from 'lucide-react';

/**
 * Profile details revealed with StaggeredMenu's choreography — two colour
 * prelayers sweeping in ahead of the panel, then contents staggering up.
 * The vendored StaggeredMenu is a nav component (hamburger + links), so the
 * motion is reproduced here with framer-motion rather than bent out of shape.
 */
const PRELAYERS = [
    { color: 'rgb(var(--c-rose-soft))', delay: 0 },
    { color: 'rgb(var(--c-sage-soft))', delay: 0.07 },
];

const panelEase = [0.22, 1, 0.36, 1];

function Stagger({ children, i = 0 }) {
    return (
        <motion.div
            initial={{ opacity: 0, y: 22 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5, delay: 0.34 + i * 0.055, ease: panelEase }}
        >
            {children}
        </motion.div>
    );
}

export default function ProfileStaggerPanel({ profile, selected, canSelect, onToggle, onClose }) {
    return (
        <AnimatePresence>
            {profile && (
                <div className="fixed inset-0 z-[90]">
                    <motion.div
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        transition={{ duration: 0.3 }}
                        className="absolute inset-0 bg-ink/50"
                        onClick={onClose}
                    />

                    {PRELAYERS.map((layer, i) => (
                        <motion.div
                            key={i}
                            initial={{ x: '100%' }}
                            animate={{ x: `${(i + 1) * 4}%` }}
                            exit={{ x: '100%' }}
                            transition={{ duration: 0.55, delay: layer.delay, ease: panelEase }}
                            className="absolute inset-y-0 right-0 w-full max-w-2xl"
                            style={{ background: layer.color }}
                        />
                    ))}

                    <motion.aside
                        initial={{ x: '100%' }}
                        animate={{ x: 0 }}
                        exit={{ x: '100%' }}
                        transition={{ duration: 0.6, delay: 0.14, ease: panelEase }}
                        className="absolute inset-y-0 right-0 flex w-full max-w-2xl flex-col bg-cream shadow-float"
                    >
                        <div className="flex shrink-0 items-start justify-between gap-4 border-b border-hairline-soft px-7 py-5">
                            <Stagger>
                                <p className="t-eyebrow mb-1.5 text-rose-deep">{profile.category || 'Candidate'}</p>
                                <h2 className="t-display-lg leading-none">{profile.name}</h2>
                                <p className="mt-1.5 text-[14px] text-ink-soft">{profile.role_title}</p>
                            </Stagger>
                            <button
                                type="button"
                                onClick={onClose}
                                className="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-hairline text-ink-soft transition-colors hover:text-ink"
                                aria-label="Close"
                            >
                                <X className="h-4 w-4" />
                            </button>
                        </div>

                        <div className="min-h-0 flex-1 overflow-y-auto px-7 py-6">
                            <div className="flex flex-col gap-6">
                                <Stagger i={1}>
                                    <div className="grid grid-cols-3 gap-2.5">
                                        {[['Rate', profile.rate], ['Preference', profile.work_preference], ['Available', profile.availability]]
                                            .filter(([, v]) => v)
                                            .map(([k, v]) => (
                                                <div key={k} className="rounded-lg border border-hairline-soft bg-white p-3">
                                                    <p className="t-caption text-ink-soft">{k}</p>
                                                    <p className="mt-1 text-[13.5px] font-bold leading-snug text-ink">{v}</p>
                                                </div>
                                            ))}
                                    </div>
                                </Stagger>

                                {profile.about_me && (
                                    <Stagger i={2}>
                                        <p className="text-[15px] leading-relaxed text-ink-soft">{profile.about_me}</p>
                                    </Stagger>
                                )}

                                {(profile.core_skills?.length > 0 || profile.software_expertise?.length > 0) && (
                                    <Stagger i={3}>
                                        <div className="flex flex-wrap gap-1.5">
                                            {(profile.core_skills ?? []).map((s, k) => (
                                                <span key={`c${k}`} className="rounded-pill bg-rose-soft px-3 py-1 text-[12.5px] font-medium text-rose-deep">{s}</span>
                                            ))}
                                            {(profile.software_expertise ?? []).map((s, k) => (
                                                <span key={`s${k}`} className="rounded-pill bg-sage-soft px-3 py-1 text-[12.5px] font-medium text-sage-deep">{s}</span>
                                            ))}
                                        </div>
                                    </Stagger>
                                )}

                                {profile.experience?.length > 0 && (
                                    <Stagger i={4}>
                                        <h3 className="t-card-title mb-3 flex items-center gap-2">
                                            <Briefcase className="h-[17px] w-[17px] text-rose-deep" strokeWidth={2.2} /> Experience
                                        </h3>
                                        <div className="flex flex-col gap-3">
                                            {profile.experience.map((job, k) => (
                                                <div key={k} className="relative rounded-lg border border-hairline-soft bg-white p-4 pl-6">
                                                    <span aria-hidden="true" className="absolute inset-y-4 left-0 w-[3px] rounded-full bg-rose-deep" />
                                                    <div className="flex flex-wrap items-baseline justify-between gap-x-3">
                                                        <p className="font-display text-[15px] font-bold">{job.title}</p>
                                                        {job.period && <span className="t-caption text-ink-soft/70">{job.period}</span>}
                                                    </div>
                                                    <p className="mt-0.5 text-[13px] font-semibold text-rose-deep">{job.company}</p>
                                                    {job.bullets?.length > 0 && (
                                                        <ul className="mt-2 flex flex-col gap-1">
                                                            {job.bullets.slice(0, 4).map((line, li) => (
                                                                <li key={li} className="flex items-start gap-2 text-[13.5px] leading-relaxed text-ink-soft">
                                                                    <span className="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-sage-deep" />{line}
                                                                </li>
                                                            ))}
                                                        </ul>
                                                    )}
                                                </div>
                                            ))}
                                        </div>
                                    </Stagger>
                                )}

                                {profile.education?.length > 0 && (
                                    <Stagger i={5}>
                                        <h3 className="t-card-title mb-3 flex items-center gap-2">
                                            <GraduationCap className="h-[17px] w-[17px] text-sage-deep" strokeWidth={2.2} /> Education
                                        </h3>
                                        <div className="flex flex-col gap-2">
                                            {profile.education.map((edu, k) => (
                                                <div key={k} className="rounded-lg border border-hairline-soft bg-white p-3.5">
                                                    <p className="font-display text-[14.5px] font-bold">{edu.school}</p>
                                                    {edu.degree && <p className="mt-0.5 text-[13px] text-ink-soft">{edu.degree}</p>}
                                                </div>
                                            ))}
                                        </div>
                                    </Stagger>
                                )}
                            </div>
                        </div>

                        <div className="shrink-0 border-t border-hairline-soft bg-white px-7 py-4">
                            <button
                                type="button"
                                onClick={() => onToggle(profile.id)}
                                disabled={!selected && !canSelect}
                                className={`inline-flex w-full items-center justify-center gap-2 rounded-pill px-6 py-3.5 text-[15px] font-semibold transition-colors disabled:cursor-not-allowed disabled:opacity-40 ${
                                    selected ? 'bg-sage-deep text-white' : 'bg-ink text-cream hover:bg-ink/90'
                                }`}
                            >
                                {selected
                                    ? <><Check className="h-4 w-4" strokeWidth={2.6} /> Shortlisted — tap to remove</>
                                    : <><Plus className="h-4 w-4" strokeWidth={2.6} /> Add to shortlist</>}
                            </button>
                        </div>
                    </motion.aside>
                </div>
            )}
        </AnimatePresence>
    );
}
