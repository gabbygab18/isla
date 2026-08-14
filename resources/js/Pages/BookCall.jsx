import { useMemo, useState } from 'react';
import { usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import {
    ArrowRight,
    Calculator,
    Calendar as CalendarIcon,
    CheckCircle2,
    ChevronLeft,
    ChevronRight,
    Clock,
    Globe,
    Headset,
    MessageCircle,
    Target,
} from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import ExpandableCards from '@/components/scrollxui/ExpandableCards';
import RevealText from '@/components/scrollxui/RevealText';
import ScrollAreaPro from '@/components/scrollxui/ScrollAreaPro';
import SpotlightCard from '@/components/scrollxui/SpotlightCard';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import EnquiryForm from '@/components/site/EnquiryForm';
import Modal from '@/components/site/Modal';
import PageHero from '@/components/site/PageHero';
import SectionHead from '@/components/site/SectionHead';
import TrustBar from '@/components/site/TrustBar';
import { cn, makeSetting } from '@/lib/utils';

const TIMES = ['9:00 am', '9:30 am', '10:00 am', '10:30 am', '11:00 am', '11:30 am', '1:00 pm', '1:30 pm', '2:00 pm', '2:30 pm', '3:00 pm', '3:30 pm', '4:00 pm'];
const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

const CALL_FAQS = [
    { title: 'Do I need to prepare anything?', content: <p>No prep needed. A rough sense of what's eating your week is plenty — we'll guide the conversation from there.</p> },
    { title: 'Is the call actually free?', content: <p>Yes — no card, no deposit, no obligation. You only move forward if the fit makes sense on your side.</p> },
    { title: "What if I'm not based in a major city?", content: <p>It doesn't matter — we work with clients across Australia. The call is video or phone, and your assistant works your business hours in your time zone.</p> },
];

function fmtDate(date) {
    return date.toLocaleDateString('en-AU', { weekday: 'long', day: 'numeric', month: 'long' });
}

function Scheduler({ onConfirm, windowDays }) {
    const today = useMemo(() => {
        const d = new Date();
        d.setHours(0, 0, 0, 0);
        return d;
    }, []);

    // Bookings are only offered inside a short rolling window so enquiries
    // land while they are still front of mind for the sales team. Length is
    // admin-editable (Settings -> Book a Discovery Call page).
    const lastBookable = useMemo(() => {
        const d = new Date(today);
        d.setDate(d.getDate() + windowDays);
        return d;
    }, [today, windowDays]);

    const [view, setView] = useState(new Date(today.getFullYear(), today.getMonth(), 1));
    const [selectedDate, setSelectedDate] = useState(null);
    const [selectedTime, setSelectedTime] = useState('');

    // Only allow paging to months the window actually reaches into.
    const atFirstMonth =
        view.getFullYear() === today.getFullYear() && view.getMonth() === today.getMonth();
    const atLastMonth =
        view.getFullYear() === lastBookable.getFullYear() &&
        view.getMonth() === lastBookable.getMonth();

    const days = useMemo(() => {
        const firstDow = (new Date(view.getFullYear(), view.getMonth(), 1).getDay() + 6) % 7; // Mon = 0
        const total = new Date(view.getFullYear(), view.getMonth() + 1, 0).getDate();
        const cells = Array.from({ length: firstDow }, () => null);
        for (let d = 1; d <= total; d++) {
            const date = new Date(view.getFullYear(), view.getMonth(), d);
            const isWeekend = date.getDay() === 0 || date.getDay() === 6;
            const outsideWindow = date < today || date > lastBookable;
            cells.push({ date, disabled: isWeekend || outsideWindow });
        }
        return cells;
    }, [view, today, lastBookable]);

    const pick = (time) => {
        setSelectedTime(time);
        onConfirm(selectedDate ? `${time}, ${fmtDate(selectedDate)}` : '');
    };

    return (
        <motion.div
            initial={{ opacity: 0, y: 28 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6 }}
            className="grid overflow-hidden rounded-lg border border-hairline-soft bg-white shadow-float md:grid-cols-[260px_1fr_240px]"
        >
            {/* call details */}
            <div className="border-b border-hairline-soft p-7 md:border-b-0 md:border-r">
                <img src="/logo.png" alt="Isla VA Solutions" className="h-10 w-auto" />
                <p className="t-caption mt-4 text-ink-soft">Isla Virtual Staffing</p>
                <h2 className="t-card-title mt-1.5">Discovery Call</h2>
                <ul className="mt-5 flex flex-col gap-3 text-[14px] text-ink-soft">
                    <li className="flex items-center gap-2.5"><Clock className="h-4 w-4" strokeWidth={2.2} /> 15 min</li>
                    <li className="flex items-center gap-2.5"><Headset className="h-4 w-4" strokeWidth={2.2} /> Video or phone — your pick</li>
                    <li className="flex items-center gap-2.5"><Globe className="h-4 w-4" strokeWidth={2.2} /> Australian Eastern Time</li>
                </ul>
                <p className="t-body-sm mt-6 opacity-70">
                    Pick a day and time that suits you. We'll confirm by email within one business day.
                </p>
            </div>

            {/* calendar */}
            <div className="border-b border-hairline-soft p-7 md:border-b-0 md:border-r">
                <p className="t-caption mb-4 text-ink-soft">Select a Day</p>
                <div className="mb-4 flex items-center justify-between">
                    <button
                        type="button"
                        aria-label="Previous month"
                        disabled={atFirstMonth}
                        onClick={() => setView(new Date(view.getFullYear(), view.getMonth() - 1, 1))}
                        className="flex h-9 w-9 items-center justify-center rounded-full border border-hairline transition-colors hover:border-ink disabled:cursor-not-allowed disabled:border-hairline-soft disabled:text-ink/25 disabled:hover:border-hairline-soft"
                    >
                        <ChevronLeft className="h-4 w-4" strokeWidth={2.2} />
                    </button>
                    <span className="font-display text-[16px] font-bold">
                        {MONTHS[view.getMonth()]} {view.getFullYear()}
                    </span>
                    <button
                        type="button"
                        aria-label="Next month"
                        disabled={atLastMonth}
                        onClick={() => setView(new Date(view.getFullYear(), view.getMonth() + 1, 1))}
                        className="flex h-9 w-9 items-center justify-center rounded-full border border-hairline transition-colors hover:border-ink disabled:cursor-not-allowed disabled:border-hairline-soft disabled:text-ink/25 disabled:hover:border-hairline-soft"
                    >
                        <ChevronRight className="h-4 w-4" strokeWidth={2.2} />
                    </button>
                </div>
                <div className="t-caption grid grid-cols-7 gap-1 text-center text-ink-soft">
                    {['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'].map((d) => (
                        <span key={d} className="py-1.5">{d}</span>
                    ))}
                </div>
                <div className="grid grid-cols-7 gap-1">
                    {days.map((cell, i) =>
                        cell ? (
                            <button
                                key={i}
                                type="button"
                                disabled={cell.disabled}
                                onClick={() => {
                                    setSelectedDate(cell.date);
                                    setSelectedTime('');
                                    onConfirm('');
                                }}
                                className={cn(
                                    'aspect-square rounded-full text-[13.5px] font-semibold transition-colors',
                                    cell.disabled
                                        ? 'cursor-not-allowed text-ink/25'
                                        : 'text-ink hover:bg-rose-soft',
                                    selectedDate?.getTime() === cell.date.getTime() && 'bg-ink text-cream hover:bg-ink',
                                )}
                            >
                                {cell.date.getDate()}
                            </button>
                        ) : (
                            <span key={i} />
                        ),
                    )}
                </div>
                <p className="t-body-sm mt-4 text-ink-soft">
                    Showing available weekdays up to{' '}
                    {lastBookable.toLocaleDateString('en-AU', { day: 'numeric', month: 'long' })}.
                    Need a date further out? Use the enquiry form below.
                </p>
            </div>

            {/* time slots — scrollxui scroll-areapro */}
            <div className="p-7">
                <p className="t-caption mb-2 text-ink-soft">Select a Time</p>
                <p className="t-body-sm mb-4 opacity-80">
                    {selectedDate ? fmtDate(selectedDate) : 'Choose a day on the calendar to see available times.'}
                </p>
                {selectedDate && (
                    <ScrollAreaPro maxHeight="300px">
                        <div className="flex flex-col gap-2" role="listbox" aria-label="Available times">
                            {TIMES.map((time) => (
                                <button
                                    key={time}
                                    type="button"
                                    role="option"
                                    aria-selected={selectedTime === time}
                                    onClick={() => pick(time)}
                                    className={cn(
                                        'rounded-md border px-4 py-2.5 text-[14px] font-semibold transition-colors',
                                        selectedTime === time
                                            ? 'border-ink bg-ink text-cream'
                                            : 'border-hairline hover:border-rose-deep hover:text-rose-deep',
                                    )}
                                >
                                    {time}
                                </button>
                            ))}
                        </div>
                    </ScrollAreaPro>
                )}
            </div>
        </motion.div>
    );
}

export default function BookCall() {
    const setting = makeSetting(usePage().props?.settings);
    const [preferredTime, setPreferredTime] = useState('');
    const [formOpen, setFormOpen] = useState(false);

    const heroChecks = [
        { icon: Clock, text: '15 minutes, video or phone' },
        { icon: CheckCircle2, text: 'No obligation, no card required' },
        { icon: Target, text: 'Walk away with a clear next step either way' },
    ];

    return (
        <SiteLayout
            title="Book a Discovery Call"
            description={setting('book_intro', 'A free 15-minute call to work out what your assistant should own first — no obligation, no card.')}
        >
            <PageHero
                crumbs={[{ label: 'Book a Discovery Call' }]}
                eyebrow={setting('book_eyebrow', 'Book a discovery call')}
                heading={setting('book_heading', 'A real conversation about where your hours are going')}
                lede={setting('book_intro', "Tell us what's taking up your time. We'll tell you what an assistant can take off your plate, roughly what it costs, and whether it's the right fit — including if it isn't.")}
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

            {/* scheduler */}
            <section className="pb-4 pt-6" id="schedule">
                <div className="container-site">
                    <Scheduler
                        onConfirm={setPreferredTime}
                        windowDays={Math.max(1, Number(setting('book_window_days', 14)) || 14)}
                    />
                    {preferredTime && (
                        <motion.div
                            initial={{ opacity: 0, y: 12 }}
                            animate={{ opacity: 1, y: 0 }}
                            className="mt-5 flex flex-wrap items-center justify-between gap-4 rounded-lg bg-sage-soft px-6 py-5"
                        >
                            <div>
                                <p className="t-caption text-sage-deep">Your preferred time</p>
                                <p className="mt-1 font-display text-[17px] font-bold">{preferredTime}</p>
                            </div>
                            <StaggerButton type="button" onClick={() => setFormOpen(true)} iconRight={ArrowRight}>
                                Confirm & send details
                            </StaggerButton>
                        </motion.div>
                    )}
                    {!preferredTime && (
                        <p className="mt-5 text-center text-[14px] text-ink-soft">
                            Prefer to skip the calendar?{' '}
                            <button
                                type="button"
                                onClick={() => setFormOpen(true)}
                                className="font-bold text-rose-deep underline-offset-2 hover:underline"
                            >
                                Send us your details
                            </button>{' '}
                            and we'll suggest a time.
                        </p>
                    )}
                </div>
            </section>

            {/* booking form — modal popup on confirm */}
            <Modal open={formOpen} onClose={() => setFormOpen(false)} label={setting('book_form_heading', 'Tell us about your business')}>
                <p className="t-eyebrow mb-2 text-rose-deep">{setting('book_form_eyebrow', 'Get started')}</p>
                <h2 className="t-headline">{setting('book_form_heading', 'Tell us about your business')}</h2>
                <p className="mt-2 text-[15px] leading-relaxed text-ink-soft">
                    {setting('book_form_intro', "Send a few details and we'll come back with a time to talk within one business day.")}
                </p>
                {preferredTime && (
                    <div className="mt-5">
                        <span className="mb-2 block text-[13.5px] font-semibold">Preferred call time</span>
                        <div className="rounded-md border border-hairline bg-cream px-4 py-3 text-[15px]">{preferredTime}</div>
                    </div>
                )}
                <div className="mt-6">
                    <EnquiryForm
                        sectors={['NDIS, Aged Care and Community Services', 'Healthcare and Allied Health', 'Construction', 'Engineering', 'Real Estate and Property Management', 'Finance and Accounting', 'Insurance', 'eCommerce and Retail', 'Technology and IT', 'Fitness, Health and Wellness', 'Renewable Energy', 'Other']}
                        messageLabel="What's eating your week right now?"
                        messagePlaceholder="e.g. scheduling, invoicing, participant enquiries, quoting follow-ups..."
                        submitLabel="Book my discovery call"
                        preferredTime={preferredTime}
                        successHeading="Your call request is in"
                        successMessage="Thanks — we'll confirm your discovery call by email within one business day. No card, no obligation."
                    />
                </div>
            </Modal>

            {/* what happens next */}
            <section className="section-tight">
                <div className="container-site">
                    <SectionHead
                        center
                        eyebrow={setting('book_next_eyebrow', 'What happens next')}
                        heading={setting('book_next_heading', 'No pitch deck, no lock-in on the call itself')}
                    />
                    <div className="grid gap-5 md:grid-cols-3">
                        {[
                            { icon: CalendarIcon, title: '01 — We confirm a time', text: "You'll hear back within one business day to lock in a slot that suits you — video or phone, whichever's easier." },
                            { icon: MessageCircle, title: '02 — A real conversation', text: 'We ask about your week, suggest what to hand off first, and explain how matching and onboarding actually works.' },
                            { icon: Target, title: '03 — You decide, on your timeline', text: "You'll get a short recap with next steps and an indicative cost. No follow-up calls unless you want one." },
                        ].map((card, i) => (
                            <SpotlightCard key={i}>
                                <span className="mb-4 flex h-11 w-11 items-center justify-center rounded-full bg-rose-soft text-rose-deep">
                                    <card.icon className="h-5 w-5" strokeWidth={2.2} />
                                </span>
                                <h3 className="font-display text-[16.5px] font-bold">{card.title}</h3>
                                <p className="mt-2 text-[14.5px] leading-relaxed text-ink-soft">{card.text}</p>
                            </SpotlightCard>
                        ))}
                    </div>
                </div>
            </section>

            {/* lighter ways to start */}
            <section className="section pt-0">
                <div className="container-site">
                    <motion.div
                        initial={{ opacity: 0, y: 28 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.55 }}
                        className="block-sage"
                    >
                        <div className="grid items-center gap-9 md:grid-cols-2">
                            <div>
                                <p className="t-eyebrow mb-3">{setting('book_lighter_eyebrow', 'Not ready for a call?')}</p>
                                <RevealText text={setting('book_lighter_heading', 'Two lighter ways to start')} className="t-headline" />
                                <p className="mt-2.5 opacity-80">
                                    {setting('book_lighter_intro', 'No pressure to book. Get a feel for the numbers first, or read the FAQ.')}
                                </p>
                            </div>
                            <div className="flex flex-col gap-3.5">
                                <StaggerButton href="/cost-estimator" iconRight={Calculator} className="!justify-between">
                                    Get an instant cost estimate
                                </StaggerButton>
                                <StaggerButton href="/faq" variant="secondary" iconRight={ArrowRight} className="!justify-between">
                                    Read the FAQ first
                                </StaggerButton>
                            </div>
                        </div>
                    </motion.div>
                </div>
            </section>

            <section className="section-tight pt-0">
                <div className="container-site">
                    <TrustBar />
                </div>
            </section>

            {/* quick FAQ about the call */}
            <section className="section pt-0">
                <div className="container-site">
                    <div className="block-rose">
                        <p className="t-eyebrow mb-3 text-center">{setting('book_faq_eyebrow', 'Questions about the call')}</p>
                        <RevealText
                            text={setting('book_faq_heading', 'What to expect before you book')}
                            className="t-headline mx-auto mb-10 max-w-2xl text-center"
                        />
                        <ExpandableCards items={CALL_FAQS} />
                    </div>
                </div>
            </section>
        </SiteLayout>
    );
}
