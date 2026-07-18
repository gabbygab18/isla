import { useMemo, useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import SiteLayout from '@/Layouts/SiteLayout';
import ExpandableCards from '@/components/scrollxui/ExpandableCards';
import SearchCell from '@/components/scrollxui/SearchCell';
import CtaBand from '@/components/site/CtaBand';
import PageHero from '@/components/site/PageHero';
import { makeSetting } from '@/lib/utils';

export default function FaqsIndex({ faqs = [] }) {
    const setting = makeSetting(usePage().props?.settings);
    const [query, setQuery] = useState('');

    const filtered = useMemo(() => {
        const q = query.trim().toLowerCase();
        if (!q) return faqs;
        return faqs.filter((faq) => `${faq.question} ${faq.answer}`.toLowerCase().includes(q));
    }, [faqs, query]);

    return (
        <SiteLayout title="FAQ" description={setting('faq_heading', 'Questions we get on almost every discovery call')}>
            <PageHero
                crumbs={[{ label: 'FAQ' }]}
                eyebrow={setting('faq_eyebrow', 'FAQ')}
                heading={setting('faq_heading', 'Questions we get on almost every discovery call')}
            />

            <section className="pb-8 pt-6">
                <div className="container-site">
                    {/* scrollxui: search-cell */}
                    <SearchCell
                        value={query}
                        onChange={setQuery}
                        placeholder="Search a question — e.g. replacement, pricing, time zone..."
                        className="mb-8"
                    />
                    <div className="block-rose">
                        {filtered.length > 0 ? (
                            <ExpandableCards
                                items={filtered.map((faq) => ({
                                    id: faq.id,
                                    title: faq.question,
                                    content: <p>{faq.answer}</p>,
                                    slug: faq.slug,
                                }))}
                                renderExtra={(item) => (
                                    <Link href={`/faq/${item.slug}`} className="mt-3 inline-block font-bold text-rose-deep underline">
                                        Read more
                                    </Link>
                                )}
                            />
                        ) : (
                            <p className="py-6 text-center text-[15.5px] opacity-80">
                                No matches — try a different word, or{' '}
                                <Link href="/book-a-call" className="font-bold underline">
                                    ask us on a discovery call
                                </Link>
                                .
                            </p>
                        )}
                    </div>
                </div>
            </section>

            <CtaBand />
        </SiteLayout>
    );
}
