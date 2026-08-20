import { useEffect, useState } from 'react';
import { useTheme } from 'next-themes';
import { Maximize, Minimize, Moon, Sun } from 'lucide-react';

const btn = 'inline-flex h-9 w-9 items-center justify-center rounded-full border border-hairline bg-white text-ink-soft transition-colors hover:border-ink/40 hover:text-ink';

/** Theme + fullscreen controls for the client presentation. */
export default function ViewControls() {
    const { resolvedTheme, setTheme } = useTheme();
    const [mounted, setMounted] = useState(false);
    const [isFull, setIsFull] = useState(false);

    // next-themes resolves on the client, so avoid rendering the wrong icon
    // during the first paint.
    useEffect(() => setMounted(true), []);

    useEffect(() => {
        const onChange = () => setIsFull(Boolean(document.fullscreenElement));
        document.addEventListener('fullscreenchange', onChange);
        return () => document.removeEventListener('fullscreenchange', onChange);
    }, []);

    const toggleFullscreen = async () => {
        try {
            if (document.fullscreenElement) {
                await document.exitFullscreen();
            } else {
                await document.documentElement.requestFullscreen();
            }
        } catch {
            // Safari/iOS and permission-policy blocks — nothing useful to do
            // beyond leaving the page as-is.
        }
    };

    const isDark = mounted && resolvedTheme === 'dark';

    return (
        <div className="flex items-center gap-2">
            <button
                type="button"
                onClick={() => setTheme(isDark ? 'light' : 'dark')}
                className={btn}
                title={isDark ? 'Switch to light' : 'Switch to dark'}
                aria-label={isDark ? 'Switch to light mode' : 'Switch to dark mode'}
            >
                {isDark ? <Sun className="h-4 w-4" /> : <Moon className="h-4 w-4" />}
            </button>
            <button
                type="button"
                onClick={toggleFullscreen}
                className={btn}
                title={isFull ? 'Exit full screen' : 'Full screen'}
                aria-label={isFull ? 'Exit full screen' : 'Enter full screen'}
            >
                {isFull ? <Minimize className="h-4 w-4" /> : <Maximize className="h-4 w-4" />}
            </button>
        </div>
    );
}
