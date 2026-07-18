import { Link } from '@inertiajs/react';
import { ChevronRight } from 'lucide-react';
import RevealText from '@/components/scrollxui/RevealText';
import { cn } from '@/lib/utils';

export default function PageHero({ crumbs = [], eyebrow, eyebrowColor = 'text-rose-deep', heading, lede, children, className }) {
    return (
        <section className={cn('pb-4 pt-12 md:pt-16', className)}>
            <div className="container-site">
                {crumbs.length > 0 && (
                    <nav aria-label="Breadcrumb" className="mb-6 flex flex-wrap items-center gap-1.5 text-[13.5px] text-ink-soft">
                        <Link href="/" className="transition-colors hover:text-ink">Home</Link>
                        {crumbs.map((crumb, i) => (
                            <span key={i} className="flex items-center gap-1.5">
                                <ChevronRight className="h-3.5 w-3.5 opacity-60" />
                                {crumb.href ? (
                                    <Link href={crumb.href} className="transition-colors hover:text-ink">{crumb.label}</Link>
                                ) : (
                                    <span className="font-medium text-ink">{crumb.label}</span>
                                )}
                            </span>
                        ))}
                    </nav>
                )}
                {eyebrow && <p className={cn('t-eyebrow mb-3', eyebrowColor)}>{eyebrow}</p>}
                {heading && <RevealText text={heading} as="h1" className="t-display-lg max-w-3xl" />}
                {lede && <p className="t-body-lg mt-5 max-w-2xl text-ink-soft">{lede}</p>}
                {children}
            </div>
        </section>
    );
}
