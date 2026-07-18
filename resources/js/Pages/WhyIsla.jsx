import { usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { Check, Minus } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import RevealText from '@/components/scrollxui/RevealText';
import SpotlightCard from '@/components/scrollxui/SpotlightCard';
import CtaBand from '@/components/site/CtaBand';
import PageHero from '@/components/site/PageHero';
import SectionHead from '@/components/site/SectionHead';
import { makeSetting } from '@/lib/utils';

const ROWS = [
    ['Pricing model', 'One flat management fee', 'Hidden % markup', 'Salary + super + overheads'],
    ["Replacement if it's not working", 'check:Lifetime guarantee', '30–90 days, if at all', 'Restart recruitment'],
    ['Time to start', '~2 weeks', '4–6 weeks', '2–3 months'],
    ['Sector-aware onboarding (NDIS / health)', 'check:Built in', 'Rarely', 'You train from scratch'],
    ['Named point of contact', 'check:Always', 'Ticket queue', 'dash'],
];

function IslaCell({ value }) {
    const isCheck = value.startsWith('check:');
    return (
        <span className="inline-flex items-center gap-2 font-semibold text-sage-deep">
            {isCheck && <Check className="h-4 w-4" strokeWidth={2.6} />}
            {isCheck ? value.slice(6) : value}
        </span>
    );
}

export default function WhyIsla({ benefits = [] }) {
    const setting = makeSetting(usePage().props?.settings);

    return (
        <SiteLayout title="Why Isla" description={setting('why_intro', 'Straightforward, on purpose.')}>
            <PageHero
                crumbs={[{ label: 'Why Isla' }]}
                eyebrow={setting('why_eyebrow', 'Why Isla')}
                heading={setting('why_heading', 'Straightforward, on purpose')}
                lede={setting('why_intro', 'The staffing industry is full of hidden markups and vague replacement policies. We built Isla around the opposite.')}
            />

            {/* benefits — scrollxui spotlightcard grid alongside the brand image */}
            <section className="pb-4 pt-6">
                <div className="container-site">
                    <div className="block-rose">
                        <div className="grid items-center gap-10 lg:grid-cols-2 lg:gap-14">
                            <motion.img
                                initial={{ opacity: 0, scale: 0.96 }}
                                whileInView={{ opacity: 1, scale: 1 }}
                                viewport={{ once: true }}
                                transition={{ duration: 0.6 }}
                                src={setting('why_image', 'https://images.unsplash.com/photo-1762955911431-4c44c7c3f408?w=1000&q=80&auto=format&fit=crop')}
                                alt="A caregiver assisting an elderly couple"
                                className="aspect-[4/4.6] w-full rounded-md object-cover"
                            />
                            <div className="flex flex-col gap-4">
                                {benefits.map((benefit, i) => (
                                    <SpotlightCard key={benefit.id} spotlightColor="rgba(143,157,119,0.2)" className="p-6">
                                        <div className="flex gap-4">
                                            <span className="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-ink text-cream">
                                                <Check className="h-3.5 w-3.5" strokeWidth={2.8} />
                                            </span>
                                            <div>
                                                <strong className="block font-display text-[16px] font-bold">{benefit.title}</strong>
                                                <span className="text-[14.5px] leading-relaxed text-ink-soft">{benefit.summary}</span>
                                            </div>
                                        </div>
                                    </SpotlightCard>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* comparison table */}
            <section className="section-tight">
                <div className="container-site">
                    <SectionHead
                        center
                        eyebrow="Side by side"
                        eyebrowColor="text-sage-deep"
                        heading={`How ${setting('brand_word', 'Isla')} compares`}
                    />
                    <motion.div
                        initial={{ opacity: 0, y: 28 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.55 }}
                        className="overflow-x-auto rounded-lg border border-hairline-soft bg-white shadow-float"
                    >
                        <table className="w-full min-w-[640px] border-collapse text-left">
                            <thead>
                                <tr className="border-b border-hairline">
                                    <th className="px-6 py-4" />
                                    <th className="t-caption bg-sage-soft px-6 py-4 text-sage-deep">{setting('brand_word', 'Isla')}</th>
                                    <th className="t-caption px-6 py-4 text-ink-soft">Typical agency</th>
                                    <th className="t-caption px-6 py-4 text-ink-soft">Local hire</th>
                                </tr>
                            </thead>
                            <tbody>
                                {ROWS.map((row, i) => (
                                    <tr key={i} className={i < ROWS.length - 1 ? 'border-b border-hairline-soft' : ''}>
                                        <td className="px-6 py-4 text-[15px] font-semibold">{row[0]}</td>
                                        <td className="bg-sage-soft px-6 py-4 text-[15px]"><IslaCell value={row[1]} /></td>
                                        <td className="px-6 py-4 text-[15px] text-ink-soft">{row[2]}</td>
                                        <td className="px-6 py-4 text-[15px] text-ink-soft">
                                            {row[3] === 'dash' ? <Minus className="h-4 w-4 opacity-40" /> : row[3]}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </motion.div>
                </div>
            </section>

            <CtaBand />
        </SiteLayout>
    );
}
