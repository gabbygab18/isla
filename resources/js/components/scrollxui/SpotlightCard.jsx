import { useRef, useState } from 'react';
import { cn } from '@/lib/utils';

/**
 * ScrollXUI-style `spotlightcard` — a card with a radial highlight
 * that follows the cursor.
 */
export default function SpotlightCard({
    children,
    className,
    spotlightColor = 'rgba(219, 148, 150, 0.22)',
    as: Tag = 'div',
    ...props
}) {
    const ref = useRef(null);
    const [pos, setPos] = useState({ x: 0, y: 0 });
    const [opacity, setOpacity] = useState(0);

    const onMove = (e) => {
        const rect = ref.current?.getBoundingClientRect();
        if (!rect) return;
        setPos({ x: e.clientX - rect.left, y: e.clientY - rect.top });
    };

    return (
        <Tag
            ref={ref}
            onMouseMove={onMove}
            onMouseEnter={() => setOpacity(1)}
            onMouseLeave={() => setOpacity(0)}
            className={cn(
                'relative overflow-hidden rounded-lg border border-hairline-soft bg-white p-7 transition-shadow duration-300 hover:shadow-card',
                className,
            )}
            {...props}
        >
            <span
                aria-hidden="true"
                className="pointer-events-none absolute inset-0 transition-opacity duration-300"
                style={{
                    opacity,
                    background: `radial-gradient(320px circle at ${pos.x}px ${pos.y}px, ${spotlightColor}, transparent 65%)`,
                }}
            />
            <div className="relative z-10">{children}</div>
        </Tag>
    );
}
