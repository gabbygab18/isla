import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `kinetic-testimonials` — a continuously moving
 * marquee track. Used for the brand promise strip under the nav
 * (the old .marquee element) and other rolling text bands.
 */
export default function KineticTestimonials({ items = [], className, speed = 'animate-marquee' }) {
    const doubled = [...items, ...items];

    return (
        <div
            aria-hidden="true"
            className={cn('overflow-hidden border-y border-hairline-soft bg-white/60 py-3', className)}
        >
            <div className={cn('flex w-max items-center gap-10 whitespace-nowrap pr-10', speed)}>
                {doubled.map((item, i) => (
                    <span key={i} className="flex items-center gap-3">
                        <span className="h-1.5 w-1.5 rounded-full bg-rose-deep" />
                        <span className="t-caption text-ink-soft">{item}</span>
                    </span>
                ))}
            </div>
        </div>
    );
}
