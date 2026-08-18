import { useEffect, useRef, useState } from 'react';
import { Link } from '@inertiajs/react';
import { motion, useInView } from 'framer-motion';
import AdminLayout from '@/Layouts/AdminLayout';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

function CountUp({ value }) {
    const ref = useRef(null);
    const inView = useInView(ref, { once: true });
    const [display, setDisplay] = useState(0);

    useEffect(() => {
        if (!inView) return;
        let start = null;
        const duration = 800;
        let frame;
        const step = (ts) => {
            if (start === null) start = ts;
            const progress = Math.min((ts - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            setDisplay(Math.round(eased * value));
            if (progress < 1) frame = requestAnimationFrame(step);
        };
        frame = requestAnimationFrame(step);
        return () => cancelAnimationFrame(frame);
    }, [inView, value]);

    return <span ref={ref}>{display}</span>;
}

function StatCard({ label, value, href, linkLabel = 'Manage', index }) {
    return (
        <motion.div
            initial={{ opacity: 0, y: 16 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.4, delay: (index % 10) * 0.04, ease: [0.22, 1, 0.36, 1] }}
            whileHover={{ y: -4 }}
            className="rounded-lg border border-hairline-soft bg-white p-[18px] transition-shadow duration-200 hover:shadow-card"
        >
            <div className="text-[30px] font-extrabold leading-none text-ink"><CountUp value={value} /></div>
            <div className="mt-2 font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">{label}</div>
            <Link href={href} className="mt-1 inline-block text-[12.5px] font-semibold text-rose-deep">{linkLabel} →</Link>
        </motion.div>
    );
}

export default function Dashboard({ stats, recentMessages = [] }) {
    const cards = [
        ['Audiences', stats.audiences, '/admin/audiences'],
        ['Services', stats.services, '/admin/services'],
        ['Process steps', stats.processSteps, '/admin/process-steps'],
        ['Benefits', stats.benefits, '/admin/benefits'],
        ['Pricing plans', stats.pricingPlans, '/admin/pricing-plans'],
        ['FAQs', stats.faqs, '/admin/faqs'],
        ['Testimonials', stats.testimonials, '/admin/testimonials'],
        ['Blog posts', stats.blogs, '/admin/blogs'],
        ['Menu items', stats.navItems, '/admin/nav-items'],
        [`Messages (${stats.unread} unread)`, stats.messages, '/admin/messages', 'View'],
    ];

    return (
        <AdminLayout title="Dashboard" heading="Dashboard">
            <div className="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                {cards.map(([label, value, href, linkLabel], i) => (
                    <StatCard key={label} label={label} value={value} href={href} linkLabel={linkLabel} index={i} />
                ))}
            </div>

            <div className="mb-5 flex items-center justify-between">
                <h2 className="text-[22px] font-bold">Recent enquiries</h2>
                <Link href="/admin/messages" className="rounded-md border border-hairline px-3.5 py-2 text-[13.5px] font-semibold text-ink transition-colors hover:bg-cream">All messages</Link>
            </div>

            {recentMessages.length === 0 ? (
                <div className="rounded-lg border border-hairline-soft bg-white p-6 text-[14.5px] text-ink-soft">
                    No enquiries yet. Submissions from the site's contact form will appear here.
                </div>
            ) : (
                <div className="overflow-x-auto rounded-lg border border-hairline-soft bg-white">
                    <Table>
                        <TableHeader>
                            <TableRow className="border-hairline-soft bg-cream/60 hover:bg-cream/60">
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Name</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Email</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Sector</TableHead>
                                <TableHead className="font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Received</TableHead>
                                <TableHead className="text-right font-mono text-[10.5px] uppercase tracking-[0.08em] text-ink-soft">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {recentMessages.map((m) => (
                                <TableRow key={m.id} className="border-hairline-soft">
                                    <TableCell className="whitespace-normal">
                                        <p className="font-bold text-ink">
                                            {m.full_name}
                                            {!m.is_read && <span className="ml-2 rounded-pill bg-rose-soft px-2 py-0.5 text-[10.5px] font-bold text-rose-deep">New</span>}
                                        </p>
                                    </TableCell>
                                    <TableCell className="text-[13.5px] text-ink-soft">{m.email}</TableCell>
                                    <TableCell className="text-[13.5px] text-ink-soft">{m.sector || '—'}</TableCell>
                                    <TableCell className="text-[13.5px] text-ink-soft">{new Date(m.created_at).toLocaleDateString('en-AU', { day: 'numeric', month: 'short', year: 'numeric' })}</TableCell>
                                    <TableCell className="text-right">
                                        <Link href={`/admin/messages/${m.id}`} className="rounded-md border border-hairline px-3 py-1.5 text-[13px] font-semibold text-ink-soft transition-colors hover:border-ink/40 hover:text-ink">
                                            Open
                                        </Link>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            )}
        </AdminLayout>
    );
}
