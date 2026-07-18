/**
 * ButterflyBackdrop — subtle white butterfly print scattered over the beige
 * (cream) page background, per client request. Sits on a fixed -z-10 layer,
 * so any section with a solid background (white cards, footer, ink bands)
 * naturally covers it — butterflies only show through the beige areas.
 *
 * Tune OPACITY / BUTTERFLIES below to taste.
 */

const OPACITY = 0.55; // overall layer opacity (white on cream is already low-contrast)

// Deterministic "random" scatter: position (%), size (px), rotation (deg), per-item opacity
const BUTTERFLIES = [
    { top: '6%', left: '4%', size: 150, rotate: -18, o: 1 },
    { top: '14%', right: '6%', size: 110, rotate: 14, o: 0.85 },
    { top: '30%', left: '12%', size: 90, rotate: 8, o: 0.8 },
    { top: '38%', right: '14%', size: 170, rotate: -10, o: 1 },
    { top: '52%', left: '3%', size: 120, rotate: 22, o: 0.9 },
    { top: '58%', right: '4%', size: 95, rotate: -26, o: 0.8 },
    { top: '72%', left: '16%', size: 140, rotate: 12, o: 1 },
    { top: '80%', right: '10%', size: 115, rotate: -14, o: 0.85 },
    { top: '90%', left: '6%', size: 100, rotate: 18, o: 0.8 },
];

export default function ButterflyBackdrop() {
    return (
        <div
            aria-hidden="true"
            className="pointer-events-none fixed inset-0 -z-10 overflow-hidden"
            style={{ opacity: OPACITY }}
        >
            {BUTTERFLIES.map((b, i) => (
                <img
                    key={i}
                    src="/butterfly.png"
                    alt=""
                    loading="lazy"
                    draggable="false"
                    className="absolute select-none"
                    style={{
                        top: b.top,
                        left: b.left,
                        right: b.right,
                        width: b.size,
                        height: 'auto',
                        opacity: b.o,
                        transform: `rotate(${b.rotate}deg)`,
                    }}
                />
            ))}
        </div>
    );
}
