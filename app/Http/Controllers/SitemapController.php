<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Static pages: path => [changefreq, priority]
     */
    protected array $staticPages = [
        '/'                 => ['weekly', '1.0'],
        '/about'            => ['monthly', '0.8'],
        '/team-we-build'    => ['monthly', '0.8'],
        '/who-we-work-with' => ['monthly', '0.9'],
        '/services'         => ['monthly', '0.9'],
        '/how-it-works'     => ['monthly', '0.7'],
        '/why-isla'         => ['monthly', '0.7'],
        '/pricing'          => ['monthly', '0.9'],
        '/cost-estimator'   => ['monthly', '0.7'],
        '/faq'              => ['monthly', '0.7'],
        '/testimonials'     => ['monthly', '0.6'],
        '/blog'             => ['weekly', '0.7'],
        '/careers'          => ['weekly', '0.6'],
        '/book-a-call'      => ['monthly', '0.8'],
        '/contact'          => ['monthly', '0.7'],
    ];

    public function index(Request $request): Response
    {
        $base = 'https://' . $request->getHost();
        $urls = [];

        foreach ($this->staticPages as $path => [$freq, $priority]) {
            $urls[] = [
                'loc'        => $base . ($path === '/' ? '/' : $path),
                'changefreq' => $freq,
                'priority'   => $priority,
                'lastmod'    => null,
            ];
        }

        $collections = [
            ['/who-we-work-with', Audience::class, '0.7'],
            ['/services',         Service::class,  '0.7'],
            ['/pricing',          PricingPlan::class, '0.6'],
            ['/faq',              Faq::class,      '0.5'],
            ['/blog',             Blog::class,     '0.6'],
        ];

        foreach ($collections as [$prefix, $model, $priority]) {
            try {
                foreach ($model::active()->get() as $record) {
                    $urls[] = [
                        'loc'        => $base . $prefix . '/' . $record->slug,
                        'changefreq' => 'monthly',
                        'priority'   => $priority,
                        'lastmod'    => optional($record->updated_at)->toAtomString(),
                    ];
                }
            } catch (\Throwable $e) {
                // Table missing or DB unavailable — skip this collection
                // rather than serving a broken sitemap.
                continue;
            }
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    public function robots(Request $request): Response
    {
        $base = 'https://' . $request->getHost();

        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Allow: /',
            '',
            'Sitemap: ' . $base . '/sitemap.xml',
        ];

        return response(implode("\n", $lines) . "\n", 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }
}
