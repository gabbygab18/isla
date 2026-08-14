import { usePage } from '@inertiajs/react';
import { CalendarHeart, Star } from 'lucide-react';
import LeanCard from '@/components/scrollxui/LeanCard';
import OrbButton from '@/components/scrollxui/OrbButton';
import RevealText from '@/components/scrollxui/RevealText';
import { makeSetting } from '@/lib/utils';

/**
 * Shared closing CTA band — the ink block is now a scrollxui
 * `lean-card` (subtle 3D lean on hover), with the orb-button as
 * the primary action.
 */
export default function CtaBand({ heading, lede }) {
    const setting = makeSetting(usePage().props?.settings);

    return (
        <section className="section">
            <div className="container-site">
                <LeanCard
                    featured
                    className="block-ink relative overflow-hidden !rounded-xl !border-0 !p-8 text-center md:!p-14"
                >
                    <span
                        aria-hidden="true"
                        className="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-rose/15 blur-3xl"
                    />
                    <span
                        aria-hidden="true"
                        className="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-sage/15 blur-3xl"
                    />
                    <span className="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-full bg-on-inverse-soft">
                        <Star className="h-6 w-6 text-rose" strokeWidth={2} />
                    </span>
                    <RevealText text={heading || "Ready to lift the admin off your team?"} className="t-headline" />
                    <p className="mx-auto mt-3 max-w-xl text-cream/80">
                        {lede || 'Book a 15-minute discovery call — no obligation, just a conversation about where the hours are going.'}
                    </p>
                    <div className="mt-8 flex justify-center">
                        <OrbButton href="/book-a-call" icon={CalendarHeart}>
                            {setting('hero_cta_label', 'Book a Discovery Call')}
                        </OrbButton>
                    </div>
                </LeanCard>
            </div>
        </section>
    );
}
