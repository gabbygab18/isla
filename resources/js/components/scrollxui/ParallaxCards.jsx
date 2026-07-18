import { motion, useScroll, useTransform } from 'framer-motion';
import { useRef } from 'react';
import { cn } from '@/lib/utils';

function StackCard({ children, index, total, progress, className }) {
    const targetScale = 1 - (total - 1 - index) * 0.04;
    const scale = useTransform(progress, [index / total, 1], [1, targetScale]);

    return (
        <div className="sticky top-24 md:top-28" style={{ zIndex: index + 1 }}>
            <motion.div
                style={{ scale, top: `${index * 22}px` }}
                className={cn('relative origin-top rounded-lg shadow-card', className)}
            >
                {children}
            </motion.div>
            <div className="h-8 md:h-10" />
        </div>
    );
}

/**
 * ScrollXUI-style `parallaxcards` — cards stack and scale as you
 * scroll through them. Used for the How It Works process steps.
 */
export default function ParallaxCards({ cards = [], className, renderCard }) {
    const ref = useRef(null);
    const { scrollYProgress } = useScroll({
        target: ref,
        offset: ['start start', 'end end'],
    });

    return (
        <div ref={ref} className={cn('relative', className)}>
            {cards.map((card, i) => (
                <StackCard
                    key={i}
                    index={i}
                    total={cards.length}
                    progress={scrollYProgress}
                    className={card.className}
                >
                    {renderCard ? renderCard(card, i) : card.content}
                </StackCard>
            ))}
        </div>
    );
}
