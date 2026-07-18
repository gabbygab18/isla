import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, CalendarHeart, Check } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import Card from '@/components/scrollxui/Card';
import Slider from '@/components/scrollxui/Slider';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import CtaBand from '@/components/site/CtaBand';
import Icon from '@/components/site/Icon';
import PageHero from '@/components/site/PageHero';

export default function AudienceShow({ audience, related = [] }) {
    return (
        <SiteLayout title={audience.title} description={audience.summary}>
            <PageHero
                crumbs={[{ label: 'Who We Work With', href: '/who-we-work-with' }, { label: audience.title }]}
                eyebrow="Who we work with"
                eyebrowColor="text-sage-deep"
                heading={audience.title}
                lede={audience.summary}
            />

            <section className="pb-8 pt-6">
                <div className="container-site grid gap-10 lg:grid-cols-[1.5fr_1fr]">
                    <motion.div
                        initial={{ opacity: 0, y: 24 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.55 }}
                    >
                        <span className="mb-7 flex h-14 w-14 items-center justify-center rounded-full bg-sage-soft text-sage-deep">
                            <Icon name={audience.icon} className="h-6 w-6" />
                        </span>
                        <div className="flex max-w-2xl flex-col gap-4 text-[16.5px] leading-relaxed text-ink-soft">
                            {String(audience.body ?? '').split(/\n\n+/).map((para, i) => (
                                <p key={i}>{para}</p>
                            ))}
                        </div>
                        {audience.points?.length > 0 && (
                            <>
                                <h3 className="t-card-title mb-4 mt-9">What that looks like</h3>
                                <ul className="flex max-w-2xl flex-col gap-3.5">
                                    {audience.points.map((point, i) => (
                                        <motion.li
                                            key={i}
                                            initial={{ opacity: 0, x: 16 }}
                                            whileInView={{ opacity: 1, x: 0 }}
                                            viewport={{ once: true }}
                                            transition={{ duration: 0.4, delay: i * 0.06 }}
                                            className="flex items-start gap-3.5"
                                        >
                                            <span className="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-sage-deep text-cream">
                                                <Check className="h-3 w-3" strokeWidth={3} />
                                            </span>
                                            <span className="text-[15.5px]">{point}</span>
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
                            Tell us what's eating your hours and we'll match an assistant who understands your sector.
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

            {related.length > 0 && (
                <section className="section pt-0">
                    <div className="container-site">
                        <p className="t-eyebrow mb-3 text-sage-deep">More sectors</p>
                        <h2 className="t-headline mb-8">Also built for</h2>
                        {/* scrollxui: slider — related rail */}
                        <Slider>
                            {related.map((item) => (
                                <Card key={item.id} href={`/who-we-work-with/${item.slug}`} className="flex h-full flex-col">
                                    <span className="mb-5 flex h-11 w-11 items-center justify-center rounded-full bg-sage-soft text-sage-deep">
                                        <Icon name={item.icon} className="h-5 w-5" />
                                    </span>
                                    <h3 className="t-card-title">{item.title}</h3>
                                    <p className="mt-2.5 flex-1 text-[15px] leading-relaxed text-ink-soft">{item.summary}</p>
                                    <span className="mt-5 inline-flex items-center gap-2 text-[14px] font-bold text-sage-deep">
                                        Learn more <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" strokeWidth={2.4} />
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
