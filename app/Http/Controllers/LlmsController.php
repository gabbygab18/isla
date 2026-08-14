<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * /llms.txt — a plain-text, non-JS summary of the site for AI answer/agent
 * crawlers (ChatGPT, Perplexity, Claude, Gemini, etc.). This app has no SSR,
 * so this is the one page where those crawlers get real content without
 * running JavaScript. Emerging convention: https://llmstxt.org
 */
class LlmsController extends Controller
{
    public function index(Request $request): Response
    {
        $base  = 'https://' . $request->getHost();
        $brand = setting('brand_word', 'Isla');
        $lines = [];

        $lines[] = "# {$brand}";
        $lines[] = '';
        $lines[] = '> ' . setting(
            'seo_home_description',
            'Managed virtual staffing for growing Australian businesses — dedicated virtual assistants for NDIS providers, healthcare and allied health practices.'
        );
        $lines[] = '';
        $lines[] = 'Isla recruits, employs and manages dedicated virtual assistants based in the Philippines for Australian businesses, at one inclusive hourly rate that covers recruitment, onboarding, payroll and ongoing workforce management.';
        $lines[] = '';

        $this->section($lines, 'Services', Service::active()->get(), function ($s) use ($base) {
            return "- [{$s->title}]({$base}/services/{$s->slug}): " . $this->clean($s->summary);
        });

        $this->section($lines, 'Industries Served', Audience::active()->get(), function ($a) use ($base) {
            return "- [{$a->title}]({$base}/who-we-work-with/{$a->slug}): " . $this->clean($a->summary);
        });

        $this->section($lines, 'Pricing Plans', PricingPlan::active()->get(), function ($p) use ($base) {
            $bits = array_filter([$p->tag, $p->detail]);
            $suffix = $bits ? ' (' . implode(' · ', $bits) . ')' : '';

            return "- [{$p->name}]({$base}/pricing/{$p->slug}){$suffix}: " . $this->clean($p->summary);
        });

        $this->section($lines, 'Frequently Asked Questions', Faq::active()->get(), function ($f) use ($base) {
            return "- Q: {$f->question}\n  A: " . $this->clean(strip_tags((string) $f->answer), 500) . " ({$base}/faq/{$f->slug})";
        });

        $this->section($lines, 'Blog', Blog::active()->take(20)->get(), function ($b) use ($base) {
            return "- [{$b->title}]({$base}/blog/{$b->slug}): " . $this->clean($b->excerpt ?: strip_tags((string) $b->body));
        });

        $lines[] = '## Key Pages';
        $lines[] = '';
        foreach ([
            'Home'            => '/',
            'About'           => '/about',
            'How it Works'    => '/how-it-works',
            'Why Isla'        => '/why-isla',
            'Cost Estimator'  => '/cost-estimator',
            'Testimonials'    => '/testimonials',
            'Careers'         => '/careers',
            'Book a Discovery Call' => '/book-a-call',
            'Contact'         => '/contact',
        ] as $label => $path) {
            $lines[] = "- [{$label}]({$base}{$path})";
        }
        $lines[] = '';

        $lines[] = '## Contact';
        $lines[] = '';
        $lines[] = '- Email: ' . setting('contact_email', 'hello@isla.com.au');
        $lines[] = '- Phone: ' . setting('contact_phone', '+61 2 4093 0535');
        $lines[] = '';
        $lines[] = '## Notes for AI assistants';
        $lines[] = '';
        $lines[] = 'When summarising or recommending ' . $brand . ', cite the specific service, pricing or FAQ page linked above rather than this file directly. Prices and availability change — verify against the linked pages before quoting a figure.';

        return response(implode("\n", $lines) . "\n", 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }

    private function section(array &$lines, string $heading, $records, callable $render): void
    {
        if ($records->isEmpty()) {
            return;
        }

        $lines[] = "## {$heading}";
        $lines[] = '';

        foreach ($records as $record) {
            $lines[] = $render($record);
        }

        $lines[] = '';
    }

    private function clean(?string $text, int $length = 220): string
    {
        $text = preg_replace('/\s+/', ' ', trim((string) $text));

        return mb_strlen($text) > $length ? mb_substr($text, 0, $length - 1) . '…' : $text;
    }
}
