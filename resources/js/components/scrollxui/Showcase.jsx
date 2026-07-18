import { motion } from 'framer-motion';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `showcase` — alternating media / text feature rows
 * with directional scroll entrances.
 */
export default function Showcase({ items = [], className, renderText, renderMedia }) {
    return (
        <div className={cn('flex flex-col gap-16 md:gap-24', className)}>
            {items.map((item, i) => {
                const flip = i % 2 === 1;
                return (
                    <div
                        key={i}
                        className={cn(
                            'grid items-center gap-8 md:grid-cols-2 md:gap-14',
                        )}
                    >
                        <motion.div
                            initial={{ opacity: 0, x: flip ? 40 : -40 }}
                            whileInView={{ opacity: 1, x: 0 }}
                            viewport={{ once: true, margin: '-10% 0px' }}
                            transition={{ duration: 0.6, ease: [0.22, 1, 0.36, 1] }}
                            className={cn(flip && 'md:order-2')}
                        >
                            {renderMedia ? renderMedia(item, i) : item.media}
                        </motion.div>
                        <motion.div
                            initial={{ opacity: 0, x: flip ? -40 : 40 }}
                            whileInView={{ opacity: 1, x: 0 }}
                            viewport={{ once: true, margin: '-10% 0px' }}
                            transition={{ duration: 0.6, delay: 0.08, ease: [0.22, 1, 0.36, 1] }}
                            className={cn(flip && 'md:order-1')}
                        >
                            {renderText ? renderText(item, i) : item.text}
                        </motion.div>
                    </div>
                );
            })}
        </div>
    );
}
