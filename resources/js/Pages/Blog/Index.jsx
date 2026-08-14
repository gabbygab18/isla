import { Link, usePage } from '@inertiajs/react';
import { ArrowRight } from 'lucide-react';
import SiteLayout from '@/Layouts/SiteLayout';
import Card from '@/components/scrollxui/Card';
import CtaBand from '@/components/site/CtaBand';
import PageHero from '@/components/site/PageHero';
import { makeSetting } from '@/lib/utils';

function formatDate(value) {
    if (!value) return null;
    return new Date(value).toLocaleDateString('en-AU', { day: 'numeric', month: 'short', year: 'numeric' });
}

export default function BlogIndex({ blogs = [] }) {
    const setting = makeSetting(usePage().props?.settings);

    return (
        <SiteLayout title="Blog" description={setting('blog_heading', 'Insights on building an offshore team that actually works')}>
            <PageHero
                crumbs={[{ label: 'Blog' }]}
                eyebrow={setting('blog_eyebrow', 'Blog')}
                heading={setting('blog_heading', 'Insights on building an offshore team that actually works')}
            />

            <section className="pb-8 pt-6">
                <div className="container-site">
                    {blogs.length > 0 ? (
                        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            {blogs.map((blog, i) => (
                                <Card key={blog.id} href={`/blog/${blog.slug}`} index={i} className="flex h-full flex-col p-0 overflow-hidden">
                                    {blog.cover_image && (
                                        <div className="aspect-[16/10] w-full overflow-hidden bg-rose-soft">
                                            <img
                                                src={blog.cover_image}
                                                alt={blog.title}
                                                loading={i < 3 ? 'eager' : 'lazy'}
                                                decoding="async"
                                                className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                            />
                                        </div>
                                    )}
                                    <div className="flex flex-1 flex-col p-6">
                                        {(blog.author || blog.published_at) && (
                                            <p className="t-caption mb-2 text-ink-soft/70">
                                                {[blog.author, formatDate(blog.published_at)].filter(Boolean).join(' · ')}
                                            </p>
                                        )}
                                        <h3 className="t-card-title">{blog.title}</h3>
                                        {blog.excerpt && (
                                            <p className="mt-2.5 flex-1 text-[15px] leading-relaxed text-ink-soft">{blog.excerpt}</p>
                                        )}
                                        <span className="mt-5 inline-flex items-center gap-2 text-[14px] font-bold text-rose-deep">
                                            Read more <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" strokeWidth={2.4} />
                                        </span>
                                    </div>
                                </Card>
                            ))}
                        </div>
                    ) : (
                        <p className="py-6 text-center text-[15.5px] opacity-80">
                            No posts yet — check back soon, or{' '}
                            <Link href="/book-a-call" className="font-bold underline">
                                book a discovery call
                            </Link>
                            .
                        </p>
                    )}
                </div>
            </section>

            <CtaBand />
        </SiteLayout>
    );
}
