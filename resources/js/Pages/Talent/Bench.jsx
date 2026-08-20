import { useCallback, useEffect, useMemo, useRef, useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { ThemeProvider, useTheme } from 'next-themes';
import { ArrowLeft, ArrowRight, Check, X } from 'lucide-react';
import ExpandableCards from '@/components/ui/expandable-cards';
import Typeanimation from '@/components/ui/typeanimation';
import ChromaGrid from '@/components/reactbits/ChromaGrid';
import SpecularButton from '@/components/reactbits/SpecularButton';
import SplitText from '@/components/reactbits/SplitText';
import DepthCarousel from '@/components/reactbits/DepthCarousel';
import OptionWheel from '@/components/reactbits/OptionWheel';
import BrandLoader from '@/components/talent/BrandLoader';
import ViewControls from '@/components/talent/ViewControls';
import ProfileStaggerPanel from '@/components/talent/ProfileStaggerPanel';
import InterviewScheduler from '@/components/talent/InterviewScheduler';

const inputClass = 'w-full rounded-md border border-hairline bg-white px-4 py-3 text-[15px] text-ink outline-none transition-colors focus:border-ink/50';

// Brand-tinted specular buttons. baseColor is both the WebGL surface and the
// CSS fallback fill, so the label stays readable even if WebGL doesn't paint.
// These are raw hex (WebGL can't read CSS vars), so each theme needs its own set.
const BUTTONS = {
    light: {
        primary: { baseColor: '#2b2723', lineColor: '#f2dcdd', textColor: '#fdf7ef' },
        ghost: { baseColor: '#ffffff', lineColor: '#c17579', textColor: '#2b2723' },
        sage: { baseColor: '#6f7d5c', lineColor: '#e6e9db', textColor: '#ffffff' },
    },
    dark: {
        primary: { baseColor: '#f5eee6', lineColor: '#c17579', textColor: '#1a1816' },
        ghost: { baseColor: '#2a2724', lineColor: '#e0969a', textColor: '#f5eee6' },
        sage: { baseColor: '#a8b88d', lineColor: '#30362a', textColor: '#1a1816' },
    },
};

const STEP_LABELS = {
    welcome: 'Welcome',
    subrole: 'Role',
    showcase: 'Showcase',
    candidates: 'Candidates',
    shortlist: 'Shortlist',
};

// The wheel paints with color-mix on literal colours, so each theme needs its own.
const WHEEL = {
    light: { textColor: '#b3a99e', activeColor: '#2b2723' },
    dark: { textColor: '#6b6259', activeColor: '#f5eee6' },
};

/**
 * Theme + loader are deliberately scoped to this presentation only. next-themes
 * writes `dark` onto <html>, so the cleanup strips it on unmount — otherwise a
 * client sent on to /book-a-call would drag dark mode across the whole site.
 */
export default function TalentBenchPage(props) {
    useEffect(() => () => {
        document.documentElement.classList.remove('dark');
        document.documentElement.style.colorScheme = '';
    }, []);

    return (
        <ThemeProvider attribute="class" defaultTheme="light" enableSystem={false} storageKey="isla-talent-theme">
            <BrandLoader />
            <TalentBench {...props} />
        </ThemeProvider>
    );
}

function TalentBench({ token, heading, roleName, subRole, subRoles = [], category, profiles: allProfiles = [], minPicks = 3, maxPicks = 5 }) {
    const { resolvedTheme } = useTheme();
    const BTN = BUTTONS[resolvedTheme === 'dark' ? 'dark' : 'light'];
    const [step, setStep] = useState(0);
    const [selected, setSelected] = useState([]);
    const [openId, setOpenId] = useState(null);
    const [extraUnlocked, setExtraUnlocked] = useState(false);
    const [showcaseId, setShowcaseId] = useState(null);
    const [showcasePaused, setShowcasePaused] = useState(false);
    const [autoPlay, setAutoPlay] = useState(true);
    const [subRoleId, setSubRoleId] = useState(null);
    // The BrandLoader covers the first ~1s; start typing only once it clears,
    // otherwise the headline has already half-played by the time it's visible.
    const [introReady, setIntroReady] = useState(false);
    // The wheel anchors its options to one side; on a phone the right anchor
    // pushes long role names off the left edge, so it flips to the left there.
    const [narrow, setNarrow] = useState(false);

    useEffect(() => {
        const mq = window.matchMedia('(max-width: 767px)');
        const sync = () => setNarrow(mq.matches);
        sync();
        mq.addEventListener('change', sync);
        return () => mq.removeEventListener('change', sync);
    }, []);

    useEffect(() => {
        const t = setTimeout(() => setIntroReady(true), 1150);
        return () => clearTimeout(t);
    }, []);

    // A role link covers the whole industry, so the client narrows it to the
    // sub-role they're hiring for. Sub-role links arrive pre-filtered and skip
    // the slide entirely.
    const wheelOptions = useMemo(
        () => (subRoles.length ? [{ id: null, name: 'All candidates', count: allProfiles.length }, ...subRoles] : []),
        [subRoles, allProfiles.length],
    );
    const hasPicker = wheelOptions.length > 1;

    const stepKeys = useMemo(
        () => ['welcome', ...(hasPicker ? ['subrole'] : []), 'showcase', 'candidates', 'shortlist'],
        [hasPicker],
    );
    const S = useMemo(() => Object.fromEntries(stepKeys.map((k, i) => [k, i])), [stepKeys]);

    const profiles = useMemo(
        () => (subRoleId ? allProfiles.filter((p) => p.talent_sub_role_id === subRoleId) : allProfiles),
        [allProfiles, subRoleId],
    );
    const activeSubRole = wheelOptions.find((o) => o.id === subRoleId);

    // The industry is already the eyebrow above the wheel, so repeating it in
    // every option only makes the labels longer than the wheel can show.
    const wheelLabels = useMemo(() => wheelOptions.map((o) => {
        const prefix = `${roleName} `;
        return o.name.toLowerCase().startsWith(prefix.toLowerCase()) ? o.name.slice(prefix.length) : o.name;
    }), [wheelOptions, roleName]);

    // Role names run long ("Construction Cost Estimator | Quantity Surveyor") and
    // the wheel keeps each on one line inside an overflow-hidden box. Measure the
    // widest label against the column it actually has and size the type to fit,
    // rather than guessing from character counts.
    const wheelRef = useRef(null);
    const [wheelFontSize, setWheelFontSize] = useState(1.4);

    const fitWheelFont = useCallback(() => {
        const el = wheelRef.current;
        if (!el || wheelLabels.length === 0) return;

        // The curve pushes off-centre options sideways on top of their own width,
        // so the budget is a little under the column rather than all of it.
        const available = el.clientWidth * 0.93 - 40;
        if (available <= 0) return;

        const canvas = fitWheelFont.canvas || (fitWheelFont.canvas = document.createElement('canvas'));
        const ctx = canvas.getContext('2d');
        const family = getComputedStyle(el).fontFamily;
        // Width scales linearly with size, so one measurement at 100px is enough.
        ctx.font = `200 100px ${family}`;
        const widest = wheelLabels.reduce((n, label) => Math.max(n, ctx.measureText(label).width), 0);
        if (!widest) return;

        const rem = parseFloat(getComputedStyle(document.documentElement).fontSize) || 16;
        const fitted = (available / (widest / 100)) / rem;
        setWheelFontSize(Math.max(0.85, Math.min(2.2, fitted)));
    }, [wheelLabels]);

    // Measured from a ref callback rather than an effect: AnimatePresence holds
    // the slide back until the previous one has finished leaving, so an effect
    // keyed on `step` fires while the wheel is still unmounted.
    const wheelObserver = useRef(null);

    const attachWheel = useCallback((node) => {
        wheelRef.current = node;
        wheelObserver.current?.disconnect();

        if (!node) {
            wheelObserver.current = null;
            return;
        }

        fitWheelFont();
        wheelObserver.current = new ResizeObserver(fitWheelFont);
        wheelObserver.current.observe(node);
    }, [fitWheelFont]);

    useEffect(() => () => wheelObserver.current?.disconnect(), []);

    // Switching sub-role changes who is on offer, so a shortlist built against
    // the previous one has to go.
    const pickSubRole = (id) => {
        setSubRoleId(id);
        setSelected([]);
        setOpenId(null);
        setExtraUnlocked(false);
    };

    const effMin = Math.max(1, Math.min(minPicks, profiles.length));
    const effMax = Math.max(effMin, Math.min(maxPicks, profiles.length));
    const limit = extraUnlocked ? effMax : effMin;
    const canSelect = selected.length < limit;
    const ready = selected.length >= effMin;

    const toggle = (id) => {
        setSelected((prev) => (prev.includes(id) ? prev.filter((x) => x !== id) : prev.length < limit ? [...prev, id] : prev));
    };

    const go = (next) => {
        setAutoPlay(false);
        setStep(next);
    };

    // Plays itself like a deck through the intro, then hands over at Candidates
    // where the client has to choose. Any manual nav cancels it. The showcase
    // step advances itself (below) once its last card has had its turn.
    useEffect(() => {
        if (!autoPlay || step !== S.welcome) return;
        const t = setTimeout(() => setStep(S.welcome + 1), 7200);
        return () => clearTimeout(t);
    }, [autoPlay, step, S]);

    const canGoNext = step < S.candidates || (step === S.candidates && ready);

    const showcase = useMemo(() => profiles.slice(0, narrow ? 3 : 5), [profiles, narrow]);

    useEffect(() => {
        if (!showcase.some((p) => p.id === showcaseId)) setShowcaseId(showcase[0]?.id ?? null);
    }, [showcase, showcaseId]);

    // Auto-advance the showcase so it plays like a presentation reel. Pauses
    // while the visitor is hovering, so their card doesn't get pulled away.
    useEffect(() => {
        if (step !== S.showcase || showcasePaused || showcase.length === 0) return;
        const id = setTimeout(() => {
            const i = showcase.findIndex((p) => p.id === showcaseId);
            // Hand over to Candidates only after the final card has had its own
            // full dwell — a fixed slide timer used to cut the last one short.
            if (i >= showcase.length - 1) {
                if (autoPlay) setStep(S.candidates);
                else setShowcaseId(showcase[0].id);
            } else {
                setShowcaseId(showcase[i + 1].id);
            }
        }, 3200);
        return () => clearTimeout(id);
    }, [step, showcase, showcasePaused, showcaseId, autoPlay, S]);

    const showcaseCards = useMemo(() => showcase.map((p) => ({
        id: p.id,
        content: (
            <div className="relative h-full w-full">
                {p.photo_display_url
                    ? <img src={p.photo_display_url} alt={p.name} className="h-full w-full object-cover" />
                    : <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-rose-soft to-sage-soft"><img src="/butterfly.png" alt="" className="h-12 w-12 opacity-60" /></div>}
                <div className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink/85 to-transparent p-4 pt-10">
                    <p className="font-display text-[15px] font-bold text-cream">{p.name}</p>
                    <p className="text-[12px] text-cream/80">{p.role_title}</p>
                </div>
            </div>
        ),
    })), [showcase]);

    const chromaItems = useMemo(() => profiles.map((p) => {
        const picked = selected.includes(p.id);
        return {
            image: p.photo_display_url || null,
            placeholder: (
                <div className="flex h-full w-full items-center justify-center bg-ink/85">
                    <span className="font-display text-[2.6rem] font-bold text-cream/85">
                        {p.name.trim().charAt(0).toUpperCase()}
                    </span>
                </div>
            ),
            title: p.name,
            subtitle: p.role_title,
            handle: p.rate || '',
            location: p.availability || '',
            borderColor: picked ? '#6f7d5c' : '#c17579',
            gradient: picked ? 'linear-gradient(160deg, #6f7d5c, #2b2723)' : 'linear-gradient(160deg, #c17579, #2b2723)',
            badge: picked ? (
                <span className="pointer-events-none absolute right-3 top-3 z-20 flex h-7 w-7 items-center justify-center rounded-full bg-sage-deep text-white">
                    <Check className="h-4 w-4" strokeWidth={3} />
                </span>
            ) : null,
            profileId: p.id,
        };
    }), [profiles, selected]);


    const form = useForm({
        client_name: '', client_email: '', client_company: '',
        notes: '', selections: [], schedule: [],
    });

    // Keyed by profile id while editing; flattened to a list on submit.
    const [schedule, setSchedule] = useState({});

    const submit = (e) => {
        e.preventDefault();
        form.transform((data) => ({
            ...data,
            selections: selected,
            schedule: selected.map((id) => ({
                profile_id: id,
                date: schedule[id]?.date ?? '',
                times: schedule[id]?.times ?? '',
                note: schedule[id]?.note ?? '',
            })),
        }));
        form.post(`/talent/${token}/shortlist`);
    };

    const selectedProfiles = selected.map((id) => profiles.find((p) => p.id === id)).filter(Boolean);

    // DepthCarousel renders plain <img>, so profiles without a photo fall back
    // to the brand mark rather than a broken image.
    const carouselItems = useMemo(
        () => (selectedProfiles.length ? selectedProfiles : profiles.slice(0, 5)).map((p) => ({
            image: p.photo_display_url || null,
            gradient: 'linear-gradient(160deg, #c17579, #2b2723)',
            label: p.name,
            alt: p.name,
        })),
        // eslint-disable-next-line react-hooks/exhaustive-deps
        [selected, profiles],
    );
    const openProfile = profiles.find((p) => p.id === openId);
    // Every shortlisted candidate needs their own date and at least one window.
    const scheduled = selected.length > 0 && selected.every((id) => schedule[id]?.date && schedule[id]?.times);


    return (
        <div className="flex h-[100dvh] flex-col overflow-hidden bg-cream text-ink">
            <Head>
                <title>{`${heading} — Isla Talent Bench`}</title>
                <meta name="robots" content="noindex, nofollow" />
            </Head>

            {/* ── Minimal header: logo, step dots, view controls ── */}
            <header className="flex shrink-0 items-center justify-between gap-2 px-4 py-3 md:px-7 md:py-4">
                <img src="/logo.png" alt="Isla" className="h-6 w-auto md:h-8" />
                <div className="flex items-center gap-2 md:gap-4">
                    <div className="hidden items-center gap-1.5 sm:flex">
                        {stepKeys.map((key, i) => (
                            <button
                                key={key}
                                type="button"
                                title={STEP_LABELS[key]}
                                aria-label={STEP_LABELS[key]}
                                onClick={() => i <= step && go(i)}
                                disabled={i > step}
                                className={`h-1.5 rounded-full transition-all duration-500 ${
                                    i === step ? 'w-7 bg-ink' : i < step ? 'w-1.5 bg-ink/40 hover:bg-ink/70' : 'w-1.5 bg-ink/15'
                                }`}
                            />
                        ))}
                    </div>
                    <div className="flex items-center gap-1.5">
                        <button
                            type="button"
                            onClick={() => go(Math.max(0, step - 1))}
                            disabled={step === S.welcome}
                            className="inline-flex h-9 w-9 items-center justify-center rounded-full border border-hairline bg-white text-ink-soft transition-colors hover:border-ink/40 hover:text-ink disabled:opacity-35"
                            aria-label="Previous slide"
                        >
                            <ArrowLeft className="h-4 w-4" />
                        </button>
                        <button
                            type="button"
                            onClick={() => canGoNext && go(Math.min(stepKeys.length - 1, step + 1))}
                            disabled={!canGoNext || step === S.shortlist}
                            title={step === S.candidates && !ready ? `Shortlist ${effMin - selected.length} more first` : 'Next'}
                            className="inline-flex h-9 w-9 items-center justify-center rounded-full border border-hairline bg-white text-ink-soft transition-colors hover:border-ink/40 hover:text-ink disabled:opacity-35"
                            aria-label="Next slide"
                        >
                            <ArrowRight className="h-4 w-4" />
                        </button>
                    </div>
                    <button
                        type="button"
                        onClick={() => go(ready ? S.shortlist : S.candidates)}
                        className="hidden rounded-pill bg-ink px-4 py-2 text-[12.5px] font-semibold text-cream transition-opacity hover:opacity-90 sm:inline-flex"
                    >
                        Book interviews
                    </button>
                    <ViewControls />
                </div>
            </header>

            <main className="min-h-0 flex-1 overflow-y-auto md:overflow-hidden">
                <AnimatePresence mode="wait">
                    {/* ── 1. Welcome — plain, title card only ───────── */}
                    {step === S.welcome && (
                        <motion.section
                            key="welcome"
                            initial={{ opacity: 0 }} animate={{ opacity: 1 }} exit={{ opacity: 0 }}
                            transition={{ duration: 0.5 }}
                            className="flex min-h-full md:h-full items-center justify-center px-5 py-8 md:overflow-hidden md:px-8"
                        >
                            <div className="w-full max-w-5xl text-center">
                                <p className="t-eyebrow mb-6 text-rose-deep">{category || 'Isla'}</p>
                                <h1 className="t-display-xl">
                                    Welcome to the{' '}
                                    {introReady ? (
                                        <Typeanimation
                                            words={['Isla Talent Bench..']}
                                            className="bg-gradient-to-r from-rose-deep to-sage-deep bg-clip-text text-transparent"
                                            typingSpeed={60} deletingSpeed={40} pauseDuration={60000}
                                        />
                                    ) : (
                                        <span aria-hidden="true" className="opacity-0">Isla Talent Bench..</span>
                                    )}
                                </h1>
                            </div>
                        </motion.section>
                    )}

                    {/* ── 2. Sub-role — OptionWheel, role links only ── */}
                    {hasPicker && step === S.subrole && (
                        <motion.section
                            key="subrole"
                            initial={{ opacity: 0 }} animate={{ opacity: 1 }} exit={{ opacity: 0 }}
                            transition={{ duration: 0.5 }}
                            className="flex min-h-full md:h-full items-center px-5 py-6 md:overflow-hidden md:px-10"
                        >
                            <div className="mx-auto grid h-full w-full max-w-6xl content-start items-start gap-4 md:content-center md:items-center md:gap-8 md:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)]">
                                <div className="flex min-w-0 flex-col justify-center">
                                    <p className="t-eyebrow mb-3 text-rose-deep">{roleName}</p>
                                    <SplitText
                                        text="Select a role"
                                        tag="h2"
                                        className="t-display-lg"
                                        textAlign="left"
                                        delay={38}
                                        duration={0.9}
                                        splitType="chars"
                                    />
                                    <p className="mt-3 max-w-sm text-[15px] leading-relaxed text-ink-soft">
                                        This link covers our whole {roleName} bench. Spin the wheel to the role
                                        you're hiring for and we'll show only those candidates.
                                    </p>
                                    <p className="mt-5 text-[13.5px] text-ink-soft">
                                        <span className="font-bold text-ink">{profiles.length}</span>
                                        {' '}candidate{profiles.length === 1 ? '' : 's'} in{' '}
                                        <span className="font-bold text-ink">{activeSubRole?.name ?? 'All candidates'}</span>
                                    </p>
                                    <div className="mt-5">
                                        <SpecularButton {...BTN.primary} size="md" disabled={profiles.length === 0}
                                            onClick={() => profiles.length > 0 && go(S.showcase)}>
                                            {profiles.length === 0 ? 'No candidates here yet' : 'Meet the candidates →'}
                                        </SpecularButton>
                                    </div>
                                </div>

                                <div ref={attachWheel} className="talent-wheel h-[32vh] min-h-[200px] min-w-0 md:h-full md:min-h-0 md:py-6">
                                    <OptionWheel
                                        items={wheelLabels}
                                        defaultSelected={0}
                                        side={narrow ? 'left' : 'right'}
                                        fontSize={wheelFontSize}
                                        inset={26}
                                        tilt={7}
                                        onChange={(i) => pickSubRole(wheelOptions[i]?.id ?? null)}
                                        {...WHEEL[resolvedTheme === 'dark' ? 'dark' : 'light']}
                                    />
                                </div>
                            </div>
                        </motion.section>
                    )}

                    {/* ── 2. Showcase — cards only, SplitText heading ─ */}
                    {step === S.showcase && (
                        <motion.section
                            key="showcase"
                            initial={{ opacity: 0 }} animate={{ opacity: 1 }} exit={{ opacity: 0 }}
                            transition={{ duration: 0.5 }}
                            className="flex min-h-full md:h-full flex-col px-4 pb-5 md:overflow-hidden md:px-7 md:pb-7"
                        >
                            <SplitText
                                text="Meet the candidates"
                                tag="h2"
                                className="t-display-lg mb-5 shrink-0"
                                textAlign="center"
                                delay={38}
                                duration={0.9}
                                splitType="chars"
                            />
                            <div
                                className="h-[58vh] min-h-[320px] md:h-auto md:min-h-0 md:flex-1"
                                onMouseEnter={() => setShowcasePaused(true)}
                                onMouseLeave={() => setShowcasePaused(false)}
                            >
                                <ExpandableCards
                                    cards={showcaseCards}
                                    expandedId={showcaseId}
                                    onExpandedChange={setShowcaseId}
                                    transitionDuration={0.85}
                                />
                            </div>
                        </motion.section>
                    )}

                    {/* ── 3. Candidates — grid only ─────────────────── */}
                    {step === S.candidates && (
                        <motion.section
                            key="candidates"
                            initial={{ opacity: 0 }} animate={{ opacity: 1 }} exit={{ opacity: 0 }}
                            transition={{ duration: 0.5 }}
                            className="flex min-h-full md:h-full flex-col px-4 pb-5 md:px-7"
                        >
                            {profiles.length === 0 ? (
                                <div className="flex min-h-0 flex-1 items-center justify-center text-[15px] text-ink-soft">
                                    No candidates are listed here yet — please check back with your Isla contact.
                                </div>
                            ) : (
                                <div className="talent-grid min-h-0 flex-1 overflow-y-auto py-1">
                                    <ChromaGrid
                                        items={chromaItems}
                                        columns={Math.min(3, chromaItems.length)}
                                        rows={Math.ceil(chromaItems.length / 3)}
                                        radius={340}
                                        onCardClick={(c) => setOpenId(c.profileId)}
                                    />
                                </div>
                            )}

                            {/* one slim bar so nothing competes with the grid */}
                            {profiles.length > 0 && (
                            <div className="sticky bottom-0 z-10 mt-4 flex shrink-0 flex-wrap items-center justify-between gap-3 bg-cream/95 py-2 backdrop-blur md:static md:bg-transparent md:py-0 md:backdrop-blur-none">
                                <span className="text-[12.5px] text-ink-soft">Tap a card for the full profile</span>
                                <div className="flex items-center gap-3">
                                    <span className="text-[13px] text-ink-soft">
                                        <span className="font-bold text-ink">{selected.length}</span> of {limit} shortlisted
                                    </span>
                                    <SpecularButton {...BTN.primary} size="sm" disabled={!ready} onClick={() => ready && go(S.shortlist)}>
                                        {ready ? 'Book interviews →' : `Pick ${effMin - selected.length} more`}
                                    </SpecularButton>
                                </div>
                            </div>
                            )}
                        </motion.section>
                    )}

                    {/* ── 4. Shortlist — depth carousel + booking ───── */}
                    {step === S.shortlist && (
                        <motion.section
                            key="shortlist"
                            initial={{ opacity: 0 }} animate={{ opacity: 1 }} exit={{ opacity: 0 }}
                            transition={{ duration: 0.5 }}
                            className="flex min-h-full md:h-full flex-col px-4 pb-6 md:overflow-hidden md:px-7"
                        >
                            <div className="mx-auto grid h-full min-h-0 w-full max-w-6xl gap-5 md:gap-6 lg:grid-cols-2">
                                <div className="flex min-h-0 flex-col items-center justify-center">
                                    <DepthCarousel
                                        items={carouselItems}
                                        cardWidth={220}
                                        cardHeight={290}
                                        autoplay
                                        autoplayDelay={2800}
                                        showControls={false}
                                        showIndicators={false}
                                        tint={resolvedTheme === 'dark' ? '#1a1816' : '#2b2723'}
                                    />
                                    <div className="mt-3 flex flex-wrap justify-center gap-1.5">
                                        {selectedProfiles.map((p, i) => (
                                            <span key={p.id} className="inline-flex items-center gap-1.5 rounded-pill bg-white px-3 py-1 text-[12.5px] shadow-sm">
                                                <span className="flex h-4 w-4 items-center justify-center rounded-full bg-ink text-[10px] font-bold text-cream">{i + 1}</span>
                                                <span className="font-semibold">{p.name}</span>
                                                <button type="button" onClick={() => toggle(p.id)} className="text-ink-soft hover:text-[#b23b3b]" aria-label={`Remove ${p.name}`}>
                                                    <X className="h-3 w-3" />
                                                </button>
                                            </span>
                                        ))}
                                        {!extraUnlocked && effMax > effMin && (
                                            <button type="button" onClick={() => { setExtraUnlocked(true); go(S.candidates); }}
                                                className="rounded-pill border border-hairline px-3 py-1 text-[12.5px] font-semibold text-ink-soft hover:border-ink/40 hover:text-ink">
                                                + add {effMax - effMin} more
                                            </button>
                                        )}
                                    </div>
                                </div>

                                <form onSubmit={submit} className="flex min-h-0 flex-col gap-3 overflow-y-auto py-2 pr-1">
                                    <div className="shrink-0">
                                        <p className="t-eyebrow mb-1.5 text-rose-deep">Almost there</p>
                                        <h2 className="t-display-lg">Book your interviews</h2>
                                        <p className="mt-1.5 text-[14px] text-ink-soft">
                                            Pick when you'd like to meet each candidate — we'll confirm against their availability.
                                        </p>
                                    </div>
                                    <div className="grid gap-3 sm:grid-cols-2">
                                        <div className="grid gap-1.5">
                                            <label htmlFor="client_name" className="t-caption text-ink-soft">Your name</label>
                                            <input id="client_name" className={inputClass} value={form.data.client_name} onChange={(e) => form.setData('client_name', e.target.value)} required />
                                            {form.errors.client_name && <span className="text-[12.5px] text-[#b23b3b]">{form.errors.client_name}</span>}
                                        </div>
                                        <div className="grid gap-1.5">
                                            <label htmlFor="client_email" className="t-caption text-ink-soft">Email</label>
                                            <input id="client_email" type="email" className={inputClass} value={form.data.client_email} onChange={(e) => form.setData('client_email', e.target.value)} required />
                                            {form.errors.client_email && <span className="text-[12.5px] text-[#b23b3b]">{form.errors.client_email}</span>}
                                        </div>
                                    </div>
                                    <div className="grid gap-1.5">
                                        <label htmlFor="client_company" className="t-caption text-ink-soft">Business (optional)</label>
                                        <input id="client_company" className={inputClass} value={form.data.client_company} onChange={(e) => form.setData('client_company', e.target.value)} />
                                    </div>
                                    <InterviewScheduler
                                        candidates={selectedProfiles}
                                        schedule={schedule}
                                        onChange={setSchedule}
                                        errors={form.errors}
                                    />
                                    <div className="grid gap-1.5">
                                        <label htmlFor="notes" className="t-caption text-ink-soft">Anything else (optional)</label>
                                        <textarea id="notes" rows={2} className={inputClass} value={form.data.notes} onChange={(e) => form.setData('notes', e.target.value)} placeholder="Who else joins the call, context on the role…" />
                                    </div>
                                    {form.errors.selections && <p className="text-[13.5px] font-semibold text-[#b23b3b]">{form.errors.selections}</p>}
                                    <div className="flex flex-wrap items-center gap-3">
                                        <SpecularButton {...BTN.ghost} size="sm" onClick={() => go(S.candidates)}>← Back</SpecularButton>
                                        <SpecularButton {...BTN.primary} size="md" type="submit" disabled={!ready || !scheduled || form.processing}>
                                            {form.processing ? 'Sending…' : scheduled ? 'Confirm & book interviews' : 'Set a date & time for each'}
                                        </SpecularButton>
                                    </div>
                                </form>
                            </div>
                        </motion.section>
                    )}
                </AnimatePresence>
            </main>

            <ProfileStaggerPanel
                profile={openProfile}
                selected={openProfile ? selected.includes(openProfile.id) : false}
                canSelect={canSelect}
                onToggle={(id) => { toggle(id); setOpenId(null); }}
                onClose={() => setOpenId(null)}
            />
        </div>
    );
}
