import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `scroll-areapro` — a styled scroll container with
 * soft edge fades and a slim custom scrollbar.
 */
export default function ScrollAreaPro({ children, className, maxHeight = '320px' }) {
    return (
        <div className={cn('relative', className)}>
            <div
                className="overflow-y-auto pr-2 [scrollbar-color:rgba(43,39,35,.28)_transparent] [scrollbar-width:thin] [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-ink/25 [&::-webkit-scrollbar-track]:bg-transparent"
                style={{ maxHeight }}
            >
                {children}
            </div>
            <div className="pointer-events-none absolute inset-x-0 top-0 h-5 bg-gradient-to-b from-white to-transparent" />
            <div className="pointer-events-none absolute inset-x-0 bottom-0 h-5 bg-gradient-to-t from-white to-transparent" />
        </div>
    );
}
