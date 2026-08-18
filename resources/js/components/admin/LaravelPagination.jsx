import { router } from '@inertiajs/react';
import { Pagination, PaginationContent, PaginationEllipsis, PaginationItem, PaginationLink } from '@/components/ui/pagination';

/**
 * Renders a Laravel paginator's `links` array (prev/numbered/next, each
 * {url, label, active}) with the scrollxui Pagination component. The
 * component's PaginationLink is a plain <a>, not polymorphic, so clicks are
 * intercepted and routed through Inertia's client-side visit instead of a
 * full reload.
 */
export default function LaravelPagination({ links = [] }) {
    if (links.length <= 3) return null;

    const visit = (e, url) => {
        e.preventDefault();
        router.get(url, {}, { preserveState: true, preserveScroll: true });
    };

    return (
        <Pagination className="mt-8 justify-start">
            <PaginationContent>
                {links.map((link, i) => {
                    const label = link.label.replace('&laquo;', '‹').replace('&raquo;', '›');
                    if (label === '...') {
                        return (
                            <PaginationItem key={i}>
                                <PaginationEllipsis />
                            </PaginationItem>
                        );
                    }
                    return (
                        <PaginationItem key={i}>
                            <PaginationLink
                                href={link.url || '#'}
                                isActive={link.active}
                                size={i === 0 || i === links.length - 1 ? 'default' : 'icon'}
                                className={!link.url ? 'pointer-events-none opacity-40' : ''}
                                onClick={(e) => link.url && visit(e, link.url)}
                            >
                                {label}
                            </PaginationLink>
                        </PaginationItem>
                    );
                })}
            </PaginationContent>
        </Pagination>
    );
}
