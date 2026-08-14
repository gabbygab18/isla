import { useMemo, useState } from 'react';
import { usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { ArrowRight, Calculator, Check, Plus, Users, X } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import AnimatedTabs from '@/components/scrollxui/AnimatedTabs';
import Select from '@/components/scrollxui/Select';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import CtaBand from '@/components/site/CtaBand';
import PageHero from '@/components/site/PageHero';
import PricingGrid from '@/components/site/PricingGrid';
import SectionHead from '@/components/site/SectionHead';
import TrustBar from '@/components/site/TrustBar';
import { cn, makeSetting } from '@/lib/utils';

/* ── same math as the Blade estimator ─────────────────────────── */
const EXP_MULT = { junior: 0.85, intermediate: 1.0, senior: 1.3 };
const SETUP_MULT = { home: 1.0, hybrid: 1.08, office: 1.18 };
const CURRENCY = {
    AUD: { sym: 'A$', fx: 1.0, label: 'Australian Dollar (AUD)' },
    USD: { sym: 'US$', fx: 0.66, label: 'US Dollar (USD)' },
    NZD: { sym: 'NZ$', fx: 1.08, label: 'New Zealand Dollar (NZD)' },
};
const HOURS_WEEK = 38;
const WEEKS_MONTH = 4.33;

const EXPERIENCE = [
    { value: 'junior', label: 'Junior' },
    { value: 'intermediate', label: 'Intermediate' },
    { value: 'senior', label: 'Senior' },
];
const SETUPS = [
    { value: 'home', label: 'Home-based' },
    { value: 'hybrid', label: 'Hybrid' },
    { value: 'office', label: 'Office-based' },
];
const CURRENCY_OPTIONS = Object.entries(CURRENCY).map(([value, c]) => ({ value, label: c.label }));

const money = (sym, n) => sym + Math.round(n).toLocaleString('en-AU');

function makeCalc(services, calc) {
    const islaHourly = (catIdx, exp, setup) =>
        (services[catIdx]?.rate ?? 13) * EXP_MULT[exp] * SETUP_MULT[setup];
    const localHourly = (exp) => calc.localRate * EXP_MULT[exp];

    return function costsFor(catIdx, exp, setup, view = 'monthly', qty = 1) {
        const hIsla = islaHourly(catIdx, exp, setup);
        const hLocal = localHourly(exp);
        const mIsla = hIsla * HOURS_WEEK * WEEKS_MONTH; // one inclusive hourly rate — no separate fee
        const mLocal = hLocal * HOURS_WEEK * WEEKS_MONTH * 1.25; // + super/leave/overheads
        if (view === 'hourly') return { isla: (mIsla / (HOURS_WEEK * WEEKS_MONTH)) * qty, local: hLocal * 1.25 * qty, hIsla };
        if (view === 'annual') return { isla: mIsla * 12 * qty, local: mLocal * 12 * qty, hIsla };
        return { isla: mIsla * qty, local: mLocal * qty, hIsla };
    };
}

function CompareResult({ cur, result, per, brand, disclaimer, breakdown }) {
    return (
        <motion.div initial={{ opacity: 0, y: 18 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.45 }}>
            <div className="grid items-center gap-4 md:grid-cols-[1fr_auto_1fr]">
                <div className="rounded-lg border border-hairline-soft bg-white p-6 text-center">
                    <p className="t-caption opacity-60">Typical local hire</p>
                    <p className="mt-2 font-display text-[clamp(1.7rem,3vw,2.4rem)] font-medium tracking-tight text-ink-soft line-through decoration-rose-deep/60">
                        {money(cur.sym, result.local * cur.fx)}
                    </p>
                    <p className="t-body-sm opacity-60">{per}</p>
                </div>
                <span aria-hidden="true" className="t-caption text-center text-ink-soft">vs</span>
                <div className="rounded-lg bg-ink p-6 text-center text-cream">
                    <p className="t-caption text-rose">With {brand}</p>
                    <p className="mt-2 font-display text-[clamp(1.7rem,3vw,2.4rem)] font-medium tracking-tight">
                        {money(cur.sym, result.isla * cur.fx)}
                    </p>
                    <p className="t-body-sm opacity-70">{per}, all-inclusive</p>
                </div>
            </div>

            <div className="mt-5 inline-flex items-center gap-2.5 rounded-pill bg-sage-soft px-5 py-3 text-[14.5px] font-semibold text-sage-deep">
                <Check className="h-4 w-4" strokeWidth={2.6} />
                <span>
                    Indicative difference of <strong>{money(cur.sym, (result.local - result.isla) * cur.fx)}</strong> {per} vs a typical local hire
                </span>
            </div>

            {breakdown && (
                <ul className="mt-6 flex flex-col divide-y divide-hairline-soft rounded-lg border border-hairline-soft bg-white">
                    {breakdown.map(([label, value], i) => (
                        <li key={i} className="flex items-center justify-between gap-4 px-5 py-3.5 text-[14.5px]">
                            <span className="text-ink-soft">{label}</span>
                            <strong className="text-right">{value}</strong>
                        </li>
                    ))}
                </ul>
            )}

            <p className="mt-5 text-[12.5px] leading-relaxed text-ink-soft">{disclaimer}</p>
            <StaggerButton href="/book-a-call" iconRight={ArrowRight} className="mt-5 w-full">
                Book a Free Consultation
            </StaggerButton>
        </motion.div>
    );
}

const emptyRow = () => ({ cat: '', role: '', exp: 'intermediate', setup: 'home', qty: 1 });

export default function CostEstimator({ pricingPlans = [], services = [], calc = { localRate: 42 } }) {
    const setting = makeSetting(usePage().props?.settings);
    const brand = setting('brand_word', 'Isla');
    const disclaimer = setting(
        'calc_disclaimer',
        'Indicative only, based on one inclusive hourly rate determined by role, experience level, working hours and service requirements, with illustrative exchange rates and local salary benchmarks. Your discovery call confirms an exact, written quote for your role and sector.',
    );

    const costsFor = useMemo(() => makeCalc(services, calc), [services, calc]);
    const categoryOptions = services.map((s, i) => ({ value: String(i), label: s.title }));

    const [tab, setTab] = useState('single');

    /* single-role state */
    const [sCurrency, setSCurrency] = useState('AUD');
    const [sCat, setSCat] = useState('');
    const [sRole, setSRole] = useState('');
    const [sExp, setSExp] = useState('intermediate');
    const [sSetup, setSSetup] = useState('home');
    const [sView, setSView] = useState('monthly');

    /* team state */
    const [tCurrency, setTCurrency] = useState('AUD');
    const [rows, setRows] = useState([emptyRow()]);

    const singleReady = sCat !== '' && sRole !== '';
    const sCur = CURRENCY[sCurrency];
    const sResult = singleReady ? costsFor(parseInt(sCat, 10), sExp, sSetup, sView) : null;
    const per = sView === 'hourly' ? 'per hour' : sView === 'annual' ? 'per year' : 'per month';

    const tCur = CURRENCY[tCurrency];
    const teamTotals = rows.reduce(
        (acc, row) => {
            if (row.cat === '' || row.role === '') return acc;
            const c = costsFor(parseInt(row.cat, 10), row.exp, row.setup, 'monthly', Number(row.qty));
            return { isla: acc.isla + c.isla, local: acc.local + c.local, any: true };
        },
        { isla: 0, local: 0, any: false },
    );

    const updateRow = (i, patch) => setRows(rows.map((row, j) => (j === i ? { ...row, ...patch } : row)));

    return (
        <SiteLayout title="Cost Estimator" description={setting('calc_intro', 'See your potential savings with a dedicated Isla assistant — by role, experience level, and work setup.')}>
            <PageHero
                crumbs={[{ label: 'Cost Estimator' }]}
                eyebrow={setting('calc_eyebrow', 'Cost estimator')}
                heading={setting('calc_heading', 'What would a dedicated assistant cost you?')}
                lede={setting('calc_intro', 'Pick a role, experience level, and work setup for an indicative figure — no email required. Your discovery call gets you an exact, written quote.')}
            />

            <section className="pb-4 pt-6">
                <div className="container-site">
                    {/* scrollxui: animated-tabs */}
                    <div className="mb-8 flex justify-center">
                        <AnimatedTabs
                            layoutId="estimator-tabs"
                            active={tab}
                            onChange={setTab}
                            tabs={[
                                { value: 'single', label: 'Single Role' },
                                { value: 'team', label: 'Build Your Team', icon: Users },
                            ]}
                        />
                    </div>

                    <AnimatePresence mode="wait">
                        {tab === 'single' ? (
                            <motion.div
                                key="single"
                                initial={{ opacity: 0, y: 16 }}
                                animate={{ opacity: 1, y: 0 }}
                                exit={{ opacity: 0, y: -10 }}
                                transition={{ duration: 0.3 }}
                                className="grid gap-10 rounded-lg border border-hairline-soft bg-white p-7 md:grid-cols-2 md:p-10"
                            >
                                {/* controls — scrollxui select */}
                                <div className="flex flex-col gap-5">
                                    <div>
                                        <label className="t-caption mb-2.5 block text-ink-soft">Currency</label>
                                        <Select value={sCurrency} onChange={setSCurrency} options={CURRENCY_OPTIONS} />
                                    </div>
                                    <div>
                                        <label className="t-caption mb-2.5 block text-ink-soft">Role Category</label>
                                        <Select
                                            value={sCat}
                                            onChange={(v) => { setSCat(v); setSRole(''); }}
                                            options={categoryOptions}
                                            placeholder="Select category"
                                        />
                                    </div>
                                    <div>
                                        <label className="t-caption mb-2.5 block text-ink-soft">Role</label>
                                        <Select
                                            value={sRole}
                                            onChange={setSRole}
                                            options={sCat !== '' ? services[parseInt(sCat, 10)]?.roles ?? [] : []}
                                            placeholder="Select role"
                                            disabled={sCat === ''}
                                        />
                                    </div>
                                    <div>
                                        <label className="t-caption mb-2.5 block text-ink-soft">Experience Level</label>
                                        <Select value={sExp} onChange={setSExp} options={EXPERIENCE} />
                                    </div>
                                    <div>
                                        <label className="t-caption mb-2.5 block text-ink-soft">Work Setup</label>
                                        <Select value={sSetup} onChange={setSSetup} options={SETUPS} />
                                    </div>
                                    <div>
                                        <label className="t-caption mb-2.5 block text-ink-soft">View By</label>
                                        <div className="inline-flex gap-1 rounded-pill border border-hairline-soft bg-cream p-1">
                                            {['hourly', 'monthly', 'annual'].map((view) => (
                                                <button
                                                    key={view}
                                                    type="button"
                                                    onClick={() => setSView(view)}
                                                    className={cn(
                                                        'rounded-pill px-5 py-2 text-[13.5px] font-semibold capitalize transition-colors',
                                                        sView === view ? 'bg-ink text-cream' : 'text-ink-soft hover:text-ink',
                                                    )}
                                                >
                                                    {view}
                                                </button>
                                            ))}
                                        </div>
                                    </div>
                                </div>

                                {/* result */}
                                <div>
                                    {!singleReady ? (
                                        <div className="flex h-full flex-col items-center justify-center gap-5 rounded-lg bg-cream px-8 py-14 text-center">
                                            <Calculator className="h-14 w-14 opacity-30" strokeWidth={1.6} />
                                            <p className="t-body-lg opacity-70">Select a role category and role to see your potential savings</p>
                                            <p className="t-body-sm opacity-55">Have questions? Let's talk!</p>
                                            <StaggerButton href="/book-a-call" iconRight={ArrowRight}>
                                                Book a Free Consultation
                                            </StaggerButton>
                                        </div>
                                    ) : (
                                        <CompareResult
                                            cur={sCur}
                                            result={sResult}
                                            per={per}
                                            brand={brand}
                                            disclaimer={disclaimer}
                                            breakdown={[
                                                ['Role', `${sRole} · ${EXPERIENCE.find((e) => e.value === sExp)?.label} · ${SETUPS.find((s) => s.value === sSetup)?.label}`],
                                                ['Inclusive hourly rate', `${money(sCur.sym, sResult.hIsla * sCur.fx)} / hr`],
                                                ['Basis', '38 hrs / week, Australian-aligned schedule'],
                                                ['Includes', 'Recruitment, onboarding, payroll, HR, account management, equipment & IT'],
                                            ]}
                                        />
                                    )}
                                </div>
                            </motion.div>
                        ) : (
                            <motion.div
                                key="team"
                                initial={{ opacity: 0, y: 16 }}
                                animate={{ opacity: 1, y: 0 }}
                                exit={{ opacity: 0, y: -10 }}
                                transition={{ duration: 0.3 }}
                                className="rounded-lg border border-hairline-soft bg-white p-7 md:p-10"
                            >
                                <h2 className="t-headline flex items-center gap-3">
                                    <Users className="h-7 w-7" strokeWidth={2} /> Build Your Team
                                </h2>
                                <p className="mt-1.5 opacity-70">Add multiple roles to see your total team cost savings</p>

                                <div className="mt-6 max-w-sm">
                                    <label className="t-caption mb-2.5 block text-ink-soft">Currency</label>
                                    <Select value={tCurrency} onChange={setTCurrency} options={CURRENCY_OPTIONS} />
                                </div>

                                <div className="mt-6 flex flex-col gap-4">
                                    {rows.map((row, i) => (
                                        <div key={i} className="grid items-end gap-4 rounded-lg bg-cream p-5 md:grid-cols-[1.2fr_1.2fr_1fr_1fr_0.6fr_auto]">
                                            <div>
                                                <label className="t-caption mb-2 block text-ink-soft">Role Category</label>
                                                <Select
                                                    value={row.cat}
                                                    onChange={(v) => updateRow(i, { cat: v, role: '' })}
                                                    options={categoryOptions}
                                                    placeholder="Select category"
                                                />
                                            </div>
                                            <div>
                                                <label className="t-caption mb-2 block text-ink-soft">Role</label>
                                                <Select
                                                    value={row.role}
                                                    onChange={(v) => updateRow(i, { role: v })}
                                                    options={row.cat !== '' ? services[parseInt(row.cat, 10)]?.roles ?? [] : []}
                                                    placeholder="Select role"
                                                    disabled={row.cat === ''}
                                                />
                                            </div>
                                            <div>
                                                <label className="t-caption mb-2 block text-ink-soft">Experience</label>
                                                <Select value={row.exp} onChange={(v) => updateRow(i, { exp: v })} options={EXPERIENCE} />
                                            </div>
                                            <div>
                                                <label className="t-caption mb-2 block text-ink-soft">Work Setup</label>
                                                <Select value={row.setup} onChange={(v) => updateRow(i, { setup: v })} options={SETUPS} />
                                            </div>
                                            <div>
                                                <label className="t-caption mb-2 block text-ink-soft">Quantity</label>
                                                <Select value={String(row.qty)} onChange={(v) => updateRow(i, { qty: Number(v) })} options={['1', '2', '3', '4', '5']} />
                                            </div>
                                            <button
                                                type="button"
                                                aria-label="Remove teammate"
                                                onClick={() => rows.length > 1 && setRows(rows.filter((_, j) => j !== i))}
                                                className="mb-1 flex h-10 w-10 items-center justify-center rounded-full border border-hairline text-ink-soft transition-colors hover:border-rose-deep hover:text-rose-deep"
                                            >
                                                <X className="h-4 w-4" strokeWidth={2.2} />
                                            </button>
                                        </div>
                                    ))}
                                </div>

                                <button
                                    type="button"
                                    onClick={() => setRows([...rows, emptyRow()])}
                                    className="mt-5 inline-flex items-center gap-2 rounded-pill border border-hairline bg-white px-6 py-3 text-[14.5px] font-semibold transition-colors hover:border-ink"
                                >
                                    <Plus className="h-4 w-4" strokeWidth={2.4} /> Add Another Teammate
                                </button>

                                {teamTotals.any && (
                                    <div className="mt-8">
                                        <CompareResult
                                            cur={tCur}
                                            result={teamTotals}
                                            per="per month"
                                            brand={brand}
                                            disclaimer={disclaimer}
                                        />
                                    </div>
                                )}
                            </motion.div>
                        )}
                    </AnimatePresence>
                </div>
            </section>

            {/* or start from a set plan */}
            <section className="section-tight">
                <div className="container-site">
                    <SectionHead
                        center
                        eyebrow={setting('pricing_eyebrow', 'Pricing')}
                        heading="Or start from a set plan"
                        intro="Every plan runs on the same flat-fee model as the estimate above."
                    />
                    <PricingGrid plans={pricingPlans} />
                </div>
            </section>

            <section className="section-tight pt-0">
                <div className="container-site">
                    <TrustBar />
                </div>
            </section>

            <CtaBand />
        </SiteLayout>
    );
}
