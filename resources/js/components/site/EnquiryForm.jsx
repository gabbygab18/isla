import { useForm, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, CheckCircle2 } from 'lucide-react';
import Loader from '@/components/scrollxui/Loader';
import Select from '@/components/scrollxui/Select';
import { cn } from '@/lib/utils';

const inputClass =
    'w-full rounded-md border border-hairline bg-white px-4 py-3 text-[15px] outline-none transition-colors placeholder:text-ink-soft/60 focus:border-ink/50';

function Field({ label, error, children, htmlFor }) {
    return (
        <div>
            <label htmlFor={htmlFor} className="mb-2 block text-[13.5px] font-semibold">
                {label}
            </label>
            {children}
            {error && <span className="mt-1.5 block text-xs font-medium text-rose-deep">{error}</span>}
        </div>
    );
}

/**
 * The enquiry / booking form shared by Home, Contact and Book a Call.
 * Sector uses the scrollxui select; submit shows the scrollxui loader.
 */
export default function EnquiryForm({
    sectors = ['NDIS Provider', 'Healthcare & Allied Health', 'Small–Medium Business', 'Other'],
    messageLabel = 'What do you need help with?',
    messagePlaceholder,
    submitLabel = 'Request a VA',
    extra = null,
    preferredTime = '',
}) {
    const { flash } = usePage().props ?? {};
    const form = useForm({
        full_name: '',
        business_name: '',
        email: '',
        phone: '',
        sector: '',
        message: '',
    });

    const submit = (e) => {
        e.preventDefault();
        const payload = preferredTime
            ? { ...form.data, message: `Preferred call time: ${preferredTime}\n\n${form.data.message}` }
            : form.data;

        form.transform(() => payload).post('/contact', {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
    };

    return (
        <motion.form
            onSubmit={submit}
            initial={{ opacity: 0, y: 24 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.55, ease: [0.22, 1, 0.36, 1] }}
            className="flex flex-col gap-5 rounded-lg bg-white p-6 md:p-8"
        >
            <Field label="Full name" htmlFor="full_name" error={form.errors.full_name}>
                <input
                    id="full_name"
                    type="text"
                    required
                    autoComplete="name"
                    className={inputClass}
                    value={form.data.full_name}
                    onChange={(e) => form.setData('full_name', e.target.value)}
                />
            </Field>
            <Field label="Business name" htmlFor="business_name" error={form.errors.business_name}>
                <input
                    id="business_name"
                    type="text"
                    autoComplete="organization"
                    className={inputClass}
                    value={form.data.business_name}
                    onChange={(e) => form.setData('business_name', e.target.value)}
                />
            </Field>
            <div className="grid gap-5 sm:grid-cols-2">
                <Field label="Email" htmlFor="email" error={form.errors.email}>
                    <input
                        id="email"
                        type="email"
                        required
                        autoComplete="email"
                        className={inputClass}
                        value={form.data.email}
                        onChange={(e) => form.setData('email', e.target.value)}
                    />
                </Field>
                <Field label="Phone" htmlFor="phone" error={form.errors.phone}>
                    <input
                        id="phone"
                        type="tel"
                        autoComplete="tel"
                        className={inputClass}
                        value={form.data.phone}
                        onChange={(e) => form.setData('phone', e.target.value)}
                    />
                </Field>
            </div>
            <Field label="Sector" error={form.errors.sector}>
                <Select
                    value={form.data.sector}
                    onChange={(v) => form.setData('sector', v)}
                    options={sectors}
                    placeholder="Select the closest fit"
                />
            </Field>

            {extra}

            <Field label={messageLabel} htmlFor="message" error={form.errors.message}>
                <textarea
                    id="message"
                    rows={4}
                    required
                    placeholder={messagePlaceholder}
                    className={cn(inputClass, 'resize-y')}
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

            {flash?.success && (
                <motion.p
                    initial={{ opacity: 0, y: 8 }}
                    animate={{ opacity: 1, y: 0 }}
                    role="status"
                    className="flex items-center gap-2.5 rounded-md bg-sage-soft px-4 py-3.5 text-[14px] font-semibold text-sage-deep"
                >
                    <CheckCircle2 className="h-5 w-5 shrink-0" strokeWidth={2.2} />
                    {flash.success}
                </motion.p>
            )}
        </motion.form>
    );
}
