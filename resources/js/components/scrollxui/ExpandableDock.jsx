import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { Calculator, CalendarHeart, MessageCircle, Plus } from 'lucide-react';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `expandable-dock` — a floating action dock that
 * expands into the key conversion shortcuts. Hidden on the pages
 * it links to.
 */
export default function ExpandableDock() {
    const [open, setOpen] = useState(false);
    const { url } = usePage();

    const actions = [
        { icon: CalendarHeart, label: 'Book a call', href: '/book-a-call' },
        { icon: Calculator, label: 'Cost estimator', href: '/cost-estimator' },
        { icon: MessageCircle, label: 'Enquire', href: '/contact' },
    ].filter((a) => !url.startsWith(a.href));

    return (
        <div className="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3">
            <AnimatePresence>
                {open &&
                    actions.map((action, i) => (
                        <motion.div
                            key={action.href}
                            initial={{ opacity: 0, y: 14, scale: 0.9 }}
                            animate={{ opacity: 1, y: 0, scale: 1 }}
                            exit={{ opacity: 0, y: 10, scale: 0.9 }}
                            transition={{ duration: 0.22, delay: i * 0.05 }}
                        >
                            <Link
                                href={action.href}
                                onClick={() => setOpen(false)}
                                className="flex items-center gap-3 rounded-pill border border-hairline-soft bg-white py-2.5 pl-4 pr-2.5 text-sm font-semibold shadow-float"
                            >
                                {action.label}
                                <span className="flex h-9 w-9 items-center justify-center rounded-full bg-rose-soft text-rose-deep">
                                    <action.icon className="h-4 w-4" strokeWidth={2.2} />
                                </span>
                            </Link>
                        </motion.div>
                    ))}
            </AnimatePresence>
            <button
                type="button"
                aria-label={open ? 'Close quick actions' : 'Open quick actions'}
                aria-expanded={open}
                onClick={() => setOpen(!open)}
                className={cn(
                    'flex h-14 w-14 items-center justify-center rounded-full bg-ink text-cream shadow-deep transition-transform duration-300 hover:scale-105',
                    open && 'rotate-45',
                )}
            >
                <Plus className="h-6 w-6" strokeWidth={2.4} />
            </button>
        </div>
    );
}
