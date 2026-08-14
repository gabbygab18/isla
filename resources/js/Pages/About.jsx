import { Link, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, Check } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import RevealText from '@/components/scrollxui/RevealText';
import Showcase from '@/components/scrollxui/Showcase';
import SpotlightCard from '@/components/scrollxui/SpotlightCard';
import AboutPhilippines from '@/components/site/AboutPhilippines';
import CtaBand from '@/components/site/CtaBand';
import Icon from '@/components/site/Icon';
import PageHero from '@/components/site/PageHero';
import SectionHead from '@/components/site/SectionHead';
import { makeSetting } from '@/lib/utils';

export default function About({ benefits = [], audiences = [] }) {
    const setting = makeSetting(usePage().props?.settings);


    return (
        <SiteLayout title="About Us" description={setting('about_intro', 'Isla is a managed virtual staffing partner for Australian businesses, run by a Philippines-based team.')}>
            <PageHero
                crumbs={[{ label: 'About' }]}
                eyebrow={setting('about_eyebrow', 'About Isla')}
                heading={setting('about_heading', "Built by people who understand the work behind business growth")}
                lede={setting('about_intro', 'Isla was built from hands-on experience supporting Australian businesses where administration, compliance, workforce coordination, documentation and client communication could not be treated as simple back-office tasks.')}
            />

            {/* our story — scrollxui showcase (media/text feature row) */}
            <section className="section-tight">
                <div className="container-site">
                    <Showcase
                        items={[
                            {
                                media: (
                                    <img
                                        src={setting('about_image', 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1000&q=80&auto=format&fit=crop')}
                                        alt="The Isla team collaborating"
                                        className="aspect-[4/3.4] w-full rounded-xl object-cover shadow-float"
                                    />
                                ),
                                text: (
                                    <div>
                                        <p className="t-eyebrow mb-3 text-sage-deep">{setting('about_story_eyebrow', 'Our story')}</p>
                                        <RevealText text={setting('about_story_heading', 'A managed staffing partner, not a freelancer marketplace')} className="t-headline" />
                                        <p className="mt-5 leading-relaxed text-ink-soft">
                                            {setting('about_story_body_1', "We saw capable business owners and leaders spending too much time managing recruitment, onboarding, payroll, systems, follow-ups and everyday operational work. Traditional outsourcing models often provided a candidate but left the client responsible for everything that came afterwards. Isla was created to provide a more accountable solution: capable offshore professionals supported by structured recruitment, onboarding, workforce management and ongoing operational oversight.")}
                                        </p>
                                        <p className="mt-4 leading-relaxed text-ink-soft">
                                            {setting('about_story_body_2', "With a freelancer marketplace, the service often ends after an introduction. With Isla, that is where the partnership begins. Your dedicated professional works an agreed schedule aligned with your Australian operating hours, while Isla provides the workforce infrastructure behind them — payroll administration, HR support, account management, IT assistance, productivity oversight and performance management. Our purpose is not simply to fill seats: it is to help businesses build dependable capacity and create more room for sustainable growth.")}
                                        </p>
                                    </div>
                                ),
                            },
                        ]}
                    />
                </div>
            </section>


            {/* about the philippines — accordion */}
            <AboutPhilippines />

            {/* values — scrollxui spotlightcard */}
            <section className="section-tight">
                <div className="container-site">
                    <SectionHead
                        eyebrow={setting('about_values_eyebrow', 'What we hold ourselves to')}
                        heading={setting('about_values_heading', 'What working with Isla gives you')}
                        intro={setting('about_values_intro', 'The same commitments show up in every engagement, regardless of sector or size.')}
                    />
                    <div className="grid gap-5 sm:grid-cols-2">
                        {benefits.map((benefit) => (
                            <SpotlightCard key={benefit.id}>
                                <span className="mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-rose-soft text-rose-deep">
                                    <Check className="h-4.5 w-4.5 h-[18px] w-[18px]" strokeWidth={2.4} />
                                </span>
                                <h3 className="t-card-title">{benefit.title}</h3>
                                <p className="mt-2 text-[15px] leading-relaxed text-ink-soft">{benefit.summary}</p>
                            </SpotlightCard>
                        ))}
                    </div>
                </div>
            </section>

            {/* industries */}
            <section className="section-tight">
                <div className="container-site">
                    <SectionHead
                        eyebrow={setting('audiences_eyebrow', 'Who we work with')}
                        eyebrowColor="text-sage-deep"
                        heading={setting('about_industries_heading', 'The industries we build assistants around')}
                    />
                    <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        {audiences.map((audience, i) => (
                            <motion.div
                                key={audience.id}
                                initial={{ opacity: 0, y: 22 }}
                                whileInView={{ opacity: 1, y: 0 }}
                                viewport={{ once: true }}
                                transition={{ duration: 0.45, delay: i * 0.06 }}
                            >
                                <Link
                                    href={`/who-we-work-with/${audience.slug}`}
                                    className="group flex h-full flex-col rounded-lg border border-hairline-soft bg-white p-6 transition-all hover:-translate-y-1 hover:shadow-card"
                                >
                                    <span className="mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-sage-soft text-sage-deep">
                                        <Icon name={audience.icon} className="h-[18px] w-[18px]" />
                                    </span>
                                    <h3 className="font-display text-[16px] font-bold">{audience.title}</h3>
                                    <span className="mt-3 inline-flex items-center gap-1.5 text-[13.5px] font-bold text-sage-deep">
                                        Learn more <ArrowRight className="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" strokeWidth={2.4} />
                                    </span>
                                </Link>
                            </motion.div>
                        ))}
                    </div>
                </div>
            </section>

            <CtaBand />
        </SiteLayout>
    );
}
