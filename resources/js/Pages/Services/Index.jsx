import { Link, usePage } from '@inertiajs/react';
import { ArrowRight } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import Showcase from '@/components/scrollxui/Showcase';
import CtaBand from '@/components/site/CtaBand';
import Icon from '@/components/site/Icon';
import PageHero from '@/components/site/PageHero';
import { makeSetting } from '@/lib/utils';

export default function ServicesIndex({ services = [] }) {
    const setting = makeSetting(usePage().props?.settings);

    return (
        <SiteLayout title="Services" description={setting('services_heading', 'What your assistant can take off your plate')}>
            <PageHero
                crumbs={[{ label: 'Services' }]}
                eyebrow={setting('services_eyebrow', 'Services')}
                heading={setting('services_heading', 'What your assistant can take off your plate')}
            />

            {/* scrollxui: showcase — alternating service feature rows */}
            <section className="pb-8 pt-6">
                <div className="container-site">
                    <Showcase
                        items={services}
                        renderMedia={(service, i) => (
                            <div className={`flex aspect-[4/2.9] items-center justify-center rounded-xl ${i % 2 === 0 ? 'bg-rose-soft' : 'bg-sage-soft'}`}>
                                <span className={`flex h-24 w-24 items-center justify-center rounded-full bg-white shadow-card ${i % 2 === 0 ? 'text-rose-deep' : 'text-sage-deep'}`}>
                                    <Icon name={service.icon} className="h-10 w-10" strokeWidth={1.8} />
                                </span>
                            </div>
                        )}
                        renderText={(service) => (
                            <div>
                                <h2 className="t-headline">{service.title}</h2>
                                <p className="mt-3 max-w-lg leading-relaxed text-ink-soft">{service.summary}</p>
                                {service.roles?.length > 0 && (
                                    <div className="mt-5 flex flex-wrap gap-2">
                                        {service.roles.slice(0, 4).map((role) => (
                                            <span key={role} className="rounded-pill border border-hairline bg-white px-3.5 py-1.5 text-[12.5px] font-semibold text-ink-soft">
                                                {role}
                                            </span>
                                        ))}
                                    </div>
                                )}
                                <Link
                                    href={`/services/${service.slug}`}
                                    className="group mt-6 inline-flex items-center gap-2 text-[15px] font-bold text-rose-deep"
                                >
                                    What's included
                                    <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" strokeWidth={2.4} />
                                </Link>
                            </div>
                        )}
                    />
                </div>
            </section>

            <CtaBand />
        </SiteLayout>
    );
}
