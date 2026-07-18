import { motion } from 'framer-motion';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `lean-card` — a minimal card that "leans" in 3D
 * toward the cursor on hover. Used for pricing plans.
 */
export default function LeanCard({ children, className, featured = false, index = 0 }) {
    return (
        <motion.div
            initial={{ opacity: 0, y: 28 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: '-6% 0px' }}
            transition={{ duration: 0.5, delay: index * 0.08, ease: [0.22, 1, 0.36, 1] }}
            whileHover={{ rotateX: 2.5, rotateY: -2.5, y: -6 }}
            style={{ transformPerspective: 900 }}
            className={cn(
                'relative flex h-full flex-col rounded-lg border p-8 transition-shadow duration-300',
                featured
                    ? 'border-ink bg-ink text-cream shadow-deep'
                    : 'border-hairline-soft bg-white hover:shadow-card',
                className,
            )}
        >
            {children}
        </motion.div>
    );
}
