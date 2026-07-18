import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { CalendarHeart } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import ExpandableCards from '@/components/scrollxui/ExpandableCards';
import RevealText from '@/components/scrollxui/RevealText';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import CtaBand from '@/components/site/CtaBand';
import PageHero from '@/components/site/PageHero';

export default function FaqShow({ faq, others = [] }) {
    const shortQ = faq.question.length > 40 ? `${faq.question.slice(0, 40)}…` : faq.question;

    return (
        <SiteLayout title={faq.question} description={String(faq.answer ?? '').slice(0, 155)}>
            <PageHero
                crumbs={[{ label: 'FAQ', href: '/faq' }, { label: shortQ }]}
                eyebrow="Frequently asked"
                heading={faq.question}
            />

            <section className="pb-8 pt-6">
                <div className="container-site grid gap-10 lg:grid-cols-[1.5fr_1fr]">
                    <motion.div
                        initial={{ opacity: 0, y: 24 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.55 }}
                        className="flex max-w-2xl flex-col gap-4 text-[16.5px] leading-relaxed text-ink-soft"
                    >
                        {String(faq.answer ?? '').split(/\n\n+/).map((para, i) => (
                            <p key={i}>{para}</p>
                        ))}
                    </motion.div>

                    <motion.aside
                        initial={{ opacity: 0, y: 24 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.55, delay: 0.1 }}
                        className="h-fit rounded-lg bg-rose-soft p-8 lg:sticky lg:top-28"
                    >
                        <h3 className="t-card-title">Still have questions?</h3>
                        <p className="mt-2 text-[15px] leading-relaxed text-ink-soft">
                            The quickest answer is usually a short call. We'll walk you through anything specific to your sector.
                        </p>
                        <div className="mt-6 flex flex-col gap-3">
                            <StaggerButton href="/book-a-call" icon={CalendarHeart} className="w-full">
                                Book a Discovery Call
                            </StaggerButton>
                            <StaggerButton href="/contact" variant="secondary" className="w-full">
                                Send an enquiry
                            </StaggerButton>
                        </div>
                    </motion.aside>
                </div>
            </section>

            {others.length > 0 && (
                <section className="section pt-0">
                    <div className="container-site">
                        <div className="block-rose">
                            <p className="t-eyebrow mb-3 text-center">More answers</p>
                            <RevealText text="Other common questions" className="t-headline mx-auto mb-10 max-w-2xl text-center" />
                            <ExpandableCards
                                items={others.map((item) => ({
                                    id: item.id,
                                    title: item.question,
                                    content: <p>{item.answer}</p>,
                                    slug: item.slug,
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
            )}

            <CtaBand />
        </SiteLayout>
    );
}
