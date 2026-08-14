import { useEffect, useRef } from 'react';
import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, CalendarHeart } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import Card from '@/components/scrollxui/Card';
import StaggerButton from '@/components/scrollxui/StaggerButton';
import CtaBand from '@/components/site/CtaBand';
import PageHero from '@/components/site/PageHero';

function formatDate(value) {
    if (!value) return null;
    return new Date(value).toLocaleDateString('en-AU', { day: 'numeric', month: 'short', year: 'numeric' });
}

export default function BlogShow({ blog, related = [] }) {
    const meta = [blog.author, formatDate(blog.published_at)].filter(Boolean).join(' · ');
    const bodyRef = useRef(null);

    useEffect(() => {
        bodyRef.current?.querySelectorAll('img').forEach((img) => {
            img.loading = 'lazy';
            img.decoding = 'async';
        });
    }, [blog.body]);

    return (
        <SiteLayout title={blog.title} description={blog.excerpt ?? String(blog.body ?? '').replace(/<[^>]+>/g, '').slice(0, 155)}>
            <PageHero
                crumbs={[{ label: 'Blog', href: '/blog' }, { label: blog.title }]}
                eyebrow="Blog"
                heading={blog.title}
                lede={meta || undefined}
            />

            <section className="pb-8 pt-6">
                <div className="container-site grid gap-10 lg:grid-cols-[1.5fr_1fr]">
                    <motion.div
                        initial={{ opacity: 0, y: 24 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.55 }}
                    >
                        {blog.cover_image && (
                            <div className="mb-8 aspect-[16/9] w-full overflow-hidden rounded-lg bg-rose-soft">
                                <img src={blog.cover_image} alt={blog.title} className="h-full w-full object-cover" />
                            </div>
                        )}
                        <div ref={bodyRef} className="blog-body max-w-2xl" dangerouslySetInnerHTML={{ __html: blog.body ?? '' }} />
                    </motion.div>

                    <motion.aside
                        initial={{ opacity: 0, y: 24 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.55, delay: 0.1 }}
                        className="h-fit rounded-lg bg-rose-soft p-8 lg:sticky lg:top-28"
                    >
                        <h3 className="t-card-title">Want a hand with this?</h3>
                        <p className="mt-2 text-[15px] leading-relaxed text-ink-soft">
                            A dedicated offshore assistant can help put what you just read into practice.
                        </p>
                        <div className="mt-6 flex flex-col gap-3">
                            <StaggerButton href="/book-a-call" icon={CalendarHeart} className="w-full">
                                Book a Discovery Call
                            </StaggerButton>
                            <StaggerButton href="/contact" variant="secondary" className="w-full">
                                Send an enquiry
                            </StaggerButton>
                        </div>
                    </motion.aside>
                </div>
            </section>

            {related.length > 0 && (
                <section className="section pt-0">
                    <div className="container-site">
                        <p className="t-eyebrow mb-3 text-rose-deep">More from the blog</p>
                        <h2 className="t-headline mb-8">Keep reading</h2>
                        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            {related.map((item) => (
                                <Card key={item.id} href={`/blog/${item.slug}`} className="flex h-full flex-col">
                                    <h3 className="t-card-title">{item.title}</h3>
                                    {item.excerpt && (
                                        <p className="mt-2.5 flex-1 text-[15px] leading-relaxed text-ink-soft">{item.excerpt}</p>
                                    )}
                                    <span className="mt-5 inline-flex items-center gap-2 text-[14px] font-bold text-rose-deep">
                                        Read more <ArrowRight className="h-4 w-4" strokeWidth={2.4} />
                                    </span>
                                </Card>
                            ))}
                        </div>
                    </div>
                </section>
            )}

            <CtaBand />
        </SiteLayout>
    );
}
