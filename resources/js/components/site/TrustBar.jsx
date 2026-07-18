import { usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { Clock, Globe, MapPin, ShieldCheck } from 'lucide-react';
import { makeSetting } from '@/lib/utils';

/**
 * The four credibility markers, animated in with a stagger
 * (scrollxui: statscount treatment applied to trust signals).
 */
export default function TrustBar() {
    const setting = makeSetting(usePage().props?.settings);

    const items = [
        { icon: MapPin, text: setting('trust_location', 'Location: Across Australia') },
        { icon: Clock, text: setting('trust_response', 'Most clients get a response same business day') },
        { icon: ShieldCheck, text: setting('trust_industries', 'Trusted by Australian businesses across multiple industries') },
        { icon: Globe, text: setting('trust_managed', 'Australian-managed, Philippines-based') },
    ];

    return (
        <div className="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            {items.map((item, i) => (
                <motion.div
                    key={i}
                    initial={{ opacity: 0, y: 18 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.45, delay: i * 0.08 }}
                    className="flex items-center gap-3.5 rounded-lg border border-hairline-soft bg-white px-5 py-4"
                >
                    <span className="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sage-soft text-sage-deep">
                        <item.icon className="h-[18px] w-[18px]" strokeWidth={2.2} />
                    </span>
                    <span className="text-[13.5px] font-semibold leading-snug">{item.text}</span>
                </motion.div>
            ))}
        </div>
    );
}
