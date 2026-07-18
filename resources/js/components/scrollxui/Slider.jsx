import { useRef, useState } from 'react';
import { motion } from 'framer-motion';
import { ArrowLeft, ArrowRight } from 'lucide-react';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `slider` — a drag-to-scroll carousel with arrow
 * controls. Used for related-item rails on detail pages.
 */
export default function Slider({ children, className, itemClassName }) {
    const trackRef = useRef(null);
    const [constraint, setConstraint] = useState(0);

    const measure = () => {
        const el = trackRef.current;
        if (el) setConstraint(Math.max(el.scrollWidth - el.offsetWidth, 0));
    };

    const nudge = (dir) => {
        const el = trackRef.current;
        if (!el) return;
        el.scrollBy({ left: dir * (el.offsetWidth * 0.7), behavior: 'smooth' });
    };

    return (
        <div className={cn('relative', className)}>
            <div
                ref={trackRef}
                onMouseEnter={measure}
                className="no-scrollbar flex snap-x snap-mandatory gap-5 overflow-x-auto scroll-smooth pb-2"
            >
                {(Array.isArray(children) ? children : [children]).map((child, i) => (
                    <motion.div
                        key={i}
                        initial={{ opacity: 0, x: 32 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.45, delay: i * 0.06 }}
                        className={cn('w-[86%] shrink-0 snap-start sm:w-[46%] lg:w-[31.5%]', itemClassName)}
                    >
                        {child}
                    </motion.div>
                ))}
            </div>
            <div className="mt-5 flex justify-end gap-2">
                <button
                    type="button"
                    aria-label="Previous"
                    onClick={() => nudge(-1)}
                    className="flex h-10 w-10 items-center justify-center rounded-full border border-hairline bg-white transition-colors hover:border-ink"
                >
                    <ArrowLeft className="h-4 w-4" strokeWidth={2.2} />
                </button>
                <button
                    type="button"
                    aria-label="Next"
                    onClick={() => nudge(1)}
                    className="flex h-10 w-10 items-center justify-center rounded-full border border-hairline bg-white transition-colors hover:border-ink"
                >
                    <ArrowRight className="h-4 w-4" strokeWidth={2.2} />
                </button>
            </div>
        </div>
    );
}
