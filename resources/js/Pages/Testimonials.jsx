import { usePage } from '@inertiajs/react';
import SiteLayout from '@/Layouts/SiteLayout';
import KineticTestimonialCards from '@/components/scrollxui/KineticTestimonialCards';
import CtaBand from '@/components/site/CtaBand';
import PageHero from '@/components/site/PageHero';
import { makeSetting } from '@/lib/utils';

export default function Testimonials({ testimonials = [] }) {
    const setting = makeSetting(usePage().props?.settings);

    return (
        <SiteLayout
            title="Testimonials"
            description={setting('testimonials_heading', 'What our clients say about working with Isla')}
        >
            <PageHero
                crumbs={[{ label: 'Testimonials' }]}
                eyebrow={setting('testimonials_eyebrow', 'Testimonials')}
                heading={setting('testimonials_heading', 'What our clients say about working with Isla')}
            />

            <section className="pb-8 pt-6">
                <div className="container-site">
                    {testimonials.length > 0 ? (
                        // scrollxui: kinetic-testimonials
                        <KineticTestimonialCards items={testimonials} />
                    ) : (
                        <p className="py-10 text-center text-[15.5px] text-ink-soft">
                            Client stories are on their way — check back soon.
                        </p>
                    )}
                </div>
            </section>

            <CtaBand />
        </SiteLayout>
    );
}
