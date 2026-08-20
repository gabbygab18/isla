import { useEffect } from 'react';
import { AnimatePresence, motion } from 'framer-motion';
import { X } from 'lucide-react';

/**
 * Centered dialog overlay — backdrop click or Escape closes it,
 * body scroll is locked while open.
 */
export default function Modal({ open, onClose, label = 'Dialog', size = 'md', children }) {
    useEffect(() => {
        if (!open) return undefined;
        const onKey = (e) => e.key === 'Escape' && onClose();
        document.addEventListener('keydown', onKey);
        const prev = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        return () => {
            document.removeEventListener('keydown', onKey);
            document.body.style.overflow = prev;
        };
    }, [open, onClose]);

    return (
        <AnimatePresence>
            {open && (
                <motion.div
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1 }}
                    exit={{ opacity: 0 }}
                    transition={{ duration: 0.2 }}
                    className="fixed inset-0 z-[80] flex items-center justify-center bg-ink/50 p-4 backdrop-blur-sm sm:p-6"
                    onClick={onClose}
                    role="dialog"
                    aria-modal="true"
                    aria-label={label}
                >
                    <motion.div
                        initial={{ opacity: 0, y: 24, scale: 0.98 }}
                        animate={{ opacity: 1, y: 0, scale: 1 }}
                        exit={{ opacity: 0, y: 16, scale: 0.98 }}
                        transition={{ duration: 0.25, ease: [0.22, 1, 0.36, 1] }}
                        onClick={(e) => e.stopPropagation()}
                        className={`relative max-h-[90vh] w-full ${size === 'lg' ? 'max-w-3xl' : 'max-w-xl'} overflow-y-auto rounded-lg bg-white p-6 shadow-float sm:p-8`}
                    >
                        <button
                            type="button"
                            aria-label="Close"
                            onClick={onClose}
                            className="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-full border border-hairline text-ink transition-colors hover:border-ink"
                        >
                            <X className="h-4 w-4" strokeWidth={2.4} />
                        </button>
                        {children}
                    </motion.div>
                </motion.div>
            )}
        </AnimatePresence>
    );
}
