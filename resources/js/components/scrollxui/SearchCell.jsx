import { Search, X } from 'lucide-react';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `search-cell` — a pill search input that glows
 * on focus. Used for FAQ filtering.
 */
export default function SearchCell({ value, onChange, placeholder, className }) {
    return (
        <div
            className={cn(
                'group mx-auto flex w-full max-w-2xl items-center gap-3 rounded-pill border border-hairline bg-white py-1.5 pl-6 pr-2 transition-all duration-300 focus-within:border-rose-deep focus-within:shadow-[0_0_0_4px_rgba(219,148,150,0.18)]',
                className,
            )}
        >
            <Search className="h-[18px] w-[18px] shrink-0 text-ink-soft transition-colors group-focus-within:text-rose-deep" strokeWidth={2.2} />
            <input
                type="search"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                placeholder={placeholder}
                aria-label={placeholder}
                className="w-full bg-transparent py-2.5 text-[16px] outline-none placeholder:text-ink-soft/70 [&::-webkit-search-cancel-button]:hidden"
            />
            {value && (
                <button
                    type="button"
                    aria-label="Clear search"
                    onClick={() => onChange('')}
                    className="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-ink-soft transition-colors hover:bg-cream hover:text-ink"
                >
                    <X className="h-4 w-4" strokeWidth={2.2} />
                </button>
            )}
        </div>
    );
}
