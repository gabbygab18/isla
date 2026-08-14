import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, Check } from 'lucide-react';
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
    const [showAll, setShowAll] = useState(false);
    const visibleServices = showAll ? services : services.slice(0, 8);

    return (
        <SiteLayout title="Team We Build" description={setting('team_meta', 'The roles Isla places, and how they come together into a team around your business.')}>
            <PageHero
                crumbs={[{ label: 'Team We Build' }]}
                eyebrow={setting('team_eyebrow', 'Team we build')}
                heading={setting('team_heading', 'The team we build around your business')}
                lede={setting('team_intro', 'Build additional capacity without carrying the full recruitment, employment and workforce management burden internally. Start with one dedicated professional or build a small team across multiple business functions — every role is recruited around your requirements, assessed for capability, prepared for your operating environment and supported by Isla throughout the engagement.')}
            />

            {/* role grid — scrollxui spotlightcard */}
            <section className="pb-4 pt-6">
                <div className="container-site grid gap-5 md:grid-cols-2">
                    {visibleServices.map((service) => (
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
                </div>
                {services.length > 8 && !showAll && (
                    <div className="mt-8 flex justify-center">
                        <button
                            type="button"
                            onClick={() => setShowAll(true)}
                            className="rounded-pill border border-hairline bg-white px-6 py-3 text-[14px] font-bold text-rose-deep transition-colors hover:border-rose-deep"
                        >
                            {setting('team_view_all_label', 'View all teams we build')}
                        </button>
                    </div>
                )}
            </section>

            {/* more than recruitment */}
            <section className="section">
                <div className="container-site">
                    <motion.div
                        initial={{ opacity: 0, y: 32 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6 }}
                        className="block-sage"
                    >
                        <p className="t-eyebrow mb-3">{setting('team_mtr_eyebrow', 'More than recruitment')}</p>
                        <RevealText text={setting('team_mtr_heading', 'Every Isla engagement includes more than candidate sourcing')} className="t-headline max-w-2xl" />
                        <p className="mt-3 max-w-xl text-ink-soft">{setting('team_mtr_intro', 'Your inclusive hourly rate may include:')}</p>
                        <ul className="mt-8 grid gap-x-8 gap-y-3 sm:grid-cols-2 lg:grid-cols-3">
                            {[
                                'Recruitment and candidate sourcing',
                                'Candidate screening and shortlisting',
                                'Employment and contractor onboarding',
                                'Payroll administration',
                                'HR and workforce support',
                                'Dedicated Account Manager',
                                'Performance management support',
                                'Productivity monitoring',
                                'IT assistance',
                                'Standard dedicated equipment',
                                'Confidentiality and data-handling requirements',
                                'Ongoing replacement and workforce continuity support',
                            ].map((item) => (
                                <li key={item} className="flex items-start gap-2.5 text-[14.5px] leading-relaxed">
                                    <Check className="mt-0.5 h-4 w-4 shrink-0 text-sage-deep" strokeWidth={2.6} />
                                    {item}
                                </li>
                            ))}
                        </ul>
                        <p className="mt-8 max-w-2xl text-[15px] leading-relaxed text-ink-soft">
                            {setting('team_mtr_outro', 'You manage the business priorities and desired outcomes. Isla supports the recruitment, people management and workforce infrastructure behind your offshore team.')}
                        </p>
                    </motion.div>
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
                        <RevealText text={setting('team_process_heading', 'Matched to your industry, not assigned from a queue')} className="t-headline max-w-xl" />
                        <p className="mt-3 max-w-xl opacity-80">
                            {setting('team_process_intro', 'The same discovery-to-onboarded path applies whether you need one assistant or a small rostered team.')}
                        </p>
                        <div className="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
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

            <CtaBand
                heading={setting('team_cta_heading', 'Build the team your business needs')}
                lede={setting('team_cta_lede', 'Tell us where your team is experiencing pressure, and we will help identify the roles, capabilities and working structure that can provide the greatest value.')}
            />
        </SiteLayout>
    );
}
