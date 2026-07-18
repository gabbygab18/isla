import { clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs) {
    return twMerge(clsx(inputs));
}

/**
 * Read an admin-editable setting shared by HandleInertiaRequests,
 * mirroring Laravel's setting() helper (with the same defaults).
 */
export function makeSetting(settings) {
    return (key, fallback = '') => settings?.[key] ?? fallback;
}
