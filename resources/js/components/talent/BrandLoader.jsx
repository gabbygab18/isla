import { useEffect, useState } from 'react';
import { router } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';

/**
 * Plain-background splash with the logo centred, shown on first paint and on
 * every Inertia navigation within the presentation. Keeps the client-facing
 * flow feeling like a deck rather than a website reload.
 */
export default function BrandLoader({ minDuration = 900 }) {
    const [visible, setVisible] = useState(true);

    // Initial load — hold briefly so the logo reads as a deliberate title card
    // instead of a flash.
    useEffect(() => {
        const t = setTimeout(() => setVisible(false), minDuration);
        return () => clearTimeout(t);
    }, [minDuration]);

    // Subsequent Inertia visits (e.g. submitting the shortlist).
    useEffect(() => {
        const offStart = router.on('start', () => setVisible(true));
        const offFinish = router.on('finish', () => {
            setTimeout(() => setVisible(false), 450);
        });

        return () => {
            offStart();
            offFinish();
        };
    }, []);

    return (
        <AnimatePresence>
            {visible && (
                <motion.div
                    key="brand-loader"
                    initial={{ opacity: 1 }}
                    animate={{ opacity: 1 }}
                    exit={{ opacity: 0 }}
                    transition={{ duration: 0.55, ease: [0.22, 1, 0.36, 1] }}
                    className="fixed inset-0 z-[200] flex items-center justify-center bg-cream"
                >
                    <motion.img
                        src="/logo.png"
                        alt="Isla"
                        className="h-20 w-auto md:h-24"
                        initial={{ opacity: 0, scale: 0.94 }}
                        animate={{ opacity: 1, scale: 1 }}
                        transition={{ duration: 0.7, ease: [0.22, 1, 0.36, 1] }}
                    />
                </motion.div>
            )}
        </AnimatePresence>
    );
}
