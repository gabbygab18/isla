import { motion } from 'framer-motion';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `bento-grid` — asymmetric feature grid with
 * staggered scroll entrances.
 */
export function BentoGrid({ children, className }) {
    return (
        <div className={cn('grid grid-cols-1 gap-5 md:grid-cols-3 md:auto-rows-[minmax(210px,auto)]', className)}>
            {children}
        </div>
    );
}

export function BentoItem({ children, className, span = 1, index = 0 }) {
    return (
        <motion.div
            initial={{ opacity: 0, y: 28 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: '-6% 0px' }}
            transition={{ duration: 0.5, delay: index * 0.07, ease: [0.22, 1, 0.36, 1] }}
            className={cn(
                'relative overflow-hidden rounded-lg border border-hairline-soft bg-white p-7',
                span === 2 && 'md:col-span-2',
                span === 3 && 'md:col-span-3',
                className,
            )}
        >
            {children}
        </motion.div>
    );
}
