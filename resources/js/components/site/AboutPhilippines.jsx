import { useState } from 'react';
import { usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { Plus } from 'lucide-react';
import SectionHead from '@/components/site/SectionHead';
import { makeSetting } from '@/lib/utils';

/**
 * AboutPhilippines — accordion section explaining why Isla builds teams
 * in the Philippines. Heading copy is admin-editable (Settings → About the
 * Philippines); the six items below are fixed content, edit them here.
 *
 * The right-hand panel follows whichever item is open, showing a single
 * figure over the butterfly print — same motif as ButterflyBackdrop.
 */

const ITEMS = [
    {
        id: 'always-on',
        title: '24/7 culture',
        figure: '2 hrs',
        figureLabel: 'behind Sydney — three once daylight saving starts',
        body: [
            'Round-the-clock work is ordinary here, not an exception. Manila sits two hours behind Sydney, so your assistant is already at their desk before your morning stand-up rather than catching up to it.',
            'Night and split shifts have been part of the local industry for two decades, so after-hours inbox cover or a rostered weekend is a normal arrangement to set up, not a favour to negotiate.',
        ],
    },
    {
        id: 'english',
        title: 'English proficiency',
        figure: '2nd',
        figureLabel: 'highest English proficiency in Asia (EF EPI 2025)',
        body: [
            'English is an official language and the medium of instruction for maths, science and technology from the early years of school. The Philippines placed second in Asia in the 2025 EF English Proficiency Index, inside the high-proficiency band.',
            'In practice that means your assistant writes client emails, takes calls and joins video meetings without anything getting lost on the way through.',
        ],
    },
    {
        id: 'education',
        title: 'Education',
        figure: '~800k',
        figureLabel: 'graduates a year, from roughly 2,000 colleges and universities',
        body: [
            'The country produces close to 800,000 graduates a year, with deep pipelines in business, accounting, IT and administration — the exact backgrounds most Australian teams are hiring for.',
            'We still hire for the role rather than the diploma. The depth simply means we can hold out for someone who has actually done the work before, instead of settling on whoever is available.',
        ],
    },
    {
        id: 'cost',
        title: 'Cost of living',
        figure: 'Full-time',
        figureLabel: 'for what part-time local support usually costs',
        body: [
            'A salary that is genuinely competitive in Manila costs a fraction of the Australian equivalent, because the cost of living behind it is lower — not because anyone is being underpaid.',
            'The practical difference for you: a dedicated person on your team full-time, for roughly what a few hours a week of local contracting would run to.',
        ],
    },
    {
        id: 'fit',
        title: 'Cultural fit',
        figure: '20+ yrs',
        figureLabel: 'of Philippine teams supporting Australian businesses',
        body: [
            'Australian business habits are familiar ground — AEST calendars, Australian spelling and tone, Xero and MYOB, and the kind of short written update most Australian owners actually want.',
            'It shows up in the small things: no explaining what EOFY is, no translating your shorthand, no three-day lag on a question that needed a same-day answer.',
        ],
    },
    {
        id: 'care',
        title: 'Culture of care and friendliness',
        figure: 'Malasakit',
        figureLabel: 'the Filipino word for treating the work as if it were your own',
        body: [
            'There is a word here for looking after something because you care about it, not because you were told to. It is the trait we screen hardest for, and it is why clients tend to keep the same assistant for years rather than months.',
            'Our side of that bargain is proper employment, real benefits and account management that checks in — so staying is easy, and you are not rehiring every nine months.',
        ],
    },
];

export default function AboutPhilippines() {
    const setting = makeSetting(usePage().props?.settings);
    const [openId, setOpenId] = useState(ITEMS[0].id);
    const active = ITEMS.find((item) => item.id === openId) ?? ITEMS[0];

    return (
        <section className="section-tight">
            <div className="container-site">
                <SectionHead
                    eyebrow={setting('ph_eyebrow', 'About the Philippines')}
                    eyebrowColor="text-sage-deep"
                    heading={setting('ph_heading', 'Why we build every team in one country')}
                    intro={setting(
                        'ph_intro',
                        'Isla hires in the Philippines on purpose. Here is what that actually gives an Australian business.',
                    )}
                />

                <div className="grid gap-10 lg:grid-cols-[1.08fr_0.92fr] lg:gap-14">
                    {/* ── accordion ─────────────────────────────── */}
                    <div>
                        {ITEMS.map((item) => {
                            const isOpen = item.id === openId;

                            return (
                                <div
                                    key={item.id}
                                    className="border-t border-hairline-soft first:border-t-0"
                                >
                                    <h3>
                                        <button
                                            type="button"
                                            id={`ph-trigger-${item.id}`}
                                            aria-expanded={isOpen}
                                            aria-controls={`ph-panel-${item.id}`}
                                            onClick={() => setOpenId(isOpen ? null : item.id)}
                                            className={`flex w-full items-center justify-between gap-6 py-5 text-left transition-colors ${
                                                isOpen ? 'text-rose-deep' : 'text-ink hover:text-rose-deep'
                                            }`}
                                        >
                                            <span className="t-card-title">{item.title}</span>
                                            <span
                                                aria-hidden="true"
                                                className={`flex h-9 w-9 shrink-0 items-center justify-center rounded-full transition-all duration-300 ${
                                                    isOpen
                                                        ? 'rotate-45 bg-rose-deep text-cream'
                                                        : 'bg-rose-soft text-rose-deep'
                                                }`}
                                            >
                                                <Plus className="h-[15px] w-[15px]" strokeWidth={2.4} />
                                            </span>
                                        </button>
                                    </h3>

                                    {/* grid-rows animation — no height measuring needed */}
                                    <div
                                        id={`ph-panel-${item.id}`}
                                        role="region"
                                        aria-labelledby={`ph-trigger-${item.id}`}
                                        className="grid transition-[grid-template-rows] duration-300 ease-out motion-reduce:transition-none"
                                        style={{ gridTemplateRows: isOpen ? '1fr' : '0fr' }}
                                    >
                                        <div className="overflow-hidden">
                                            <div className="pb-6 md:pr-10">
                                                {item.body.map((paragraph, i) => (
                                                    <p
                                                        key={i}
                                                        className={`text-[15px] leading-relaxed text-ink-soft ${i > 0 ? 'mt-3' : ''}`}
                                                    >
                                                        {paragraph}
                                                    </p>
                                                ))}

                                                {/* figure shown inline where the side panel is hidden */}
                                                <p className="mt-5 flex flex-wrap items-baseline gap-x-3 gap-y-1 lg:hidden">
                                                    <span className="font-display text-2xl font-medium text-rose-deep">
                                                        {item.figure}
                                                    </span>
                                                    <span className="t-body-sm text-ink-soft">
                                                        {item.figureLabel}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            );
                        })}
                    </div>

                    {/* ── figure panel, follows the open item ───── */}
                    <aside className="hidden lg:block">
                        <div className="sticky top-28">
                            <div className="relative overflow-hidden rounded-xl bg-gradient-to-br from-rose to-rose-deep p-10 text-cream shadow-float">
                                <img
                                    src="/butterfly.png"
                                    alt=""
                                    aria-hidden="true"
                                    draggable="false"
                                    className="pointer-events-none absolute -bottom-10 -right-8 w-60 select-none opacity-[0.16]"
                                />

                                <div className="relative min-h-[210px]" aria-live="polite">
                                    <AnimatePresence mode="wait">
                                        <motion.div
                                            key={active.id}
                                            initial={{ opacity: 0, y: 10 }}
                                            animate={{ opacity: 1, y: 0 }}
                                            exit={{ opacity: 0, y: -10 }}
                                            transition={{ duration: 0.26 }}
                                        >
                                            <p className="t-eyebrow text-cream/70">{active.title}</p>
                                            <p className="t-display-lg mt-6">{active.figure}</p>
                                            <p className="mt-4 max-w-xs leading-relaxed text-cream/85">
                                                {active.figureLabel}
                                            </p>
                                        </motion.div>
                                    </AnimatePresence>
                                </div>

                                <div className="relative mt-8 border-t border-on-inverse-soft pt-6">
                                    <p className="t-body-sm text-cream/85">
                                        Every Isla professional is employed locally, paid properly and
                                        managed day to day. You get the person; we carry the
                                        infrastructure behind them.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    );
}
