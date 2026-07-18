import { usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { CalendarHeart, Star } from 'lucide-react';
import OrbButton from '@/components/scrollxui/OrbButton';
import RevealText from '@/components/scrollxui/RevealText';
import { makeSetting } from '@/lib/utils';

/**
 * Shared closing CTA band (ink block) — the primary action uses
 * the scrollxui orb-button.
 */
export default function CtaBand() {
    const setting = makeSetting(usePage().props?.settings);

    return (
        <section className="section">
            <div className="container-site">
                <motion.div
                    initial={{ opacity: 0, y: 32 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true, margin: '-8% 0px' }}
                    transition={{ duration: 0.6, ease: [0.22, 1, 0.36, 1] }}
                    className="block-ink relative overflow-hidden text-center"
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
                    <RevealText text="Ready to lift the admin off your team?" className="t-headline" />
                    <p className="mx-auto mt-3 max-w-xl text-cream/80">
                        Book a 20-minute discovery call — no obligation, just a conversation about where the hours are going.
                    </p>
                    <div className="mt-8 flex justify-center">
                        <OrbButton href="/book-a-call" icon={CalendarHeart}>
                            {setting('hero_cta_label', 'Book a Discovery Call')}
                        </OrbButton>
                    </div>
                </motion.div>
            </div>
        </section>
    );
}
