import { useEffect, useRef, useState } from 'react';
import { useInView } from 'framer-motion';
import { cn } from '@/lib/utils';

function CountUp({ value, duration = 1.6 }) {
    const ref = useRef(null);
    const inView = useInView(ref, { once: true, margin: '-10% 0px' });
    const [display, setDisplay] = useState(value);

    // Split "20+" / "1–2 wks" / "Lifetime" into a leading number (if any) + the rest.
    const match = String(value).match(/^(\d+(?:[.,]\d+)?)(.*)$/);

    useEffect(() => {
        if (!match || !inView) return;
        const target = parseFloat(match[1].replace(',', ''));
        const start = performance.now();
        let raf;
        const tick = (now) => {
            const p = Math.min((now - start) / (duration * 1000), 1);
            const eased = 1 - Math.pow(1 - p, 3);
            setDisplay(Math.round(target * eased).toLocaleString('en-AU') + match[2]);
            if (p < 1) raf = requestAnimationFrame(tick);
        };
        raf = requestAnimationFrame(tick);
        return () => cancelAnimationFrame(raf);
    }, [inView]); // eslint-disable-line react-hooks/exhaustive-deps

    return <span ref={ref}>{match ? display : value}</span>;
}

/**
 * ScrollXUI-style `statscount` — a stat grid whose numeric values
 * count up when scrolled into view.
 */
export default function StatsCount({ stats = [], className, onDark = false }) {
    return (
        <div className={cn('grid grid-cols-2 gap-x-6 gap-y-10 md:grid-cols-4', className)}>
            {stats.map((stat, i) => (
                <div key={i}>
                    <strong className="block font-display text-[clamp(1.9rem,3.4vw,2.7rem)] font-medium tracking-tight">
                        <CountUp value={stat.value} />
                    </strong>
                    <span className={cn('mt-1.5 block text-sm', onDark ? 'text-[#a89e8f]' : 'text-ink-soft')}>
                        {stat.label}
                    </span>
                </div>
            ))}
        </div>
    );
}
