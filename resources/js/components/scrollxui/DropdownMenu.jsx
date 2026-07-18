import { useEffect, useRef, useState } from 'react';
import { Link } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { ChevronDown } from 'lucide-react';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `dropdown-menu` — animated dropdown used for the
 * "More" group in the desktop navigation.
 */
export default function DropdownMenu({ label, items = [], className }) {
    const [open, setOpen] = useState(false);
    const ref = useRef(null);

    useEffect(() => {
        const onClick = (e) => {
            if (ref.current && !ref.current.contains(e.target)) setOpen(false);
        };
        document.addEventListener('mousedown', onClick);
        return () => document.removeEventListener('mousedown', onClick);
    }, []);

    return (
        <div
            ref={ref}
            className={cn('relative', className)}
            onMouseEnter={() => setOpen(true)}
            onMouseLeave={() => setOpen(false)}
        >
            <button
                type="button"
                aria-haspopup="menu"
                aria-expanded={open}
                onClick={() => setOpen(!open)}
                className="inline-flex items-center gap-1.5 rounded-pill px-3.5 py-2 text-[14.5px] font-medium text-ink-soft transition-colors hover:text-ink"
            >
                {label}
                <ChevronDown className={cn('h-3.5 w-3.5 transition-transform duration-200', open && 'rotate-180')} strokeWidth={2.4} />
            </button>
            <AnimatePresence>
                {open && (
                    <motion.div
                        role="menu"
                        initial={{ opacity: 0, y: 8, scale: 0.97 }}
                        animate={{ opacity: 1, y: 0, scale: 1 }}
                        exit={{ opacity: 0, y: 8, scale: 0.97 }}
                        transition={{ duration: 0.18, ease: [0.22, 1, 0.36, 1] }}
                        className="absolute right-0 top-full z-40 w-56 pt-2"
                    >
                        <div className="overflow-hidden rounded-lg border border-hairline-soft bg-white p-1.5 shadow-float">
                            {items.map((item) => (
                                <Link
                                    key={item.url}
                                    href={item.url}
                                    role="menuitem"
                                    onClick={() => setOpen(false)}
                                    className="block rounded-md px-4 py-2.5 text-[14.5px] font-medium text-ink-soft transition-colors hover:bg-cream hover:text-ink"
                                >
                                    {item.label}
                                </Link>
                            ))}
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>
        </div>
    );
}
