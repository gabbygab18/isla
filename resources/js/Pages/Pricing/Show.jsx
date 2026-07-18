import { motion } from 'framer-motion';
import { CalendarHeart, Check } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import CtaBand from '@/components/site/CtaBand';
import PageHero from '@/components/site/PageHero';
import PricingGrid from '@/components/site/PricingGrid';

export default function PlanShow({ plan, others = [] }) {
    return (
        <SiteLayout title={`${plan.name} plan`} description={plan.summary}>
            <PageHero
                crumbs={[{ label: 'Pricing', href: '/pricing' }, { label: plan.name }]}
                eyebrow={plan.tag}
                heading={plan.name}
                lede={plan.summary}
            >
                {plan.ribbon && (
                    <span className="mt-4 inline-block rounded-pill bg-rose px-4 py-1.5 text-[12px] font-bold uppercase tracking-wider text-ink">
                        {plan.ribbon}
                    </span>
                )}
            </PageHero>

            <section className="pb-8 pt-6">
                <div className="container-site grid gap-10 lg:grid-cols-[1.5fr_1fr]">
                    <motion.div
                        initial={{ opacity: 0, y: 24 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.55 }}
                    >
                        <p className="font-display text-[30px] font-medium tracking-tight">{plan.detail}</p>
                        <div className="mt-6 flex max-w-2xl flex-col gap-4 text-[16.5px] leading-relaxed text-ink-soft">
                            {String(plan.body ?? '').split(/\n\n+/).map((para, i) => (
                                <p key={i}>{para}</p>
                            ))}
                        </div>
                        {plan.features?.length > 0 && (
                            <>
                                <h3 className="t-card-title mb-4 mt-9">What's included</h3>
                                <ul className="flex max-w-2xl flex-col gap-3.5">
                                    {plan.features.map((feature, i) => (
                                        <motion.li
                                            key={i}
                                            initial={{ opacity: 0, x: 16 }}
                                            whileInView={{ opacity: 1, x: 0 }}
                                            viewport={{ once: true }}
                                            transition={{ duration: 0.4, delay: i * 0.05 }}
                                            className="flex items-start gap-3.5"
                                        >
                                            <span className="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-deep text-cream">
                                                <Check className="h-3 w-3" strokeWidth={3} />
                                            </span>
                                            <span className="text-[15.5px]">{feature}</span>
                                        </motion.li>
                                    ))}
                                </ul>
                            </>
                        )}
                    </motion.div>

                    <motion.aside
                        initial={{ opacity: 0, y: 24 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.55, delay: 0.1 }}
                        className="h-fit rounded-lg bg-rose-soft p-8 lg:sticky lg:top-28"
                    >
                        <h3 className="t-card-title">Request a quote</h3>
                        <p className="mt-2 text-[15px] leading-relaxed text-ink-soft">
                            Every engagement is scoped to your hours and sector. Your discovery call gets you an exact quote.
                        </p>
                        <div className="mt-6 flex flex-col gap-3">
                            <StaggerButton href="/contact" className="w-full">
                                Request a quote
                            </StaggerButton>
                            <StaggerButton href="/book-a-call" variant="secondary" icon={CalendarHeart} className="w-full">
                                Book a call
                            </StaggerButton>
                        </div>
                    </motion.aside>
                </div>
            </section>

            {others.length > 0 && (
                <section className="section pt-0">
                    <div className="container-site">
                        <p className="t-eyebrow mb-3 text-rose-deep">Compare plans</p>
                        <h2 className="t-headline mb-8">Other ways to work with Isla</h2>
                        <PricingGrid plans={others} />
                    </div>
                </section>
            )}

            <CtaBand />
        </SiteLayout>
    );
}
