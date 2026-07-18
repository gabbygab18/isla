import { usePage } from '@inertiajs/react';
import SiteLayout from '@/Layouts/SiteLayout';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import CtaBand from '@/components/site/CtaBand';
import PageHero from '@/components/site/PageHero';
import PricingGrid from '@/components/site/PricingGrid';
import TrustBar from '@/components/site/TrustBar';
import { Calculator } from 'lucide-react';
import { makeSetting } from '@/lib/utils';

export default function PricingIndex({ pricingPlans = [] }) {
    const setting = makeSetting(usePage().props?.settings);

    return (
        <SiteLayout title="Pricing" description={setting('pricing_intro', 'Every engagement is scoped around your hours and sector.')}>
            <PageHero
                crumbs={[{ label: 'Pricing' }]}
                eyebrow={setting('pricing_eyebrow', 'Pricing')}
                heading={setting('pricing_heading', 'Pay for hours, not for guesswork')}
                lede={setting('pricing_intro', 'Every engagement is scoped around your hours and sector — your discovery call gets you an exact quote.')}
            />

            <section className="pb-4 pt-6">
                <div className="container-site">
                    <PricingGrid plans={pricingPlans} />
                    <div className="mt-9 flex flex-wrap items-center justify-between gap-5 rounded-lg bg-sage-soft px-7 py-6">
                        <p className="text-[15.5px] text-ink-soft">Want a figure for your exact role first? Try the estimator.</p>
                        <StaggerButton href="/cost-estimator" icon={Calculator} variant="secondary" className="bg-white">
                            Open the Cost Estimator
                        </StaggerButton>
                    </div>
                </div>
            </section>

            <section className="section-tight">
                <div className="container-site">
                    <TrustBar />
                </div>
            </section>

            <CtaBand />
        </SiteLayout>
    );
}
