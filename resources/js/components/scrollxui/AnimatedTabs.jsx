import { motion } from 'framer-motion';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `animated-tabs` — pill tabs with a shared-layout
 * active indicator that glides between options.
 */
export default function AnimatedTabs({ tabs = [], active, onChange, className, layoutId = 'tabs' }) {
    return (
        <div
            role="tablist"
            className={cn(
                'inline-flex gap-1 rounded-pill border border-hairline-soft bg-white p-1.5',
                className,
            )}
        >
            {tabs.map((tab) => {
                const isActive = active === tab.value;
                return (
                    <button
                        key={tab.value}
                        type="button"
                        role="tab"
                        aria-selected={isActive}
                        onClick={() => onChange(tab.value)}
                        className={cn(
                            'relative inline-flex items-center gap-2 rounded-pill px-6 py-2.5 text-[15px] font-semibold transition-colors duration-200',
                            isActive ? 'text-cream' : 'text-ink-soft hover:text-ink',
                        )}
                    >
                        {isActive && (
                            <motion.span
                                layoutId={layoutId}
                                className="absolute inset-0 rounded-pill bg-ink"
                                transition={{ type: 'spring', bounce: 0.18, duration: 0.5 }}
                            />
                        )}
                        {tab.icon && <tab.icon className="relative z-10 h-4 w-4" strokeWidth={2.2} />}
                        <span className="relative z-10">{tab.label}</span>
                    </button>
                );
            })}
        </div>
    );
}
