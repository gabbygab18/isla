import RevealText from '@/components/scrollxui/RevealText';
import { cn } from '@/lib/utils';

export default function SectionHead({ eyebrow, eyebrowColor = 'text-rose-deep', heading, intro, center = false, className }) {
    return (
        <div className={cn('mb-10 max-w-2xl md:mb-14', center && 'mx-auto text-center', className)}>
            {eyebrow && <p className={cn('t-eyebrow mb-3', eyebrowColor)}>{eyebrow}</p>}
            {heading && <RevealText text={heading} className="t-display-lg" />}
            {intro && <p className="t-body-lg mt-4 text-ink-soft">{intro}</p>}
        </div>
    );
}
