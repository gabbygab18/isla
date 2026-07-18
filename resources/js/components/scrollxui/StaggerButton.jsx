import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `stagger-button` — on hover each letter of the
 * label flips up and its duplicate rolls in from below.
 */
export default function StaggerButton({
    children,
    href,
    as,
    icon: Icon,
    iconRight: IconRight,
    variant = 'primary', // primary | secondary | on-dark | ghost
    className,
    ...props
}) {
    const label = typeof children === 'string' ? children : '';
    const letters = label.split('');

    const variants = {
        primary: 'bg-ink text-cream hover:bg-ink/90',
        secondary: 'bg-white text-ink border border-hairline hover:border-ink/40',
        'on-dark': 'bg-cream text-ink hover:bg-white',
        ghost: 'bg-transparent text-ink hover:bg-ink/5',
    };

    const Comp = href ? (href.startsWith('#') || href.startsWith('http') || href.startsWith('mailto') || href.startsWith('tel') ? 'a' : Link) : (as || 'button');

    return (
        <Comp
            href={href}
            className={cn(
                'group inline-flex items-center justify-center gap-2.5 rounded-pill px-7 py-3.5 text-[15px] font-semibold tracking-tight transition-colors duration-200',
                variants[variant],
                className,
            )}
            {...props}
        >
            {Icon && <Icon className="h-[18px] w-[18px] shrink-0" strokeWidth={2.2} />}
            {label ? (
                <span className="relative block overflow-hidden leading-none" aria-label={label}>
                    {/* top copy — slides out */}
                    <span aria-hidden="true" className="flex">
                        {letters.map((ch, i) => (
                            <motion.span
                                key={`a-${i}`}
                                className="inline-block whitespace-pre transition-transform duration-300 ease-[cubic-bezier(.76,0,.24,1)] group-hover:-translate-y-[110%]"
                                style={{ transitionDelay: `${i * 14}ms` }}
                            >
                                {ch}
                            </motion.span>
                        ))}
                    </span>
                    {/* bottom copy — slides in */}
                    <span aria-hidden="true" className="absolute inset-0 flex">
                        {letters.map((ch, i) => (
                            <span
                                key={`b-${i}`}
                                className="inline-block translate-y-[110%] whitespace-pre transition-transform duration-300 ease-[cubic-bezier(.76,0,.24,1)] group-hover:translate-y-0"
                                style={{ transitionDelay: `${i * 14}ms` }}
                            >
                                {ch}
                            </span>
                        ))}
                    </span>
                </span>
            ) : (
                children
            )}
            {IconRight && (
                <IconRight
                    className="h-[18px] w-[18px] shrink-0 transition-transform duration-300 group-hover:translate-x-1"
                    strokeWidth={2.2}
                />
            )}
        </Comp>
    );
}
