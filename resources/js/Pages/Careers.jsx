import { useEffect, useMemo, useRef, useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import {
    ArrowRight,
    BriefcaseBusiness,
    CheckCircle2,
    Clock,
    GraduationCap,
    HeartHandshake,
    Home,
    PartyPopper,
    Sparkles,
    TrendingUp,
} from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import RevealText from '@/components/scrollxui/RevealText';
import Select from '@/components/scrollxui/Select';
import SpotlightCard from '@/components/scrollxui/SpotlightCard';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import Loader from '@/components/scrollxui/Loader';
import PageHero from '@/components/site/PageHero';
import SectionHead from '@/components/site/SectionHead';
import TrustBar from '@/components/site/TrustBar';
import { cn, makeSetting } from '@/lib/utils';

const inputClass =
    'w-full rounded-md border bg-white px-4 py-3 text-[15px] outline-none transition-colors placeholder:text-ink-soft/60';

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const URL_RE = /^https?:\/\/.+/i;

const PERKS = [
    { icon: Home, title: 'Work from home', text: 'Skip the commute. Work from anywhere in the Philippines with a reliable connection.' },
    { icon: Clock, title: 'Australian hours, steady schedule', text: 'Predictable shifts aligned to your client — no rotating graveyard roulette.' },
    { icon: TrendingUp, title: 'Above-market, inclusive pay', text: 'One fair rate with your entitlements built in — not the usual race to the bottom.' },
    { icon: HeartHandshake, title: 'Real backup', text: "You're managed and supported by a local team — never left to sink or swim alone." },
    { icon: GraduationCap, title: 'Grow your craft', text: 'Onboarding, upskilling and a clear path as you take on more responsibility.' },
    { icon: Sparkles, title: 'Genuinely good clients', text: 'We vet the businesses too, so you work with people who respect your time.' },
];

/** Red asterisk for required labels. */
function Req() {
    return <span className="ml-0.5 text-rose-deep" aria-hidden="true">*</span>;
}

function Field({ label, error, children, htmlFor, required }) {
    return (
        <div>
            <label htmlFor={htmlFor} className="mb-2 block text-[13.5px] font-semibold">
                {label}
                {required && <Req />}
            </label>
            {children}
            {error && (
                <span className="mt-1.5 block text-xs font-medium text-rose-deep" role="alert">
                    {error}
                </span>
            )}
        </div>
    );
}

function ApplicationForm({ roles, selectedRole, onRoleChange, formRef }) {
    const roleTitles = useMemo(() => roles.map((r) => r.title), [roles]);

    const form = useForm({
        full_name: '',
        email: '',
        phone: '',
        role: selectedRole || '',
        availability: '',
        portfolio_url: '',
        message: '',
    });

    // keep the form's role in sync when a card's "Apply" button is clicked
    useEffect(() => {
        if (selectedRole && form.data.role !== selectedRole) {
            form.setData('role', selectedRole);
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [selectedRole]);

    const [clientErrors, setClientErrors] = useState({});
    const [done, setDone] = useState(false);
    const errors = { ...form.errors, ...clientErrors };

    const scrollToForm = () => formRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' });

    const validate = () => {
        const next = {};
        if (!form.data.full_name.trim()) next.full_name = 'Please enter your full name.';
        if (!form.data.email.trim()) next.email = 'Please enter your email.';
        else if (!EMAIL_RE.test(form.data.email.trim())) next.email = "That email doesn't look right.";
        if (!form.data.phone.trim()) next.phone = 'A contact number is required.';
        if (!form.data.role) next.role = 'Please choose the role you\'re applying for.';
        if (form.data.portfolio_url.trim() && !URL_RE.test(form.data.portfolio_url.trim()))
            next.portfolio_url = 'Enter a full link starting with https://';
        if (!form.data.message.trim()) next.message = 'Tell us a little about yourself.';
        else if (form.data.message.trim().length < 20) next.message = 'Please write at least a sentence or two (20+ characters).';
        setClientErrors(next);
        return Object.keys(next).length === 0;
    };

    const submit = (e) => {
        e.preventDefault();
        if (!validate()) {
            scrollToForm();
            return;
        }
        form.post('/careers', {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                form.reset();
                setClientErrors({});
                onRoleChange('');
                setDone(true);
            },
            onError: () => scrollToForm(),
        });
    };

    if (done) {
        return (
            <motion.div
                initial={{ opacity: 0, y: 16 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.4 }}
                role="status"
                className="flex flex-col items-center gap-4 rounded-lg bg-sage-soft p-8 text-center md:p-12"
            >
                <span className="flex h-14 w-14 items-center justify-center rounded-full bg-sage-deep text-cream">
                    <PartyPopper className="h-7 w-7" strokeWidth={2.2} />
                </span>
                <h3 className="font-display text-[22px] font-bold text-ink">Application received</h3>
                <p className="max-w-sm text-[15px] leading-relaxed text-ink-soft">
                    Thanks for applying to Isla. If your experience looks like a fit, our team will reach out within a few business days.
                </p>
                <button
                    type="button"
                    onClick={() => setDone(false)}
                    className="mt-1 text-[14px] font-semibold text-rose-deep underline-offset-2 hover:underline"
                >
                    Submit another application
                </button>
            </motion.div>
        );
    }

    return (
        <motion.form
            onSubmit={submit}
            noValidate
            initial={{ opacity: 0, y: 24 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.55, ease: [0.22, 1, 0.36, 1] }}
            className="flex flex-col gap-5 rounded-lg bg-white p-6 shadow-float md:p-8"
        >
            <p className="text-[13px] text-ink-soft">
                Fields marked <Req /> are required.
            </p>

            <div className="grid gap-5 sm:grid-cols-2">
                <Field label="Full name" htmlFor="full_name" error={errors.full_name} required>
                    <input
                        id="full_name"
                        type="text"
                        autoComplete="name"
                        className={cn(inputClass, errors.full_name ? 'border-rose-deep' : 'border-hairline focus:border-ink/50')}
                        value={form.data.full_name}
                        onChange={(e) => form.setData('full_name', e.target.value)}
                    />
                </Field>
                <Field label="Phone" htmlFor="phone" error={errors.phone} required>
                    <input
                        id="phone"
                        type="tel"
                        autoComplete="tel"
                        className={cn(inputClass, errors.phone ? 'border-rose-deep' : 'border-hairline focus:border-ink/50')}
                        value={form.data.phone}
                        onChange={(e) => form.setData('phone', e.target.value)}
                    />
                </Field>
            </div>

            <Field label="Email" htmlFor="email" error={errors.email} required>
                <input
                    id="email"
                    type="email"
                    autoComplete="email"
                    className={cn(inputClass, errors.email ? 'border-rose-deep' : 'border-hairline focus:border-ink/50')}
                    value={form.data.email}
                    onChange={(e) => form.setData('email', e.target.value)}
                />
            </Field>

            <Field label="Role you're applying for" error={errors.role} required>
                <div className={cn('rounded-md', errors.role && 'ring-1 ring-rose-deep')}>
                    <Select
                        value={form.data.role}
                        onChange={(v) => {
                            form.setData('role', v);
                            onRoleChange(v);
                        }}
                        options={roleTitles}
                        placeholder="Choose a role"
                    />
                </div>
            </Field>

            <Field label="Earliest availability" htmlFor="availability" error={errors.availability}>
                <input
                    id="availability"
                    type="text"
                    placeholder="e.g. Immediately, 2 weeks' notice, part-time to start"
                    className={cn(inputClass, 'border-hairline focus:border-ink/50')}
                    value={form.data.availability}
                    onChange={(e) => form.setData('availability', e.target.value)}
                />
            </Field>

            <Field label="Portfolio, CV or LinkedIn link" htmlFor="portfolio_url" error={errors.portfolio_url}>
                <input
                    id="portfolio_url"
                    type="url"
                    placeholder="https://…"
                    className={cn(inputClass, errors.portfolio_url ? 'border-rose-deep' : 'border-hairline focus:border-ink/50')}
                    value={form.data.portfolio_url}
                    onChange={(e) => form.setData('portfolio_url', e.target.value)}
                />
            </Field>

            <Field label="Tell us about yourself" htmlFor="message" error={errors.message} required>
                <textarea
                    id="message"
                    rows={5}
                    placeholder="Your experience, the tools you know, and why you'd be a great VA…"
                    className={cn(inputClass, 'resize-y', errors.message ? 'border-rose-deep' : 'border-hairline focus:border-ink/50')}
                    value={form.data.message}
                    onChange={(e) => form.setData('message', e.target.value)}
                />
            </Field>

            <button
                type="submit"
                disabled={form.processing}
                className="group inline-flex w-full items-center justify-center gap-2.5 rounded-pill bg-ink px-7 py-4 text-[15px] font-semibold text-cream transition-all hover:bg-ink/90 disabled:opacity-60"
            >
                {form.processing ? <Loader /> : null}
                Submit application
                {!form.processing && (
                    <ArrowRight className="h-[18px] w-[18px] transition-transform group-hover:translate-x-1" strokeWidth={2.2} />
                )}
            </button>

            {Object.keys(errors).length > 0 && (
                <p
                    role="alert"
                    className="flex items-center gap-2.5 rounded-md bg-rose-soft px-4 py-3 text-[13.5px] font-medium text-rose-deep"
                >
                    <CheckCircle2 className="h-4 w-4 shrink-0 rotate-45" strokeWidth={2.2} />
                    Please fix the highlighted fields above and try again.
                </p>
            )}
        </motion.form>
    );
}

export default function Careers() {
    const { props } = usePage();
    const setting = makeSetting(props?.settings);
    const roles = props?.roles ?? [];

    const [selectedRole, setSelectedRole] = useState('');
    const formRef = useRef(null);

    const applyFor = (title) => {
        setSelectedRole(title);
        formRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    const heroChecks = [
        { icon: Home, text: 'Remote across the Philippines' },
        { icon: TrendingUp, text: 'Fair, inclusive pay' },
        { icon: HeartHandshake, text: 'Backed by a local team' },
    ];

    return (
        <SiteLayout
            title="Careers"
            description={setting('careers_intro', 'Join Isla — remote virtual assistant roles supporting growing Australian businesses.')}
        >
            <PageHero
                crumbs={[{ label: 'Careers' }]}
                eyebrow={setting('careers_eyebrow', 'Careers at Isla')}
                heading={setting('careers_heading', 'Build a career supporting businesses you actually like')}
                lede={setting('careers_intro', "We place Filipino talent with growing Australian businesses — and we look after our people the way we'd want to be looked after. Remote, fairly paid, and genuinely supported.")}
            >
                <ul className="mt-8 flex flex-wrap gap-x-8 gap-y-4">
                    {heroChecks.map((item, i) => (
                        <motion.li
                            key={i}
                            initial={{ opacity: 0, y: 12 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ delay: 0.3 + i * 0.1 }}
                            className="flex items-center gap-3"
                        >
                            <span className="flex h-8 w-8 items-center justify-center rounded-full bg-sage-deep text-cream">
                                <item.icon className="h-4 w-4" strokeWidth={2.4} />
                            </span>
                            <span className="text-[14.5px] font-semibold">{item.text}</span>
                        </motion.li>
                    ))}
                </ul>
            </PageHero>

            {/* why work at Isla */}
            <section className="section-tight">
                <div className="container-site">
                    <SectionHead
                        center
                        eyebrow={setting('careers_perks_eyebrow', 'Why work with us')}
                        heading={setting('careers_perks_heading', 'The good stuff, minus the catch')}
                    />
                    <div className="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                        {PERKS.map((perk, i) => (
                            <SpotlightCard key={i}>
                                <span className="mb-4 flex h-11 w-11 items-center justify-center rounded-full bg-rose-soft text-rose-deep">
                                    <perk.icon className="h-5 w-5" strokeWidth={2.2} />
                                </span>
                                <h3 className="font-display text-[16.5px] font-bold">{perk.title}</h3>
                                <p className="mt-2 text-[14.5px] leading-relaxed text-ink-soft">{perk.text}</p>
                            </SpotlightCard>
                        ))}
                    </div>
                </div>
            </section>

            {/* open roles */}
            <section className="section pt-0" id="roles">
                <div className="container-site">
                    <SectionHead
                        eyebrow={setting('careers_roles_eyebrow', 'Open roles')}
                        heading={setting('careers_roles_heading', 'Where you might fit')}
                        intro={setting('careers_roles_intro', "Pick the closest match and hit apply — we'll take it from there. Not sure? Send an open application.")}
                    />
                    <div className="grid gap-5 md:grid-cols-2">
                        {roles.map((role, i) => (
                            <motion.div
                                key={i}
                                initial={{ opacity: 0, y: 20 }}
                                whileInView={{ opacity: 1, y: 0 }}
                                viewport={{ once: true }}
                                transition={{ duration: 0.5, delay: i * 0.05 }}
                                className="flex flex-col rounded-lg border border-hairline-soft bg-white p-6 md:p-7"
                            >
                                <div className="mb-3 flex items-start justify-between gap-4">
                                    <span className="flex h-10 w-10 items-center justify-center rounded-full bg-sage-soft text-sage-deep">
                                        <BriefcaseBusiness className="h-5 w-5" strokeWidth={2.2} />
                                    </span>
                                    <span className="rounded-pill bg-cream px-3 py-1 text-[12px] font-semibold text-ink-soft">
                                        {role.type}
                                    </span>
                                </div>
                                <h3 className="font-display text-[18px] font-bold">{role.title}</h3>
                                <p className="mt-2 text-[14.5px] leading-relaxed text-ink-soft">{role.blurb}</p>
                                {role.skills?.length > 0 && (
                                    <ul className="mt-4 flex flex-wrap gap-2">
                                        {role.skills.map((skill, s) => (
                                            <li
                                                key={s}
                                                className="rounded-pill border border-hairline px-3 py-1 text-[12.5px] font-medium text-ink-soft"
                                            >
                                                {skill}
                                            </li>
                                        ))}
                                    </ul>
                                )}
                                <div className="mt-6 flex-1" />
                                <StaggerButton
                                    as="button"
                                    type="button"
                                    onClick={() => applyFor(role.title)}
                                    variant="secondary"
                                    iconRight={ArrowRight}
                                    className="!justify-between"
                                >
                                    Apply for this role
                                </StaggerButton>
                            </motion.div>
                        ))}
                    </div>
                </div>
            </section>

            {/* application form */}
            <section className="section pt-0" id="apply" ref={formRef}>
                <div className="container-site">
                    <div className="grid items-start gap-10 lg:grid-cols-[0.9fr_1.1fr]">
                        <div className="lg:sticky lg:top-28">
                            <p className="t-eyebrow mb-3 text-rose-deep">{setting('careers_form_eyebrow', 'Apply now')}</p>
                            <RevealText
                                text={setting('careers_form_heading', 'Send us your application')}
                                className="t-display-lg"
                            />
                            <p className="mt-4 max-w-md text-ink-soft">
                                {setting('careers_form_intro', "It takes a couple of minutes. Fill in the required fields, tell us what you're great at, and we'll be in touch if there's a fit.")}
                            </p>
                            <ul className="mt-6 flex flex-col gap-3">
                                {['We read every application', 'Shortlisted applicants hear back within a few business days', 'A quick chat, then a simple skills check'].map(
                                    (line, i) => (
                                        <li key={i} className="flex items-start gap-3 text-[14.5px] text-ink-soft">
                                            <CheckCircle2 className="mt-0.5 h-5 w-5 shrink-0 text-sage-deep" strokeWidth={2.2} />
                                            {line}
                                        </li>
                                    ),
                                )}
                            </ul>
                        </div>

                        <ApplicationForm
                            roles={roles}
                            selectedRole={selectedRole}
                            onRoleChange={setSelectedRole}
                            formRef={formRef}
                        />
                    </div>
                </div>
            </section>

            <section className="section-tight pt-0">
                <div className="container-site">
                    <TrustBar />
                </div>
            </section>
        </SiteLayout>
    );
}