import { motion } from 'framer-motion';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `layer-stack` — layered, slightly-rotated cards
 * that settle into place on scroll. Used for the hero visual.
 */
export default function LayerStack({ layers = [], className }) {
    return (
        <div className={cn('relative', className)}>
            {layers.map((layer, i) => (
                <motion.div
                    key={i}
                    initial={{ opacity: 0, y: 40, rotate: 0 }}
                    animate={{ opacity: 1, y: 0, rotate: layer.rotate ?? 0 }}
                    transition={{ duration: 0.7, delay: 0.15 + i * 0.15, ease: [0.22, 1, 0.36, 1] }}
                    className={cn(layer.className)}
                    style={layer.style}
                >
                    {layer.content}
                </motion.div>
            ))}
        </div>
    );
}
