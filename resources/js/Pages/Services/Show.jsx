import { motion } from 'framer-motion';
import { ArrowRight, CalendarHeart, Check } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import Card from '@/components/scrollxui/Card';
import Slider from '@/components/scrollxui/Slider';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import CtaBand from '@/components/site/CtaBand';
import Icon from '@/components/site/Icon';
import PageHero from '@/components/site/PageHero';
import SectionHead from '@/components/site/SectionHead';

export default function ServiceShow({ service, related = [] }) {
    return (
        <SiteLayout title={service.title} description={service.summary}>
            <PageHero
                crumbs={[{ label: 'Services', href: '/services' }, { label: service.title }]}
                eyebrow="Services"
                heading={service.title}
                lede={service.summary}
            />

            <section className="pb-8 pt-6">
                <div className="container-site grid gap-10 lg:grid-cols-[1.5fr_1fr]">
                    <motion.div
                        initial={{ opacity: 0, y: 24 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.55 }}
                    >
                        <span className="mb-7 flex h-14 w-14 items-center justify-center rounded-full bg-rose-soft text-rose-deep">
                            <Icon name={service.icon} className="h-6 w-6" />
                        </span>
                        <div className="flex max-w-2xl flex-col gap-4 text-[16.5px] leading-relaxed text-ink-soft">
                            {String(service.body ?? '').split(/\n\n+/).map((para, i) => (
                                <p key={i}>{para}</p>
                            ))}
                        </div>
                        {service.deliverables?.length > 0 && (
                            <>
                                <h3 className="t-card-title mb-4 mt-9">What's included</h3>
                                <ul className="flex max-w-2xl flex-col gap-3.5">
                                    {service.deliverables.map((item, i) => (
                                        <motion.li
                                            key={i}
                                            initial={{ opacity: 0, x: 16 }}
                                            whileInView={{ opacity: 1, x: 0 }}
                                            viewport={{ once: true }}
                                            transition={{ duration: 0.4, delay: i * 0.06 }}
                                            className="flex items-start gap-3.5"
                                        >
                                            <span className="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-deep text-cream">
                                                <Check className="h-3 w-3" strokeWidth={3} />
                                            </span>
                                            <span className="text-[15.5px]">{item}</span>
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
                        <h3 className="t-card-title">Hand this off</h3>
                        <p className="mt-2 text-[15px] leading-relaxed text-ink-soft">
                            Tell us what's eating your hours and we'll match an assistant who can take it on.
                        </p>
                        <div className="mt-6 flex flex-col gap-3">
                            <StaggerButton href="/book-a-call" icon={CalendarHeart} className="w-full">
                                Book a Discovery Call
                            </StaggerButton>
                            <StaggerButton href="/contact" variant="secondary" className="w-full">
                                Request a VA
                            </StaggerButton>
                        </div>
                    </motion.aside>
                </div>
            </section>

            {/* roles we support */}
            {service.roles?.length > 0 && (
                <section className="section pt-2">
                    <div className="container-site">
                        <SectionHead
                            center
                            eyebrow="Roles we support"
                            eyebrowColor="text-sage-deep"
                            heading={`${service.title} roles you can outsource`}
                            intro="Every role below can be filled by a dedicated Isla assistant — matched to your business, working your hours, backed by our lifetime replacement guarantee."
                        />
                        <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            {service.roles.map((role, i) => (
                                <motion.div
                                    key={role}
                                    initial={{ opacity: 0, y: 22 }}
                                    whileInView={{ opacity: 1, y: 0 }}
                                    viewport={{ once: true }}
                                    transition={{ duration: 0.45, delay: i * 0.06 }}
                                    className="relative overflow-hidden rounded-lg bg-ink p-7 text-cream transition-transform duration-300 hover:-translate-y-1 hover:shadow-deep"
                                >
                                    <span
                                        aria-hidden="true"
                                        className="absolute inset-y-0 left-0 w-1"
                                        style={{ background: 'linear-gradient(180deg, #db9496 0%, #8f9d77 100%)' }}
                                    />
                                    <span className="mb-4 flex h-9 w-9 items-center justify-center rounded-full bg-sage-deep">
                                        <Check className="h-4 w-4" strokeWidth={2.6} />
                                    </span>
                                    <h3 className="font-display text-[19px] font-bold text-rose">{role}</h3>
                                    <p className="t-caption mt-2 text-cream/55">Dedicated · Full-time or part-time · AU business hours</p>
                                </motion.div>
                            ))}
                        </div>
                        <div className="mt-9 flex flex-wrap items-center justify-between gap-5 rounded-lg bg-sage-soft px-7 py-6">
                            <p className="text-[15.5px] text-ink-soft">Don't see the exact role you need? We build custom roles all the time.</p>
                            <StaggerButton href="/book-a-call" icon={CalendarHeart}>
                                Book a Discovery Call
                            </StaggerButton>
                        </div>
                    </div>
                </section>
            )}

            {related.length > 0 && (
                <section className="section pt-0">
                    <div className="container-site">
                        <p className="t-eyebrow mb-3 text-rose-deep">More services</p>
                        <h2 className="t-headline mb-8">Other things your assistant can take on</h2>
                        <Slider>
                            {related.map((item) => (
                                <Card key={item.id} href={`/services/${item.slug}`} className="flex h-full flex-col">
                                    <span className="mb-5 flex h-11 w-11 items-center justify-center rounded-full bg-rose-soft text-rose-deep">
                                        <Icon name={item.icon} className="h-5 w-5" />
                                    </span>
                                    <h3 className="t-card-title">{item.title}</h3>
                                    <p className="mt-2.5 flex-1 text-[15px] leading-relaxed text-ink-soft">{item.summary}</p>
                                    <span className="mt-5 inline-flex items-center gap-2 text-[14px] font-bold text-rose-deep">
                                        Learn more <ArrowRight className="h-4 w-4" strokeWidth={2.4} />
                                    </span>
                                </Card>
                            ))}
                        </Slider>
                    </div>
                </section>
            )}

            <CtaBand />
        </SiteLayout>
    );
}
