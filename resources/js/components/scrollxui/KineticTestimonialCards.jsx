import { motion } from 'framer-motion';
import { Quote } from 'lucide-react';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `kinetic-testimonials` — card variant.
 * Testimonial cards flow in vertical columns that drift in opposite
 * directions (kinetic marquee), pausing on hover. Falls back to a
 * single static column on small screens.
 */
function TestimonialCard({ item }) {
    return (
        <figure className="rounded-lg border border-hairline-soft bg-white p-7 shadow-sm">
            <Quote aria-hidden="true" className="h-6 w-6 text-rose-deep" strokeWidth={2} />
            <blockquote className="mt-4 text-[15.5px] leading-relaxed text-ink-soft">
                “{item.quote}”
            </blockquote>
            <figcaption className="mt-5 border-t border-hairline-soft pt-4">
                <span className="block font-display text-[15.5px] font-bold text-ink">{item.author}</span>
                {item.role && <span className="t-caption mt-0.5 block text-ink-soft">{item.role}</span>}
            </figcaption>
        </figure>
    );
}

function KineticColumn({ items, reverse = false }) {
    const doubled = [...items, ...items];

    return (
        <div className="group relative h-[640px] overflow-hidden">
            <div
                className={cn(
                    'flex w-full flex-col gap-5 pb-5 group-hover:[animation-play-state:paused]',
                    reverse ? 'animate-marquee-y-reverse' : 'animate-marquee-y',
                )}
            >
                {doubled.map((item, i) => (
                    <TestimonialCard key={`${item.id ?? item.author}-${i}`} item={item} />
                ))}
            </div>
            {/* soft fade at both edges */}
            <span aria-hidden="true" className="pointer-events-none absolute inset-x-0 top-0 z-10 h-16 bg-gradient-to-b from-cream to-transparent" />
            <span aria-hidden="true" className="pointer-events-none absolute inset-x-0 bottom-0 z-10 h-16 bg-gradient-to-t from-cream to-transparent" />
        </div>
    );
}

export default function KineticTestimonialCards({ items = [], className }) {
    if (!items.length) return null;

    // Split into two drifting columns for md+ screens
    const colA = items.filter((_, i) => i % 2 === 0);
    const colB = items.filter((_, i) => i % 2 === 1);

    return (
        <div className={className}>
            {/* Mobile: simple stacked list */}
            <motion.div
                initial={{ opacity: 0, y: 24 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true, margin: '-6% 0px' }}
                transition={{ duration: 0.55, ease: [0.22, 1, 0.36, 1] }}
                className="flex flex-col gap-5 md:hidden"
            >
                {items.map((item) => (
                    <TestimonialCard key={item.id ?? item.author} item={item} />
                ))}
            </motion.div>

            {/* md+: kinetic drifting columns */}
            <motion.div
                initial={{ opacity: 0, y: 24 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true, margin: '-6% 0px' }}
                transition={{ duration: 0.55, ease: [0.22, 1, 0.36, 1] }}
                className="hidden gap-6 md:grid md:grid-cols-2"
            >
                <KineticColumn items={colA.length ? colA : items} />
                <KineticColumn items={colB.length ? colB : items} reverse />
            </motion.div>
        </div>
    );
}
