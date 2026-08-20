import { useEffect, useRef, useState } from 'react';

/**
 * Calendly inline embed. The widget script is loaded once on demand rather than
 * in the app shell, so pages without a booking widget don't pay for it and the
 * embed simply doesn't render when no link is configured in admin › Settings.
 *
 * Prefill saves the client retyping what they already gave us; Calendly reads
 * `name`, `email` and `a1` (the first custom question) from the query string.
 */
const SCRIPT_SRC = 'https://assets.calendly.com/assets/external/widget.js';
const STYLE_HREF = 'https://assets.calendly.com/assets/external/widget.css';

let scriptPromise = null;

function loadCalendly() {
    if (typeof window === 'undefined') return Promise.reject(new Error('no window'));
    if (window.Calendly) return Promise.resolve();

    if (!scriptPromise) {
        scriptPromise = new Promise((resolve, reject) => {
            if (!document.querySelector(`link[href="${STYLE_HREF}"]`)) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = STYLE_HREF;
                document.head.appendChild(link);
            }

            const script = document.createElement('script');
            script.src = SCRIPT_SRC;
            script.async = true;
            script.onload = resolve;
            script.onerror = () => reject(new Error('Calendly failed to load'));
            document.head.appendChild(script);
        });
    }

    return scriptPromise;
}

const buildUrl = (url, prefill) => {
    try {
        const parsed = new URL(url, window.location.origin);
        Object.entries(prefill || {}).forEach(([key, value]) => {
            if (value) parsed.searchParams.set(key, value);
        });
        // Applies with or without prefill — the cookie banner otherwise covers
        // the time picker inside a modal.
        parsed.searchParams.set('hide_gdpr_banner', '1');
        return parsed.toString();
    } catch {
        return url;
    }
};

export default function CalendlyEmbed({ url, prefill, height = 660, mobileHeight = 1180, className = '' }) {
    const holder = useRef(null);
    const [failed, setFailed] = useState(false);
    const [narrow, setNarrow] = useState(false);
    // Calendly posts its rendered height as the visitor moves through the flow.
    // Honouring it keeps the whole widget on screen so the *page* scrolls —
    // an inner iframe scrollbar is close to unusable on touch devices.
    const [reported, setReported] = useState(null);

    useEffect(() => {
        const mq = window.matchMedia('(max-width: 767px)');
        const sync = () => setNarrow(mq.matches);
        sync();
        mq.addEventListener('change', sync);
        return () => mq.removeEventListener('change', sync);
    }, []);

    useEffect(() => {
        const onMessage = (e) => {
            if (typeof e.origin !== 'string' || !e.origin.includes('calendly.com')) return;
            const data = e.data;
            if (!data || data.event !== 'calendly.page_height') return;
            const px = parseInt(String(data.payload?.height ?? '').replace('px', ''), 10);
            if (Number.isFinite(px) && px > 200) setReported(px);
        };

        window.addEventListener('message', onMessage);
        return () => window.removeEventListener('message', onMessage);
    }, []);

    useEffect(() => {
        if (!url || !holder.current) return;

        let cancelled = false;
        const node = holder.current;

        loadCalendly()
            .then(() => {
                if (cancelled || !window.Calendly) return;
                node.innerHTML = '';
                window.Calendly.initInlineWidget({
                    url: buildUrl(url, prefill),
                    parentElement: node,
                    prefill: {},
                    utm: {},
                });
            })
            .catch(() => !cancelled && setFailed(true));

        return () => {
            cancelled = true;
            node.innerHTML = '';
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [url, prefill?.name, prefill?.email, prefill?.a1]);

    if (!url) return null;

    if (failed) {
        return (
            <p className={`text-[14px] text-ink-soft ${className}`}>
                Scheduler couldn&apos;t load —{' '}
                <a href={url} target="_blank" rel="noreferrer" className="font-bold text-rose-deep underline">
                    open it in a new tab
                </a>.
            </p>
        );
    }

    const boxHeight = reported ?? (narrow ? mobileHeight : height);

    return <div ref={holder} className={className} style={{ minWidth: 280, height: boxHeight }} />;
}
