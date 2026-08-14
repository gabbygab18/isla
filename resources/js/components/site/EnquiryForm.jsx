import { useRef, useState } from 'react';
import { useForm } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { ArrowRight, CalendarCheck, CheckCircle2 } from 'lucide-react';
import Loader from '@/components/scrollxui/Loader';
import Select from '@/components/scrollxui/Select';
import { cn } from '@/lib/utils';

const inputClass =
    'w-full rounded-md border bg-white px-4 py-3 text-[15px] outline-none transition-colors placeholder:text-ink-soft/60';

/** Red asterisk shown next to required field labels. */
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

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

/**
 * The enquiry / booking form shared by Home, Contact and Book a Call.
 * Industry uses the scrollxui select; submit shows the scrollxui loader.
 *
 * On a successful send the form is replaced by a clear confirmation panel
 * (so the action visibly "proceeds"), and blank required fields are caught
 * before the request so the button never fails silently.
 */
export default function EnquiryForm({
    sectors = ['NDIS, Aged Care and Community Services', 'Healthcare and Allied Health', 'Construction', 'Engineering', 'Real Estate and Property Management', 'Finance and Accounting', 'Insurance', 'eCommerce and Retail', 'Technology and IT', 'Fitness, Health and Wellness', 'Renewable Energy', 'Other'],
    messageLabel = 'What do you need help with?',
    messagePlaceholder,
    submitLabel = 'Request a VA',
    extra = null,
    preferredTime = '',
    successHeading = 'Your enquiry is on its way',
    successMessage = "Thanks — we've got your details and we'll be in touch within one business day.",
}) {
    const form = useForm({
        full_name: '',
        business_name: '',
        email: '',
        phone: '',
        sector: '',
        message: '',
    });

    const [clientErrors, setClientErrors] = useState({});
    const [done, setDone] = useState(false);
    const topRef = useRef(null);

    // combined view of client-side guard errors + server validation errors
    const errors = { ...form.errors, ...clientErrors };

    const scrollToTop = () => {
        topRef.current?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    };

    const validate = () => {
        const next = {};
        if (!form.data.full_name.trim()) next.full_name = 'Please enter your full name.';
        if (!form.data.email.trim()) next.email = 'Please enter your email.';
        else if (!EMAIL_RE.test(form.data.email.trim())) next.email = "That email doesn't look right.";
        if (!form.data.message.trim()) next.message = 'Please add a short message.';
        setClientErrors(next);
        return Object.keys(next).length === 0;
    };

    const submit = (e) => {
        e.preventDefault();

        if (!validate()) {
            scrollToTop();
            return;
        }

        const payload = preferredTime
            ? { ...form.data, message: `Preferred call time: ${preferredTime}\n\n${form.data.message}` }
            : form.data;

        // NOTE: in @inertiajs/react v1.2+, transform() returns undefined (not the
        // form), so it is NOT chainable — `form.transform(...).post(...)` throws
        // "Cannot read properties of undefined (reading 'post')". Call it as its
        // own statement, then post.
        form.transform(() => payload);
        form.post('/contact', {
            preserveScroll: true,
            // Without this, Inertia follows the redirect from back() with a fresh
            // page key, remounting the tree and wiping `done` (and closing the
            // modal) before the confirmation can render — the submit looks dead.
            preserveState: true,
            onSuccess: () => {
                form.reset();
                setClientErrors({});
                setDone(true);
            },
            onError: () => scrollToTop(),
        });
    };

    // ── success state ─────────────────────────────────────────────
    if (done) {
        return (
            <motion.div
                initial={{ opacity: 0, y: 16 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.4 }}
                role="status"
                className="flex flex-col items-center gap-4 rounded-lg bg-sage-soft p-8 text-center md:p-10"
            >
                <span className="flex h-14 w-14 items-center justify-center rounded-full bg-sage-deep text-cream">
                    <CalendarCheck className="h-7 w-7" strokeWidth={2.2} />
                </span>
                <h3 className="font-display text-[22px] font-bold text-ink">{successHeading}</h3>
                <p className="max-w-sm text-[15px] leading-relaxed text-ink-soft">{successMessage}</p>
                <button
                    type="button"
                    onClick={() => setDone(false)}
                    className="mt-1 text-[14px] font-semibold text-rose-deep underline-offset-2 hover:underline"
                >
                    Send another
                </button>
            </motion.div>
        );
    }

    // ── form ──────────────────────────────────────────────────────
    return (
        <motion.form
            ref={topRef}
            onSubmit={submit}
            noValidate
            initial={{ opacity: 0, y: 24 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.55, ease: [0.22, 1, 0.36, 1] }}
            className="flex flex-col gap-5 rounded-lg bg-white p-6 md:p-8"
        >
            <p className="text-[13px] text-ink-soft">
                Fields marked <Req /> are required.
            </p>

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
            <Field label="Business name" htmlFor="business_name" error={errors.business_name}>
                <input
                    id="business_name"
                    type="text"
                    autoComplete="organization"
                    className={cn(inputClass, 'border-hairline focus:border-ink/50')}
                    value={form.data.business_name}
                    onChange={(e) => form.setData('business_name', e.target.value)}
                />
            </Field>
            <div className="grid gap-5 sm:grid-cols-2">
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
                <Field label="Phone" htmlFor="phone" error={errors.phone}>
                    <input
                        id="phone"
                        type="tel"
                        autoComplete="tel"
                        className={cn(inputClass, 'border-hairline focus:border-ink/50')}
                        value={form.data.phone}
                        onChange={(e) => form.setData('phone', e.target.value)}
                    />
                </Field>
            </div>
            <Field label="Industry" error={errors.sector}>
                <Select
                    value={form.data.sector}
                    onChange={(v) => form.setData('sector', v)}
                    options={sectors}
                    placeholder="Select the closest fit"
                />
            </Field>

            {extra}

            <Field label={messageLabel} htmlFor="message" error={errors.message} required>
                <textarea
                    id="message"
                    rows={4}
                    placeholder={messagePlaceholder}
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
                {submitLabel}
                {!form.processing && (
                    <ArrowRight className="h-[18px] w-[18px] transition-transform group-hover:translate-x-1" strokeWidth={2.2} />
                )}
            </button>

            <AnimatePresence>
                {Object.keys(errors).length > 0 && (
                    <motion.p
                        initial={{ opacity: 0, y: 6 }}
                        animate={{ opacity: 1, y: 0 }}
                        exit={{ opacity: 0 }}
                        role="alert"
                        className="flex items-center gap-2.5 rounded-md bg-rose-soft px-4 py-3 text-[13.5px] font-medium text-rose-deep"
                    >
                        <CheckCircle2 className="h-4 w-4 shrink-0 rotate-45" strokeWidth={2.2} />
                        Please fix the highlighted fields above and try again.
                    </motion.p>
                )}
            </AnimatePresence>
        </motion.form>
    );
}