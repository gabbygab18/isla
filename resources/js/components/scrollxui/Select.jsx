import { useEffect, useRef, useState } from 'react';
import { AnimatePresence, motion } from 'framer-motion';
import { Check, ChevronDown } from 'lucide-react';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `select` — a styled dropdown select with an
 * animated list. Falls back gracefully for keyboard users.
 */
export default function Select({
    value,
    onChange,
    options = [], // [{ value, label }] or ['a','b']
    placeholder = 'Select…',
    disabled = false,
    className,
}) {
    const [open, setOpen] = useState(false);
    const ref = useRef(null);

    const normalized = options.map((o) => (typeof o === 'object' ? o : { value: o, label: o }));
    const selected = normalized.find((o) => String(o.value) === String(value));

    useEffect(() => {
        const onClick = (e) => {
            if (ref.current && !ref.current.contains(e.target)) setOpen(false);
        };
        document.addEventListener('mousedown', onClick);
        return () => document.removeEventListener('mousedown', onClick);
    }, []);

    return (
        <div ref={ref} className={cn('relative', className)}>
            <button
                type="button"
                disabled={disabled}
                aria-haspopup="listbox"
                aria-expanded={open}
                onClick={() => setOpen(!open)}
                className={cn(
                    'flex w-full items-center justify-between gap-3 rounded-md border border-hairline bg-white px-4 py-3 text-left text-[15px] transition-colors',
                    disabled && 'cursor-not-allowed opacity-50',
                    open && 'border-ink/50',
                    !selected && 'text-ink-soft',
                )}
            >
                <span className="truncate">{selected ? selected.label : placeholder}</span>
                <ChevronDown
                    className={cn('h-4 w-4 shrink-0 text-ink-soft transition-transform duration-200', open && 'rotate-180')}
                    strokeWidth={2.2}
                />
            </button>
            <AnimatePresence>
                {open && (
                    <motion.ul
                        role="listbox"
                        initial={{ opacity: 0, y: -6, scale: 0.98 }}
                        animate={{ opacity: 1, y: 0, scale: 1 }}
                        exit={{ opacity: 0, y: -6, scale: 0.98 }}
                        transition={{ duration: 0.16 }}
                        className="absolute z-30 mt-2 max-h-64 w-full overflow-auto rounded-md border border-hairline-soft bg-white py-1.5 shadow-float"
                    >
                        {normalized.map((option) => {
                            const isSelected = String(option.value) === String(value);
                            return (
                                <li key={option.value} role="option" aria-selected={isSelected}>
                                    <button
                                        type="button"
                                        onClick={() => {
                                            onChange(option.value);
                                            setOpen(false);
                                        }}
                                        className={cn(
                                            'flex w-full items-center justify-between gap-3 px-4 py-2.5 text-left text-[14.5px] transition-colors hover:bg-cream',
                                            isSelected && 'font-semibold text-rose-deep',
                                        )}
                                    >
                                        <span className="truncate">{option.label}</span>
                                        {isSelected && <Check className="h-4 w-4 shrink-0" strokeWidth={2.4} />}
                                    </button>
                                </li>
                            );
                        })}
                    </motion.ul>
                )}
            </AnimatePresence>
        </div>
    );
}
