import { useState } from 'react';
import { AnimatePresence, motion } from 'framer-motion';
import { ChevronDown } from 'lucide-react';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `expandable-cards` — accordion cards with smooth
 * height animation. Used for FAQs.
 */
export default function ExpandableCards({ items = [], className, renderExtra }) {
    const [open, setOpen] = useState(null);

    return (
        <div className={cn('mx-auto flex w-full max-w-3xl flex-col gap-3', className)}>
            {items.map((item, i) => {
                const isOpen = open === i;
                return (
                    <motion.div
                        key={item.id ?? i}
                        initial={{ opacity: 0, y: 16 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.4, delay: i * 0.04 }}
                        className={cn(
                            'overflow-hidden rounded-lg border bg-white transition-colors',
                            isOpen ? 'border-rose-deep/40 shadow-card' : 'border-hairline-soft',
                        )}
                    >
                        <button
                            type="button"
                            aria-expanded={isOpen}
                            onClick={() => setOpen(isOpen ? null : i)}
                            className="flex w-full items-center justify-between gap-5 px-6 py-5 text-left"
                        >
                            <span className="font-display text-[17px] font-bold tracking-tight">{item.title}</span>
                            <span
                                className={cn(
                                    'flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-hairline transition-all duration-300',
                                    isOpen && 'rotate-180 border-rose-deep bg-rose-soft text-rose-deep',
                                )}
                            >
                                <ChevronDown className="h-4 w-4" strokeWidth={2.4} />
                            </span>
                        </button>
                        <AnimatePresence initial={false}>
                            {isOpen && (
                                <motion.div
                                    initial={{ height: 0, opacity: 0 }}
                                    animate={{ height: 'auto', opacity: 1 }}
                                    exit={{ height: 0, opacity: 0 }}
                                    transition={{ duration: 0.32, ease: [0.22, 1, 0.36, 1] }}
                                >
                                    <div className="px-6 pb-6 text-[15.5px] leading-relaxed text-ink-soft">
                                        {item.content}
                                        {renderExtra?.(item)}
                                    </div>
                                </motion.div>
                            )}
                        </AnimatePresence>
                    </motion.div>
                );
            })}
        </div>
    );
}
