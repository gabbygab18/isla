<?php

namespace App\Support;

use App\Models\Audience;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\ProcessStep;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Server-rendered SEO metadata.
 *
 * The site is a client-side Inertia app with no SSR, so anything the React
 * layer puts in <head> is invisible to crawlers that do not execute
 * JavaScript — which includes the Facebook, LinkedIn and Slack link
 * scrapers. Everything here is emitted by Blade on the initial response so
 * those crawlers see real titles, descriptions and Open Graph tags.
 *
 * Titles and descriptions can be overridden per page from the admin
 * Settings screen using the keys listed in defaults().
 */
class Seo
{
    /** Cached per request — build() may be called from Blade and middleware. */
    protected static ?array $built = null;

    public static function build(Request $request): array
    {
        if (static::$built !== null) {
            return static::$built;
        }

        $brand   = static::setting('brand_word', 'Isla');
        $base    = 'https://' . $request->getHost();
        $path    = trim($request->path(), '/');
        $url     = $path === '' ? $base . '/' : $base . '/' . $path;
        $routeNm = $request->route()?->getName() ?? '';

        [$title, $description, $breadcrumbs, $extraSchema] =
            static::forRoute($routeNm, $request, $brand, $base);

        static::$built = [
            'title'       => $title,
            'description' => $description,
            'canonical'   => $url,
            'image'       => static::setting('og_image', $base . '/og-image.png'),
            'brand'       => $brand,
            'locale'      => 'en_AU',
            'noindex'     => (bool) preg_match('#^admin#', $path),
            'schema'      => static::schema($base, $brand, $url, $title, $description, $breadcrumbs, $extraSchema),
        ];

        return static::$built;
    }

    /* =========================================================
     |  Per-route title + description
     | ========================================================= */

    /**
     * Static pages. key => [settings key prefix, title, description]
     */
    protected static function defaults(): array
    {
        return [
            'isla.index' => [
                'home',
                'Isla — Managed Virtual Staffing for Growing Australian Businesses',
                'Dedicated virtual assistants for NDIS providers, healthcare and allied health practices, and growing Australian businesses. One inclusive hourly rate, with recruitment, onboarding and ongoing workforce management handled for you.',
            ],
            'isla.about' => [
                'about',
                'About Us — Managed Virtual Staffing Built Around Australian Businesses',
                'Isla is a managed virtual staffing partner run by a Philippines-based team. We handle recruitment, onboarding, payroll and performance so you can focus on the work your assistant frees up.',
            ],
            'isla.team.index' => [
                'team',
                'Team We Build — The Roles We Place for Australian Businesses',
                'Administration, client coordination, bookkeeping, intake and scheduling support. See the roles Isla recruits for and how they come together into a team around your business.',
            ],
            'isla.audiences.index' => [
                'audiences',
                'Industries We Support — NDIS, Healthcare and Allied Health',
                'Isla builds virtual assistants around the sectors we know best: NDIS providers, healthcare and allied health practices, and growing Australian service businesses.',
            ],
            'isla.services.index' => [
                'services',
                'Services — Virtual Staffing and Managed Support',
                'From administration and client communication to scheduling, documentation and compliance support. See the services Isla assistants take off your plate.',
            ],
            'isla.how-it-works' => [
                'process',
                'How It Works — From Discovery Call to a Placed Assistant',
                'A clear four-step process: discovery call, role scoping, shortlisting and structured onboarding. See exactly what Isla handles and what stays with you.',
            ],
            'isla.why-isla' => [
                'why',
                'Why Isla — Managed Staffing, Not a Freelancer Marketplace',
                'A freelancer marketplace ends at the introduction. Isla starts there — with payroll, HR, IT, account management and replacement cover behind every placement.',
            ],
            'isla.pricing.index' => [
                'pricing',
                'Pricing — One Inclusive Hourly Rate, No Hidden Extras',
                'Transparent pricing for managed virtual staffing. Recruitment, onboarding, payroll administration and ongoing support are included in a single hourly rate.',
            ],
            'isla.faq.index' => [
                'faq',
                'Frequently Asked Questions About Managed Virtual Staffing',
                'How placements work, what the hourly rate covers, working hours, data security and replacement support. Straight answers to the questions Australian businesses ask most.',
            ],
            'isla.testimonials' => [
                'testimonials',
                'Testimonials — What Australian Clients Say About Isla',
                'Feedback from the Australian businesses Isla supports, on onboarding, day-to-day reliability and what changed once a dedicated assistant joined the team.',
            ],
            'isla.blog.index' => [
                'blog',
                'Blog — Insights on Managed Virtual Staffing',
                'Practical guidance on hiring, managing and growing an offshore team — direct hiring risks, compliance, and what managed virtual staffing actually covers.',
            ],
            'isla.careers' => [
                'careers',
                'Careers — Build Your Career With Isla in the Philippines',
                'Join a team that places Filipino professionals with Australian businesses. Proper local employment, real benefits and account management that checks in.',
            ],
            'isla.contact.page' => [
                'contact',
                'Contact Isla — Talk to Our Team About Virtual Staffing',
                'Tell us what your business needs support with and we will come back with a realistic scope, a rate and the kind of assistant that fits.',
            ],
            'isla.cost-estimator' => [
                'calc',
                'Cost Estimator — Compare Local and Offshore Staffing Costs',
                'Estimate what a dedicated Isla assistant costs against an equivalent Australian hire, by role, experience level and working arrangement.',
            ],
            'isla.book-call' => [
                'book',
                'Book a Discovery Call With Isla',
                'A short, no-obligation call to scope the role, talk through your working hours and outline what a managed placement would look like for your business.',
            ],
        ];
    }

    protected static function forRoute(string $route, Request $request, string $brand, string $base): array
    {
        $defaults = static::defaults();

        if (isset($defaults[$route])) {
            [$prefix, $title, $description] = $defaults[$route];

            return [
                static::setting("seo_{$prefix}_title", $title),
                static::setting("seo_{$prefix}_description", $description),
                [],
                null,
            ];
        }

        // ---- detail pages -------------------------------------------------
        return match ($route) {
            'isla.audiences.show' => static::detail(
                $request->route('audience'),
                'title',
                'summary',
                'Industries We Support',
                $base . '/who-we-work-with',
                fn ($m) => $m->title . ' — Virtual Assistants and Managed Support',
                'Managed virtual staffing',
            ),
            'isla.services.show' => static::detail(
                $request->route('service'),
                'title',
                'summary',
                'Services',
                $base . '/services',
                fn ($m) => $m->title . ' — Managed Virtual Staffing Service',
                'Virtual assistant services',
            ),
            'isla.pricing.show' => static::detail(
                $request->route('plan'),
                'name',
                'summary',
                'Pricing',
                $base . '/pricing',
                fn ($m) => $m->name . ' Plan — Isla Pricing',
            ),
            'isla.faqs.show' => static::faqDetail($request->route('faq'), $base),
            'isla.blog.show' => static::blogDetail($request->route('blog'), $base),
            default => [
                $brand . ' — Managed Virtual Staffing for Australian Businesses',
                static::setting('seo_home_description', 'Dedicated virtual assistants for NDIS providers, healthcare and allied health practices, and growing Australian businesses.'),
                [],
                null,
            ],
        };
    }

    protected static function detail($model, string $titleField, string $summaryField, string $parentLabel, string $parentUrl, callable $titleFn, ?string $serviceType = null): array
    {
        if (! $model) {
            return ['Isla — Managed Virtual Staffing', '', [], null];
        }

        $name    = (string) $model->{$titleField};
        $summary = static::trim(strip_tags((string) $model->{$summaryField}), 158);

        // A Service node states plainly what is offered, by whom, to whom —
        // the shape answer engines quote from.
        $service = $serviceType ? array_filter([
            '@type'       => 'Service',
            'name'        => $name,
            'description' => $summary,
            'serviceType' => $serviceType,
            'provider'    => ['@id' => 'https://' . request()->getHost() . '/#organization'],
            'areaServed'  => ['@type' => 'Country', 'name' => 'Australia'],
        ]) : null;

        return [
            $titleFn($model),
            $summary,
            [
                ['name' => $parentLabel, 'url' => $parentUrl],
                ['name' => $name, 'url' => null],
            ],
            $service,
        ];
    }

    protected static function faqDetail($faq, string $base): array
    {
        if (! $faq) {
            return ['FAQ — Isla', '', [], null];
        }

        $answer = static::trim(strip_tags((string) $faq->answer), 158);

        return [
            (string) $faq->question,
            $answer,
            [
                ['name' => 'FAQ', 'url' => $base . '/faq'],
                ['name' => (string) $faq->question, 'url' => null],
            ],
            [
                '@type' => 'QAPage',
                'mainEntity' => [
                    '@type' => 'Question',
                    'name' => (string) $faq->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => strip_tags((string) $faq->answer),
                    ],
                ],
            ],
        ];
    }

    protected static function blogDetail($blog, string $base): array
    {
        if (! $blog) {
            return ['Blog — Isla', '', [], null];
        }

        $description = $blog->excerpt
            ? static::trim($blog->excerpt, 158)
            : static::trim(strip_tags((string) $blog->body), 158);

        $image = $blog->cover_image ?: ($base . '/og-image.png');

        return [
            $blog->title . ' — Isla Blog',
            $description,
            [
                ['name' => 'Blog', 'url' => $base . '/blog'],
                ['name' => (string) $blog->title, 'url' => null],
            ],
            array_filter([
                '@type'         => 'BlogPosting',
                'headline'      => (string) $blog->title,
                'description'   => $description,
                'image'         => $image,
                'author'        => $blog->author ? ['@type' => 'Person', 'name' => $blog->author] : ['@id' => $base . '/#organization'],
                'publisher'     => ['@id' => $base . '/#organization'],
                'datePublished' => optional($blog->published_at)->toIso8601String(),
                'dateModified'  => optional($blog->updated_at ?: $blog->published_at)->toIso8601String(),
                'mainEntityOfPage' => ['@id' => $base . '/blog/' . $blog->slug . '#webpage'],
            ]),
        ];
    }

    /* =========================================================
     |  Structured data
     | ========================================================= */

    protected static function schema(string $base, string $brand, string $url, string $title, string $description, array $breadcrumbs, ?array $extra): array
    {
        $organisation = array_filter([
            // ProfessionalService is a LocalBusiness subtype — it carries the
            // address and service area, which is what answer engines read when
            // deciding what this company actually is and who it serves.
            '@type'       => 'ProfessionalService',
            '@id'         => $base . '/#organization',
            'name'        => $brand,
            'alternateName' => 'Isla Outsourcing Solutions',
            'url'         => $base . '/',
            'logo'        => $base . '/logo.png',
            'image'       => $base . '/og-image.png',
            'address'     => static::setting('contact_location', null),
            'knowsAbout'  => [
                'Virtual assistants',
                'Managed offshore staffing',
                'NDIS provider administration',
                'Allied health practice support',
                'Medical receptionist outsourcing',
                'Bookkeeping and payroll support',
                'Appointment setting and CRM administration',
            ],
            'description' => static::setting('seo_home_description', 'Managed virtual staffing for growing Australian businesses.'),
            'email'       => static::setting('contact_email', null),
            'telephone'   => static::setting('contact_phone', null),
            'areaServed'  => ['@type' => 'Country', 'name' => 'Australia'],
            // Defaults match the icons rendered in the footer (SiteLayout.jsx).
            // sameAs is how Google ties the site to the company's social
            // profiles when building its entity graph.
            'sameAs'      => array_values(array_filter([
                static::setting('social_linkedin', 'https://www.linkedin.com/company/islaoutsourcingsolutions'),
                static::setting('social_facebook', 'https://www.facebook.com/profile.php?id=61581617805323'),
                static::setting('social_instagram', null),
            ])),
        ], fn ($v) => $v !== null && $v !== '' && $v !== []);

        $graph = [
            $organisation,
            [
                '@type'     => 'WebSite',
                '@id'       => $base . '/#website',
                'url'       => $base . '/',
                'name'      => $brand,
                'publisher' => ['@id' => $base . '/#organization'],
                'inLanguage' => 'en-AU',
            ],
            [
                '@type'       => 'WebPage',
                '@id'         => $url . '#webpage',
                'url'         => $url,
                'name'        => $title,
                'description' => $description,
                'isPartOf'    => ['@id' => $base . '/#website'],
                'inLanguage'  => 'en-AU',
            ],
        ];

        if ($breadcrumbs) {
            $items = [[
                '@type'    => 'ListItem',
                'position' => 1,
                'name'     => 'Home',
                'item'     => $base . '/',
            ]];

            foreach ($breadcrumbs as $i => $crumb) {
                $entry = [
                    '@type'    => 'ListItem',
                    'position' => $i + 2,
                    'name'     => $crumb['name'],
                ];

                if (! empty($crumb['url'])) {
                    $entry['item'] = $crumb['url'];
                }

                $items[] = $entry;
            }

            $graph[] = [
                '@type'           => 'BreadcrumbList',
                '@id'             => $url . '#breadcrumb',
                'itemListElement' => $items,
            ];
        }

        if ($extra) {
            $graph[] = $extra;
        }

        // FAQ index and the homepage both render the live FAQ list on the
        // page — both genuinely qualify for a FAQPage block.
        if (in_array(request()->route()?->getName(), ['isla.faq.index', 'isla.index'], true)) {
            try {
                $faqs = Faq::active()->get(['question', 'answer']);

                if ($faqs->isNotEmpty()) {
                    $graph[] = [
                        '@type'      => 'FAQPage',
                        '@id'        => $url . '#faq',
                        'mainEntity' => $faqs->map(fn ($faq) => [
                            '@type'          => 'Question',
                            'name'           => (string) $faq->question,
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text'  => strip_tags((string) $faq->answer),
                            ],
                        ])->all(),
                    ];
                }
            } catch (\Throwable $e) {
                // DB unavailable — skip the FAQ block rather than break the page.
            }
        }

        // How It Works genuinely lays out the placement process as numbered
        // steps — a HowTo block is what answer engines quote for "how does
        // it work" style queries.
        if (request()->route()?->getName() === 'isla.how-it-works') {
            try {
                $steps = ProcessStep::active()->get(['number', 'title', 'summary']);

                if ($steps->isNotEmpty()) {
                    $graph[] = [
                        '@type' => 'HowTo',
                        '@id'   => $url . '#howto',
                        'name'  => 'How Isla places a virtual assistant with your business',
                        'step'  => $steps->values()->map(fn ($step, $i) => array_filter([
                            '@type'    => 'HowToStep',
                            'position' => $i + 1,
                            'name'     => (string) $step->title,
                            'text'     => strip_tags((string) $step->summary),
                        ]))->all(),
                    ];
                }
            } catch (\Throwable $e) {
                // DB unavailable — skip the HowTo block rather than break the page.
            }
        }

        return [
            '@context' => 'https://schema.org',
            '@graph'   => $graph,
        ];
    }

    /* =========================================================
     |  Helpers
     | ========================================================= */

    protected static function setting(string $key, ?string $fallback)
    {
        try {
            $value = setting($key, $fallback);
        } catch (\Throwable $e) {
            return $fallback;
        }

        return ($value === null || $value === '') ? $fallback : $value;
    }

    protected static function trim(string $text, int $length): string
    {
        $text = preg_replace('/\s+/', ' ', trim($text));

        return Str::limit($text, $length, '…');
    }
}
