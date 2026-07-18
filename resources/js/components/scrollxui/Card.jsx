import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `card` — the base content card with a scroll
 * entrance and hover lift. Renders as a Link when href is given.
 */
export default function Card({ children, href, className, index = 0, ...props }) {
    const inner = (
        <motion.div
            initial={{ opacity: 0, y: 24 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: '-6% 0px' }}
            transition={{ duration: 0.5, delay: index * 0.06, ease: [0.22, 1, 0.36, 1] }}
            className={cn(
                'group h-full rounded-lg border border-hairline-soft bg-white p-7 transition-all duration-300 hover:-translate-y-1 hover:shadow-card',
                className,
            )}
        >
            {children}
        </motion.div>
    );

    if (href) {
        return (
            <Link href={href} className="block h-full" {...props}>
                {inner}
            </Link>
        );
    }
    return inner;
}
