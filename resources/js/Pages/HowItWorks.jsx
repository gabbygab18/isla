import { usePage } from '@inertiajs/react';
import { ArrowRight, Check } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import ParallaxCards from '@/components/scrollxui/ParallaxCards';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import CtaBand from '@/components/site/CtaBand';
import PageHero from '@/components/site/PageHero';
import { makeSetting } from '@/lib/utils';

export default function HowItWorks({ processSteps = [] }) {
    const setting = makeSetting(usePage().props?.settings);

    const cards = [
        ...processSteps.map((step, i) => ({
            num: String(i + 1).padStart(2, '0'),
            step: `Step ${i + 1} of ${processSteps.length}`,
            title: step.title,
            summary: step.summary,
            end: false,
        })),
        {
            num: null,
            step: 'Done',
            title: "You're onboarded",
            summary: 'Your assistant is working your hours, in your systems, with a named point of contact behind them.',
            end: true,
        },
    ];

    return (
        <SiteLayout title="How it Works" description={setting('process_heading', 'From discovery call to onboarded, in about two weeks')}>
            <PageHero
                crumbs={[{ label: 'How it Works' }]}
                eyebrow={setting('process_eyebrow', 'How it works')}
                eyebrowColor="text-sage-deep"
                heading={setting('process_heading', 'From discovery call to onboarded, in about two weeks')}
                lede={setting('process_intro', 'A short, structured path — no lengthy procurement process, no ambiguity about what happens next.')}
            />

            {/* scrollxui: parallaxcards — steps stack as you scroll */}
            <section className="pb-8 pt-6">
                <div className="container-site mx-auto max-w-3xl">
                    <ParallaxCards
                        cards={cards}
                        renderCard={(card) => (
                            <div className={card.end ? 'rounded-lg bg-ink p-8 text-cream md:p-10' : 'rounded-lg border border-hairline-soft bg-white p-8 md:p-10'}>
                                <div className="flex items-start gap-6">
                                    <span
                                        className={
                                            card.end
                                                ? 'flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-sage-deep text-cream'
                                                : 'flex h-14 w-14 shrink-0 items-center justify-center rounded-full border-2 border-sage-deep bg-white font-mono text-[16px] font-bold text-sage-deep'
                                        }
                                    >
                                        {card.end ? <Check className="h-5 w-5" strokeWidth={2.6} /> : card.num}
                                    </span>
                                    <div>
                                        <p className={card.end ? 't-caption text-sage' : 't-caption text-sage-deep'}>{card.step}</p>
                                        <h3 className="t-card-title mt-2">{card.title}</h3>
                                        <p className={card.end ? 'mt-2.5 leading-relaxed text-cream/75' : 'mt-2.5 leading-relaxed text-ink-soft'}>
                                            {card.summary}
                                        </p>
                                        {card.end && (
                                            <StaggerButton href="/book-a-call" variant="on-dark" iconRight={ArrowRight} className="mt-6">
                                                Start with a Discovery Call
                                            </StaggerButton>
                                        )}
                                    </div>
                                </div>
                            </div>
                        )}
                    />
                </div>
            </section>

            <CtaBand />
        </SiteLayout>
    );
}
