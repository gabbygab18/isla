import { Link, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, HardHat } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import RevealText from '@/components/scrollxui/RevealText';
import SpotlightCard from '@/components/scrollxui/SpotlightCard';
import CtaBand from '@/components/site/CtaBand';
import Icon from '@/components/site/Icon';
import PageHero from '@/components/site/PageHero';
import TrustBar from '@/components/site/TrustBar';
import { makeSetting } from '@/lib/utils';

export default function Team({ services = [], processSteps = [] }) {
    const setting = makeSetting(usePage().props?.settings);

    return (
        <SiteLayout title="Team We Build" description={setting('team_intro', 'The roles Isla places, and how they come together into a team around your business.')}>
            <PageHero
                crumbs={[{ label: 'Team We Build' }]}
                eyebrow={setting('team_eyebrow', 'Team we build')}
                heading={setting('team_heading', 'The team we build around your business')}
                lede={setting('team_intro', 'Start with one dedicated assistant covering the roles below, or scope a small rostered team on the Dedicated plan — either way, every role is matched, briefed, and managed by Isla.')}
            />

            {/* role grid — scrollxui spotlightcard */}
            <section className="pb-4 pt-6">
                <div className="container-site grid gap-5 md:grid-cols-2">
                    {services.map((service) => (
                        <SpotlightCard key={service.id} className="p-6">
                            <div className="flex items-start gap-5">
                                <span className="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-rose-soft text-rose-deep">
                                    <Icon name={service.icon} className="h-5 w-5" />
                                </span>
                                <div>
                                    <h3 className="font-display text-[17px] font-bold">{service.title}</h3>
                                    <p className="mt-1.5 text-[14.5px] leading-relaxed text-ink-soft">{service.summary}</p>
                                    {service.roles?.length > 0 && (
                                        <div className="mt-3.5 flex flex-wrap gap-2">
                                            {service.roles.slice(0, 3).map((role) => (
                                                <span key={role} className="rounded-pill border border-hairline px-3 py-1 text-[12px] font-semibold text-ink-soft">
                                                    {role}
                                                </span>
                                            ))}
                                        </div>
                                    )}
                                    <Link
                                        href={`/services/${service.slug}`}
                                        className="group mt-3.5 inline-flex items-center gap-1.5 text-[14px] font-bold text-rose-deep"
                                    >
                                        What's included
                                        <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" strokeWidth={2.4} />
                                    </Link>
                                </div>
                            </div>
                        </SpotlightCard>
                    ))}

                    <SpotlightCard className="bg-rose-soft p-6" spotlightColor="rgba(255,255,255,0.45)">
                        <div className="flex items-start gap-5">
                            <span className="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white text-rose-deep">
                                <HardHat className="h-5 w-5" strokeWidth={2.2} />
                            </span>
                            <div>
                                <h3 className="font-display text-[17px] font-bold">
                                    {setting('team_construction_title', 'Construction & Trades Admin')}
                                </h3>
                                <p className="mt-1.5 text-[14.5px] leading-relaxed text-ink-soft">
                                    {setting('team_construction_summary', 'Quoting follow-ups, subcontractor scheduling, procurement paperwork, and compliance documentation kept moving between site and office.')}
                                </p>
                                <Link
                                    href="/who-we-work-with/construction-trades"
                                    className="group mt-3.5 inline-flex items-center gap-1.5 text-[14px] font-bold text-rose-deep"
                                >
                                    See how it works for your sector
                                    <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" strokeWidth={2.4} />
                                </Link>
                            </div>
                        </div>
                    </SpotlightCard>
                </div>
            </section>

            {/* how we build it — sage block */}
            <section className="section">
                <div className="container-site">
                    <motion.div
                        initial={{ opacity: 0, y: 32 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6 }}
                        className="block-sage"
                    >
                        <p className="t-eyebrow mb-3">{setting('team_process_eyebrow', 'How we build your team')}</p>
                        <RevealText text={setting('team_process_heading', 'Matched to your sector, not assigned from a queue')} className="t-headline max-w-xl" />
                        <p className="mt-3 max-w-xl opacity-80">
                            {setting('team_process_intro', 'The same discovery-to-onboarded path applies whether you need one assistant or a small rostered team.')}
                        </p>
                        <div className="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                            {processSteps.map((step, i) => (
                                <motion.div
                                    key={step.id}
                                    initial={{ opacity: 0, y: 20 }}
                                    whileInView={{ opacity: 1, y: 0 }}
                                    viewport={{ once: true }}
                                    transition={{ duration: 0.45, delay: i * 0.08 }}
                                >
                                    <span className="t-caption text-sage-deep">{step.number} — {step.title}</span>
                                    <h3 className="mt-2.5 font-display text-[17px] font-bold">{step.title}</h3>
                                    <p className="mt-2 text-[14.5px] leading-relaxed opacity-75">{step.summary}</p>
                                </motion.div>
                            ))}
                        </div>
                    </motion.div>
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
