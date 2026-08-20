import { useEffect } from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ThemeProvider } from 'next-themes';
import { CalendarCheck, Clock, Check, StickyNote } from 'lucide-react';
import BrandLoader from '@/components/talent/BrandLoader';
import ViewControls from '@/components/talent/ViewControls';
import CalendlyEmbed from '@/components/CalendlyEmbed';

/**
 * Confirmation for the interviews booked from the talent bench. The bench runs
 * its own booking rather than handing clients to /book-a-call, so this closes
 * the presentation in the same theme, loader and controls.
 */
export default function TalentBookedPage(props) {
    useEffect(() => () => {
        document.documentElement.classList.remove('dark');
        document.documentElement.style.colorScheme = '';
    }, []);

    return (
        <ThemeProvider attribute="class" defaultTheme="light" enableSystem={false} storageKey="isla-talent-theme">
            <BrandLoader />
            <Booked {...props} />
        </ThemeProvider>
    );
}

function Booked({ token, heading, shortlist, candidates = [] }) {
    // Set in admin › Settings › Calendly. The slots above are the client's
    // preference; this is where they lock a real time in with the team.
    const calendlyUrl = usePage().props?.settings?.calendly_interview_url || '';

    return (
        <div className="flex min-h-[100dvh] flex-col bg-cream text-ink">
            <Head>
                <title>Interviews booked — Isla Talent Bench</title>
                <meta name="robots" content="noindex, nofollow" />
            </Head>

            <header className="flex shrink-0 items-center justify-between px-7 py-4">
                <img src="/logo.png" alt="Isla" className="h-8 w-auto" />
                <ViewControls />
            </header>

            <main className="flex flex-1 items-center justify-center px-7 py-8">
                <motion.div
                    initial={{ opacity: 0, y: 18 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6, ease: [0.22, 1, 0.36, 1] }}
                    className="w-full max-w-3xl"
                >
                    <div className="flex flex-col items-center text-center">
                        <span className="mb-5 flex h-12 w-12 items-center justify-center rounded-full bg-sage-deep text-white">
                            <Check className="h-6 w-6" strokeWidth={3} />
                        </span>
                        <p className="t-eyebrow mb-2 text-rose-deep">{heading}</p>
                        <h1 className="t-display-lg">
                            {candidates.length === 1 ? 'Your interview is booked' : 'Your interviews are booked'}
                        </h1>
                        <p className="mt-3 max-w-xl text-[15px] leading-relaxed text-ink-soft">
                            Thanks {shortlist.client_name.split(' ')[0]} — we've got your shortlist. Our team will
                            confirm {candidates.length === 1 ? 'this interview' : 'these interviews'} to{' '}
                            {shortlist.client_email} and check each candidate's availability against the times you picked.
                        </p>
                    </div>

                    <div className="mt-8 flex flex-col gap-3">
                        <p className="t-caption text-ink-soft">
                            {candidates.length} interview{candidates.length === 1 ? '' : 's'} requested
                        </p>
                        {candidates.map((c, i) => (
                            <div key={c.id} className="rounded-lg border border-hairline-soft bg-white p-4">
                                <div className="flex flex-wrap items-center gap-3">
                                    {c.photo_display_url ? (
                                        <img src={c.photo_display_url} alt={c.name} className="h-10 w-10 rounded-full object-cover" />
                                    ) : (
                                        <span className="flex h-10 w-10 items-center justify-center rounded-full bg-ink text-[15px] font-bold text-cream">
                                            {c.name.trim().charAt(0).toUpperCase()}
                                        </span>
                                    )}
                                    <span className="min-w-0">
                                        <span className="block font-display text-[15px] font-bold leading-tight">{i + 1}. {c.name}</span>
                                        <span className="block text-[12.5px] leading-tight text-ink-soft">{c.role_title}</span>
                                    </span>
                                </div>

                                <div className="mt-3 grid gap-2 sm:grid-cols-2">
                                    <p className="flex items-center gap-2 text-[13.5px]">
                                        <CalendarCheck className="h-4 w-4 shrink-0 text-rose-deep" strokeWidth={2.2} />
                                        <span className="font-bold">{c.date || 'To be confirmed'}</span>
                                    </p>
                                    <p className="flex items-center gap-2 text-[13.5px]">
                                        <Clock className="h-4 w-4 shrink-0 text-sage-deep" strokeWidth={2.2} />
                                        <span className="font-bold">{c.times || 'To be confirmed'}</span>
                                    </p>
                                </div>

                                {c.note && (
                                    <p className="mt-2 flex items-start gap-2 text-[13px] leading-relaxed text-ink-soft">
                                        <StickyNote className="mt-0.5 h-3.5 w-3.5 shrink-0" strokeWidth={2.2} />
                                        {c.note}
                                    </p>
                                )}
                            </div>
                        ))}
                    </div>

                    {calendlyUrl && (
                        <div className="mt-8 rounded-lg border border-hairline-soft bg-white p-4">
                            <p className="t-caption text-ink-soft">Confirm a time with the team</p>
                            <p className="mt-1.5 text-[14px] leading-relaxed text-ink-soft">
                                Pick a slot below and we'll bring {candidates.length === 1 ? 'this candidate' : 'these candidates'} to the call.
                            </p>
                            <div className="mt-3">
                                <CalendlyEmbed
                                    url={calendlyUrl}
                                    prefill={{
                                        name: shortlist.client_name,
                                        email: shortlist.client_email,
                                        a1: candidates.map((c) => c.name).join(', '),
                                    }}
                                    height={680}
                                />
                            </div>
                        </div>
                    )}

                    {shortlist.notes && (
                        <div className="mt-5 rounded-lg border border-hairline-soft bg-white p-4">
                            <p className="t-caption text-ink-soft">Your notes</p>
                            <p className="mt-1.5 whitespace-pre-wrap text-[14.5px] leading-relaxed text-ink-soft">{shortlist.notes}</p>
                        </div>
                    )}

                    <div className="mt-8 flex justify-center">
                        <Link
                            href={`/talent/${token}`}
                            className="rounded-pill border border-hairline px-5 py-2.5 text-[13.5px] font-semibold text-ink-soft transition-colors hover:border-ink/40 hover:text-ink"
                        >
                            ← Back to the talent bench
                        </Link>
                    </div>
                </motion.div>
            </main>
        </div>
    );
}
