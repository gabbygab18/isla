import { Link } from '@inertiajs/react';
import LeanCard from '@/components/scrollxui/LeanCard';
import { cn } from '@/lib/utils';

/**
 * Pricing plan grid built on the scrollxui lean-card.
 */
export default function PricingGrid({ plans = [] }) {
    return (
        <div className="grid gap-5 md:grid-cols-3">
            {plans.map((plan, i) => (
                <LeanCard key={plan.id ?? i} index={i} featured={!!plan.is_featured}>
                    {plan.ribbon && (
                        <span className="absolute -top-3 right-6 rounded-pill bg-rose px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-ink">
                            {plan.ribbon}
                        </span>
                    )}
                    <h3 className="t-card-title">{plan.name}</h3>
                    <p className={cn('t-caption mt-1.5', plan.is_featured ? 'text-rose' : 'text-rose-deep')}>{plan.tag}</p>
                    <p className={cn('mt-4 font-display text-[26px] font-medium tracking-tight')}>{plan.detail}</p>
                    <p className={cn('mt-3 flex-1 text-[15px] leading-relaxed', plan.is_featured ? 'text-cream/75' : 'text-ink-soft')}>
                        {plan.summary}
                    </p>
                    <Link
                        href={`/pricing/${plan.slug}`}
                        className={cn(
                            'mt-7 inline-flex w-full items-center justify-center rounded-pill px-6 py-3.5 text-[14.5px] font-semibold transition-colors',
                            plan.is_featured
                                ? 'bg-cream text-ink hover:bg-white'
                                : 'border border-hairline bg-white hover:border-ink/40',
                        )}
                    >
                        View plan details
                    </Link>
                </LeanCard>
            ))}
        </div>
    );
}
