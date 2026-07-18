import { Link } from '@inertiajs/react';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `orb-button` — CTA with a soft animated orb glow
 * behind the label. Used for the highest-intent actions
 * (Book a Discovery Call).
 */
export default function OrbButton({ children, href, icon: Icon, className, ...props }) {
    const Comp = href
        ? (href.startsWith('#') || href.startsWith('http') ? 'a' : Link)
        : 'button';

    return (
        <Comp
            href={href}
            className={cn(
                'group relative inline-flex items-center justify-center gap-2.5 overflow-hidden rounded-pill bg-ink px-8 py-4 text-[15px] font-semibold text-cream transition-transform duration-200 hover:scale-[1.02] active:scale-[0.99]',
                className,
            )}
            {...props}
        >
            {/* animated orbs */}
            <span
                aria-hidden="true"
                className="absolute -left-6 top-1/2 h-20 w-20 -translate-y-1/2 rounded-full bg-rose/50 blur-2xl animate-orb-pulse"
            />
            <span
                aria-hidden="true"
                className="absolute -right-6 top-1/2 h-20 w-20 -translate-y-1/2 rounded-full bg-sage/50 blur-2xl animate-orb-pulse [animation-delay:1.4s]"
            />
            <span
                aria-hidden="true"
                className="absolute inset-0 opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                style={{ background: 'radial-gradient(120px 60px at 50% 120%, rgba(219,148,150,.35), transparent 70%)' }}
            />
            {Icon && <Icon className="relative z-10 h-[18px] w-[18px]" strokeWidth={2.2} />}
            <span className="relative z-10">{children}</span>
        </Comp>
    );
}
