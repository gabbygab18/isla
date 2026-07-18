import { Link, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, CalendarHeart, Check, Clock } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import { BentoGrid, BentoItem } from '@/components/scrollxui/BentoGrid';
import ExpandableCards from '@/components/scrollxui/ExpandableCards';
import LayerStack from '@/components/scrollxui/LayerStack';
import OrbButton from '@/components/scrollxui/OrbButton';
import RevealText from '@/components/scrollxui/RevealText';
import SpotlightCard from '@/components/scrollxui/SpotlightCard';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import ContactBlock from '@/components/site/ContactBlock';
import CtaBand from '@/components/site/CtaBand';
import Icon from '@/components/site/Icon';
import PricingGrid from '@/components/site/PricingGrid';
import SectionHead from '@/components/site/SectionHead';
import TrustBar from '@/components/site/TrustBar';
import { makeSetting } from '@/lib/utils';

export default function Home({ audiences = [], services = [], pricingPlans = [], processSteps = [], benefits = [], faqs = [] }) {
    const setting = makeSetting(usePage().props?.settings);

    const heroImage = setting('hero_image', 'https://images.unsplash.com/photo-1766066014237-00645c74e9c6?w=1200&q=80&auto=format&fit=crop');

    return (
        <SiteLayout description={setting('hero_subtitle', 'Isla places dedicated virtual assistants for NDIS providers, healthcare and allied health practices, and growing Australian businesses.')}>
            {/* ── HERO ─────────────────────────────────────────────── */}
            <section className="pt-12 md:pt-20">
                <div className="container-site grid items-center gap-12 lg:grid-cols-[1.05fr_0.95fr]">
                    <div>
                        <motion.p
                            initial={{ opacity: 0, y: 12 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.5 }}
                            className="t-eyebrow mb-4 text-sage-deep"
                        >
                            {setting('hero_eyebrow', 'Managed virtual staffing for Australian businesses')}
                        </motion.p>
                        <RevealText
                            as="h1"
                            text={setting('hero_title', 'Delegate the admin.\nProtect the care.')}
                            className="t-display-xl"
                        />
                        <motion.p
                            initial={{ opacity: 0, y: 16 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.55, delay: 0.35 }}
                            className="t-body-lg mt-6 max-w-xl text-ink-soft"
                        >
                            {setting('hero_subtitle', 'Isla places dedicated virtual assistants for NDIS providers, healthcare and allied health practices, and growing Australian businesses — people who understand participant confidentiality and compliance paperwork from day one.')}
                        </motion.p>
                        <motion.div
                            initial={{ opacity: 0, y: 16 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.55, delay: 0.5 }}
                            className="mt-9 flex flex-wrap items-center gap-3.5"
                        >
                            <OrbButton href="/book-a-call" icon={CalendarHeart}>
                                {setting('hero_cta_label', 'Book a Discovery Call')}
                            </OrbButton>
                            <StaggerButton href="/how-it-works" variant="secondary" iconRight={ArrowRight}>
                                See how it works
                            </StaggerButton>
                        </motion.div>
                    </div>

                    {/* hero visual — scrollxui layer-stack */}
                    <LayerStack
                        className="mx-auto w-full max-w-[520px]"
                        layers={[
                            {
                                rotate: -2,
                                className: 'absolute inset-0 rounded-xl bg-sage-soft',
                                content: <span className="sr-only" />,
                            },
                            {
                                rotate: 1.5,
                                className: 'absolute inset-0 rounded-xl bg-rose-soft',
                                content: <span className="sr-only" />,
                            },
                            {
                                rotate: 0,
                                className: 'relative overflow-hidden rounded-xl shadow-float',
                                content: (
                                    <img
                                        src={heroImage}
                                        alt="A virtual assistant working at her desk"
                                        className="aspect-[4/4.4] w-full object-cover"
                                    />
                                ),
                            },
                            {
                                rotate: 0,
                                className: 'absolute -bottom-6 -left-4 md:-left-8',
                                content: (
                                    <div className="flex items-center gap-3.5 rounded-lg border border-hairline-soft bg-white px-5 py-4 shadow-float">
                                        <Clock className="h-7 w-7 text-rose-deep" strokeWidth={2} />
                                        <div>
                                            <strong className="block font-display text-lg font-bold leading-tight">
                                                {setting('hero_badge_strong', '20+ hrs')}
                                            </strong>
                                            <span className="text-[13px] text-ink-soft">
                                                {setting('hero_badge_text', 'given back to your team, most weeks')}
                                            </span>
                                        </div>
                                    </div>
                                ),
                            },
                        ]}
                    />
                </div>
            </section>

            {/* ── TRUST BAR ────────────────────────────────────────── */}
            <section className="section-tight">
                <div className="container-site">
                    <TrustBar />
                </div>
            </section>

            {/* ── WHO WE WORK WITH — scrollxui bento-grid ──────────── */}
            <section className="section" id="who-its-for">
                <div className="container-site">
                    <SectionHead
                        eyebrow={setting('audiences_eyebrow', 'Who we work with')}
                        eyebrowColor="text-sage-deep"
                        heading={setting('audiences_heading', "Built for the work that can't be generic")}
                        intro={setting('audiences_intro', 'Most virtual staffing agencies are horizontal generalists. Isla is built around three groups whose paperwork actually carries risk.')}
                    />
                    <BentoGrid>
                        {audiences.map((audience, i) => (
                            <BentoItem key={audience.id} index={i} span={i === 0 ? 2 : 1} className="group p-0">
                                <Link href={`/who-we-work-with/${audience.slug}`} className="flex h-full flex-col p-7">
                                    <span className="mb-5 flex h-12 w-12 items-center justify-center rounded-full bg-sage-soft text-sage-deep">
                                        <Icon name={audience.icon} className="h-[22px] w-[22px]" />
                                    </span>
                                    <h3 className="t-card-title">{audience.title}</h3>
                                    <p className="mt-2.5 flex-1 text-[15px] leading-relaxed text-ink-soft">{audience.summary}</p>
                                    <span className="mt-5 inline-flex items-center gap-2 text-[14px] font-bold text-sage-deep">
                                        Learn more
                                        <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" strokeWidth={2.4} />
                                    </span>
                                </Link>
                            </BentoItem>
                        ))}
                    </BentoGrid>
                </div>
            </section>

            {/* ── SERVICES — scrollxui spotlightcard ───────────────── */}
            <section className="section-tight" id="services">
                <div className="container-site">
                    <SectionHead
                        eyebrow={setting('services_eyebrow', 'Services')}
                        heading={setting('services_heading', 'What your assistant can take off your plate')}
                    />
                    <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {services.map((service) => (
                            <SpotlightCard key={service.id} as="div" className="group h-full">
                                <Link href={`/services/${service.slug}`} className="flex h-full flex-col">
                                    <span className="mb-5 flex h-11 w-11 items-center justify-center rounded-full bg-rose-soft text-rose-deep">
                                        <Icon name={service.icon} className="h-5 w-5" />
                                    </span>
                                    <h3 className="t-card-title">{service.title}</h3>
                                    <p className="mt-2.5 flex-1 text-[15px] leading-relaxed text-ink-soft">{service.summary}</p>
                                    {service.roles?.length > 0 && (
                                        <div className="mt-4 flex flex-wrap gap-2">
                                            {service.roles.slice(0, 3).map((role) => (
                                                <span key={role} className="rounded-pill border border-hairline px-3 py-1 text-[12px] font-semibold text-ink-soft">
                                                    {role}
                                                </span>
                                            ))}
                                        </div>
                                    )}
                                    <span className="mt-5 inline-flex items-center gap-2 text-[14px] font-bold text-rose-deep">
                                        Learn more
                                        <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" strokeWidth={2.4} />
                                    </span>
                                </Link>
                            </SpotlightCard>
                        ))}
                    </div>
                </div>
            </section>

            {/* ── HOW IT WORKS — sage block ─────────────────────────── */}
            <section className="section" id="how-it-works">
                <div className="container-site">
                    <motion.div
                        initial={{ opacity: 0, y: 32 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true, margin: '-8% 0px' }}
                        transition={{ duration: 0.6 }}
                        className="block-sage"
                    >
                        <p className="t-eyebrow mb-3">{setting('process_eyebrow', 'How it works')}</p>
                        <RevealText text={setting('process_heading', 'From discovery call to onboarded, in about two weeks')} className="t-headline max-w-xl" />
                        <p className="mt-3 max-w-xl opacity-80">
                            {setting('process_intro', 'A short, structured path — no lengthy procurement process, no ambiguity about what happens next.')}
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
                        <StaggerButton href="/how-it-works" variant="primary" iconRight={ArrowRight} className="mt-10">
                            See the full process
                        </StaggerButton>
                    </motion.div>
                </div>
            </section>

            {/* ── WHY ISLA — rose block ─────────────────────────────── */}
            <section className="section" id="why-isla">
                <div className="container-site">
                    <div className="block-rose">
                        <div className="grid items-center gap-10 lg:grid-cols-2 lg:gap-14">
                            <motion.img
                                initial={{ opacity: 0, scale: 0.96 }}
                                whileInView={{ opacity: 1, scale: 1 }}
                                viewport={{ once: true }}
                                transition={{ duration: 0.6 }}
                                src={setting('why_image', 'https://images.unsplash.com/photo-1762955911431-4c44c7c3f408?w=1000&q=80&auto=format&fit=crop')}
                                alt="A caregiver assisting an elderly couple"
                                className="aspect-[4/4.6] w-full rounded-md object-cover"
                            />
                            <div>
                                <p className="t-eyebrow mb-3">{setting('why_eyebrow', 'Why Isla')}</p>
                                <RevealText text={setting('why_heading', 'Straightforward, on purpose')} className="t-headline" />
                                <p className="mt-3 opacity-80">
                                    {setting('why_intro', 'The staffing industry is full of hidden markups and vague replacement policies. We built Isla around the opposite.')}
                                </p>
                                <ul className="mt-8 flex flex-col gap-5">
                                    {benefits.map((benefit, i) => (
                                        <motion.li
                                            key={benefit.id}
                                            initial={{ opacity: 0, x: 20 }}
                                            whileInView={{ opacity: 1, x: 0 }}
                                            viewport={{ once: true }}
                                            transition={{ duration: 0.4, delay: i * 0.07 }}
                                            className="flex gap-4"
                                        >
                                            <span className="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-ink text-cream">
                                                <Check className="h-3.5 w-3.5" strokeWidth={2.8} />
                                            </span>
                                            <div>
                                                <strong className="block font-display text-[16px] font-bold">{benefit.title}</strong>
                                                <span className="text-[14.5px] leading-relaxed opacity-75">{benefit.summary}</span>
                                            </div>
                                        </motion.li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ── PRICING — scrollxui lean-card grid ────────────────── */}
            <section className="section" id="pricing">
                <div className="container-site">
                    <SectionHead
                        center
                        eyebrow={setting('pricing_eyebrow', 'Pricing')}
                        heading={setting('pricing_heading', 'Pay for hours, not for guesswork')}
                        intro={setting('pricing_intro', 'Every engagement is scoped around your hours and sector — your discovery call gets you an exact quote.')}
                    />
                    <PricingGrid plans={pricingPlans} />
                </div>
            </section>

            {/* ── FAQ — scrollxui expandable-cards ──────────────────── */}
            <section className="section" id="faq">
                <div className="container-site">
                    <div className="block-rose">
                        <p className="t-eyebrow mb-3 text-center">{setting('faq_eyebrow', 'FAQ')}</p>
                        <RevealText
                            text={setting('faq_heading', 'Questions we get on almost every discovery call')}
                            className="t-headline mx-auto mb-10 max-w-2xl text-center"
                        />
                        <ExpandableCards
                            items={faqs.map((faq) => ({
                                id: faq.id,
                                title: faq.question,
                                content: <p>{faq.answer}</p>,
                                slug: faq.slug,
                            }))}
                            renderExtra={(item) => (
                                <Link href={`/faq/${item.slug}`} className="mt-3 inline-block font-bold text-rose-deep underline">
                                    Read more
                                </Link>
                            )}
                        />
                    </div>
                </div>
            </section>

            <CtaBand />

            <ContactBlock />
        </SiteLayout>
    );
}
