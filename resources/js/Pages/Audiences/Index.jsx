import { Link, usePage } from '@inertiajs/react';
import { ArrowRight } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import { BentoGrid, BentoItem } from '@/components/scrollxui/BentoGrid';
import CtaBand from '@/components/site/CtaBand';
import Icon from '@/components/site/Icon';
import PageHero from '@/components/site/PageHero';
import { makeSetting } from '@/lib/utils';

export default function AudiencesIndex({ audiences = [] }) {
    const setting = makeSetting(usePage().props?.settings);

    return (
        <SiteLayout title="Who We Work With" description={setting('audiences_intro', 'The sectors Isla builds dedicated assistants around.')}>
            <PageHero
                crumbs={[{ label: 'Who We Work With' }]}
                eyebrow={setting('audiences_eyebrow', 'Who we work with')}
                eyebrowColor="text-sage-deep"
                heading={setting('audiences_heading', "Built for the work that can't be generic")}
                lede={setting('audiences_intro', 'Most virtual staffing agencies are horizontal generalists. Isla is built around the groups whose paperwork actually carries risk.')}
            />

            <section className="pb-4 pt-6">
                <div className="container-site">
                    <BentoGrid>
                        {audiences.map((audience, i) => (
                            <BentoItem key={audience.id} index={i} span={i % 3 === 0 ? 2 : 1} className="group p-0">
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

            <CtaBand />
        </SiteLayout>
    );
}
