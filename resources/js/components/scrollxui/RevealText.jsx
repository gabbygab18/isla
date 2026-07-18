import { useRef } from 'react';
import { motion, useInView } from 'framer-motion';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `reveal-text` — words rise & fade in as the
 * element scrolls into view.
 *
 * Visibility is observed on the heading element itself (via
 * useInView), NOT on the individual words: the words start
 * translated outside their overflow-hidden wrappers, so an
 * IntersectionObserver on the words would never fire — they're
 * fully clipped until the animation runs.
 */
export default function RevealText({
    text,
    as: Tag = 'h2',
    className,
    delay = 0,
    stagger = 0.045,
    once = true,
}) {
    const ref = useRef(null);
    const inView = useInView(ref, { once, margin: '-8% 0px' });

    const lines = Array.isArray(text) ? text : String(text ?? '').split('\n');

    let wordIndex = 0;

    return (
        <Tag ref={ref} className={cn(className)}>
            <span className="sr-only">{lines.join(' ')}</span>
            <span aria-hidden="true">
                {lines.map((line, li) => (
                    <span key={li} className="block">
                        {line.split(' ').map((word, wi) => {
                            const i = wordIndex++;
                            return (
                                <span key={wi} className="inline-block overflow-hidden pb-[0.08em] -mb-[0.08em] align-bottom">
                                    <motion.span
                                        className="inline-block will-change-transform"
                                        initial={{ y: '110%', opacity: 0 }}
                                        animate={inView ? { y: '0%', opacity: 1 } : { y: '110%', opacity: 0 }}
                                        transition={{
                                            duration: 0.55,
                                            delay: delay + i * stagger,
                                            ease: [0.22, 1, 0.36, 1],
                                        }}
                                    >
                                        {word}
                                    </motion.span>
                                    {wi < line.split(' ').length - 1 ? '\u00A0' : ''}
                                </span>
                            );
                        })}
                    </span>
                ))}
            </span>
        </Tag>
    );
}
