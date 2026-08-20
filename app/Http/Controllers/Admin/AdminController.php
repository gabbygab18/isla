<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audience;
use App\Models\Benefit;
use App\Models\Blog;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\JobApplication;
use App\Models\NavItem;
use App\Models\PricingPlan;
use App\Models\ProcessStep;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminController extends Controller
{
    /* =========================================================
     |  DASHBOARD
     | ========================================================= */
    public function dashboard()
    {
        $stats = [
            'audiences'     => Audience::count(),
            'services'      => Service::count(),
            'pricingPlans'  => PricingPlan::count(),
            'processSteps'  => ProcessStep::count(),
            'benefits'      => Benefit::count(),
            'faqs'          => Faq::count(),
            'testimonials'  => Testimonial::count(),
            'blogs'         => Blog::count(),
            'navItems'      => NavItem::count(),
            'messages'      => ContactMessage::count(),
            'unread'        => ContactMessage::where('is_read', false)->count(),
            'applications'  => JobApplication::count(),
            'newApplications' => JobApplication::where('is_read', false)->count(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();

        return Inertia::render('Admin/Dashboard', compact('stats', 'recentMessages'));
    }

    /* =========================================================
     |  Helpers
     | ========================================================= */
    private function toList(?string $text): array
    {
        if (! $text) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $text))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();
    }

    private function fromList($value): string
    {
        return collect($value ?? [])->implode("\n");
    }

    private function uniqueSlug(string $model, string $source, ?int $ignoreId = null): string
    {
        $slug = Str::slug($source) ?: Str::random(8);
        $base = $slug;
        $i = 2;

        while ($model::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /* =========================================================
     |  AUDIENCES
     | ========================================================= */
    public function audiences()
    {
        return Inertia::render('Admin/Audiences/Index', [
            'audiences' => Audience::orderBy('sort_order')->get(),
        ]);
    }

    public function createAudience()
    {
        return Inertia::render('Admin/Audiences/Form', ['audience' => null]);
    }

    public function storeAudience(Request $request)
    {
        $data = $this->validateAudience($request);
        $data['slug']       = $request->filled('slug') ? Str::slug($request->slug) : $this->uniqueSlug(Audience::class, $data['title']);
        $data['points']     = $this->toList($request->input('points_text'));
        $data['is_active']  = $request->boolean('is_active');
        Audience::create($data);

        return redirect()->route('admin.audiences')->with('success', 'Audience created.');
    }

    public function editAudience(Audience $audience)
    {
        return Inertia::render('Admin/Audiences/Form', compact('audience'));
    }

    public function updateAudience(Request $request, Audience $audience)
    {
        $data = $this->validateAudience($request);
        $data['slug']      = $request->filled('slug') ? $this->uniqueSlug(Audience::class, $request->slug, $audience->id) : $audience->slug;
        $data['points']    = $this->toList($request->input('points_text'));
        $data['is_active'] = $request->boolean('is_active');
        $audience->update($data);

        return redirect()->route('admin.audiences')->with('success', 'Audience updated.');
    }

    public function destroyAudience(Audience $audience)
    {
        $audience->delete();
        return back()->with('success', 'Audience deleted.');
    }

    private function validateAudience(Request $request): array
    {
        return $request->validate([
            'icon'       => 'nullable|string|max:60',
            'title'      => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255',
            'summary'    => 'nullable|string|max:1000',
            'body'       => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);
    }

    /* =========================================================
     |  SERVICES
     | ========================================================= */
    public function services()
    {
        return Inertia::render('Admin/Services/Index', [
            'services' => Service::orderBy('sort_order')->get(),
        ]);
    }

    public function createService()
    {
        return Inertia::render('Admin/Services/Form', ['service' => null]);
    }

    public function storeService(Request $request)
    {
        $data = $this->validateService($request);
        $data['slug']         = $request->filled('slug') ? Str::slug($request->slug) : $this->uniqueSlug(Service::class, $data['title']);
        $data['deliverables'] = $this->toList($request->input('deliverables_text'));
        $data['is_active']    = $request->boolean('is_active');
        Service::create($data);

        return redirect()->route('admin.services')->with('success', 'Service created.');
    }

    public function editService(Service $service)
    {
        return Inertia::render('Admin/Services/Form', compact('service'));
    }

    public function updateService(Request $request, Service $service)
    {
        $data = $this->validateService($request);
        $data['slug']         = $request->filled('slug') ? $this->uniqueSlug(Service::class, $request->slug, $service->id) : $service->slug;
        $data['deliverables'] = $this->toList($request->input('deliverables_text'));
        $data['is_active']    = $request->boolean('is_active');
        $service->update($data);

        return redirect()->route('admin.services')->with('success', 'Service updated.');
    }

    public function destroyService(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Service deleted.');
    }

    private function validateService(Request $request): array
    {
        return $request->validate([
            'icon'       => 'nullable|string|max:60',
            'title'      => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255',
            'summary'    => 'nullable|string|max:1000',
            'body'       => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);
    }

    /* =========================================================
     |  PRICING PLANS
     | ========================================================= */
    public function pricingPlans()
    {
        return Inertia::render('Admin/Pricing/Index', [
            'plans' => PricingPlan::orderBy('sort_order')->get(),
        ]);
    }

    public function createPlan()
    {
        return Inertia::render('Admin/Pricing/Form', ['plan' => null]);
    }

    public function storePlan(Request $request)
    {
        $data = $this->validatePlan($request);
        $data['slug']        = $request->filled('slug') ? Str::slug($request->slug) : $this->uniqueSlug(PricingPlan::class, $data['name']);
        $data['features']    = $this->toList($request->input('features_text'));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');
        PricingPlan::create($data);

        return redirect()->route('admin.pricing-plans')->with('success', 'Plan created.');
    }

    public function editPlan(PricingPlan $plan)
    {
        return Inertia::render('Admin/Pricing/Form', compact('plan'));
    }

    public function updatePlan(Request $request, PricingPlan $plan)
    {
        $data = $this->validatePlan($request);
        $data['slug']        = $request->filled('slug') ? $this->uniqueSlug(PricingPlan::class, $request->slug, $plan->id) : $plan->slug;
        $data['features']    = $this->toList($request->input('features_text'));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');
        $plan->update($data);

        return redirect()->route('admin.pricing-plans')->with('success', 'Plan updated.');
    }

    public function destroyPlan(PricingPlan $plan)
    {
        $plan->delete();
        return back()->with('success', 'Plan deleted.');
    }

    private function validatePlan(Request $request): array
    {
        return $request->validate([
            'name'       => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255',
            'tag'        => 'nullable|string|max:255',
            'detail'     => 'nullable|string|max:255',
            'summary'    => 'nullable|string|max:1000',
            'body'       => 'nullable|string',
            'ribbon'     => 'nullable|string|max:60',
            'sort_order' => 'nullable|integer',
        ]);
    }

    /* =========================================================
     |  PROCESS STEPS
     | ========================================================= */
    public function processSteps()
    {
        return Inertia::render('Admin/ProcessSteps/Index', [
            'steps' => ProcessStep::orderBy('sort_order')->get(),
        ]);
    }

    public function createStep()
    {
        return Inertia::render('Admin/ProcessSteps/Form', ['step' => null]);
    }

    public function storeStep(Request $request)
    {
        $data = $this->validateStep($request);
        $data['is_active'] = $request->boolean('is_active');
        ProcessStep::create($data);

        return redirect()->route('admin.process-steps')->with('success', 'Step created.');
    }

    public function editStep(ProcessStep $step)
    {
        return Inertia::render('Admin/ProcessSteps/Form', compact('step'));
    }

    public function updateStep(Request $request, ProcessStep $step)
    {
        $data = $this->validateStep($request);
        $data['is_active'] = $request->boolean('is_active');
        $step->update($data);

        return redirect()->route('admin.process-steps')->with('success', 'Step updated.');
    }

    public function destroyStep(ProcessStep $step)
    {
        $step->delete();
        return back()->with('success', 'Step deleted.');
    }

    private function validateStep(Request $request): array
    {
        return $request->validate([
            'number'     => 'required|string|max:10',
            'title'      => 'required|string|max:255',
            'summary'    => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer',
        ]);
    }

    /* =========================================================
     |  BENEFITS
     | ========================================================= */
    public function benefits()
    {
        return Inertia::render('Admin/Benefits/Index', [
            'benefits' => Benefit::orderBy('sort_order')->get(),
        ]);
    }

    public function createBenefit()
    {
        return Inertia::render('Admin/Benefits/Form', ['benefit' => null]);
    }

    public function storeBenefit(Request $request)
    {
        $data = $this->validateBenefit($request);
        $data['is_active'] = $request->boolean('is_active');
        Benefit::create($data);

        return redirect()->route('admin.benefits')->with('success', 'Benefit created.');
    }

    public function editBenefit(Benefit $benefit)
    {
        return Inertia::render('Admin/Benefits/Form', compact('benefit'));
    }

    public function updateBenefit(Request $request, Benefit $benefit)
    {
        $data = $this->validateBenefit($request);
        $data['is_active'] = $request->boolean('is_active');
        $benefit->update($data);

        return redirect()->route('admin.benefits')->with('success', 'Benefit updated.');
    }

    public function destroyBenefit(Benefit $benefit)
    {
        $benefit->delete();
        return back()->with('success', 'Benefit deleted.');
    }

    private function validateBenefit(Request $request): array
    {
        return $request->validate([
            'title'      => 'required|string|max:255',
            'summary'    => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer',
        ]);
    }

    /* =========================================================
     |  FAQS
     | ========================================================= */
    public function faqs()
    {
        return Inertia::render('Admin/Faqs/Index', [
            'faqs' => Faq::orderBy('sort_order')->get(),
        ]);
    }

    public function createFaq()
    {
        return Inertia::render('Admin/Faqs/Form', ['faq' => null]);
    }

    public function storeFaq(Request $request)
    {
        $data = $this->validateFaq($request);
        $data['slug']      = $request->filled('slug') ? Str::slug($request->slug) : $this->uniqueSlug(Faq::class, $data['question']);
        $data['is_active'] = $request->boolean('is_active');
        Faq::create($data);

        return redirect()->route('admin.faqs')->with('success', 'FAQ created.');
    }

    public function editFaq(Faq $faq)
    {
        return Inertia::render('Admin/Faqs/Form', compact('faq'));
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        $data = $this->validateFaq($request);
        $data['slug']      = $request->filled('slug') ? $this->uniqueSlug(Faq::class, $request->slug, $faq->id) : $faq->slug;
        $data['is_active'] = $request->boolean('is_active');
        $faq->update($data);

        return redirect()->route('admin.faqs')->with('success', 'FAQ updated.');
    }

    public function destroyFaq(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted.');
    }

    private function validateFaq(Request $request): array
    {
        return $request->validate([
            'question'   => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255',
            'answer'     => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);
    }

    /* =========================================================
     |  TESTIMONIALS
     | ========================================================= */
    public function testimonials()
    {
        return Inertia::render('Admin/Testimonials/Index', [
            'testimonials' => Testimonial::orderBy('sort_order')->get(),
        ]);
    }

    public function createTestimonial()
    {
        return Inertia::render('Admin/Testimonials/Form', ['testimonial' => null]);
    }

    public function storeTestimonial(Request $request)
    {
        $data = $this->validateTestimonial($request);
        $data['is_active'] = $request->boolean('is_active');
        Testimonial::create($data);

        return redirect()->route('admin.testimonials')->with('success', 'Testimonial created.');
    }

    public function editTestimonial(Testimonial $testimonial)
    {
        return Inertia::render('Admin/Testimonials/Form', compact('testimonial'));
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        $data = $this->validateTestimonial($request);
        $data['is_active'] = $request->boolean('is_active');
        $testimonial->update($data);

        return redirect()->route('admin.testimonials')->with('success', 'Testimonial updated.');
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }

    private function validateTestimonial(Request $request): array
    {
        return $request->validate([
            'author'     => 'required|string|max:255',
            'role'       => 'nullable|string|max:255',
            'quote'      => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);
    }

    /* =========================================================
     |  BLOG
     | ========================================================= */
    public function blogs()
    {
        return Inertia::render('Admin/Blogs/Index', [
            'blogs' => Blog::orderByDesc('published_at')->orderBy('sort_order')->get(),
        ]);
    }

    public function createBlog()
    {
        return Inertia::render('Admin/Blogs/Form', ['blog' => null]);
    }

    public function storeBlog(Request $request)
    {
        $data = $this->validateBlog($request);
        $data['slug']      = $request->filled('slug') ? Str::slug($request->slug) : $this->uniqueSlug(Blog::class, $data['title']);
        $data['is_active'] = $request->boolean('is_active');
        Blog::create($data);

        return redirect()->route('admin.blogs')->with('success', 'Blog post created.');
    }

    public function editBlog(Blog $blog)
    {
        return Inertia::render('Admin/Blogs/Form', compact('blog'));
    }

    public function updateBlog(Request $request, Blog $blog)
    {
        $data = $this->validateBlog($request);
        $data['slug']      = $request->filled('slug') ? $this->uniqueSlug(Blog::class, $request->slug, $blog->id) : $blog->slug;
        $data['is_active'] = $request->boolean('is_active');
        $blog->update($data);

        return redirect()->route('admin.blogs')->with('success', 'Blog post updated.');
    }

    public function destroyBlog(Blog $blog)
    {
        $blog->delete();
        return back()->with('success', 'Blog post deleted.');
    }

    private function validateBlog(Request $request): array
    {
        return $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255',
            'cover_image'  => 'nullable|string|max:2048',
            'author'       => 'nullable|string|max:255',
            'excerpt'      => 'nullable|string|max:1000',
            'body'         => 'nullable|string',
            'published_at' => 'nullable|date',
            'sort_order'   => 'nullable|integer',
        ]);
    }

    /* =========================================================
     |  NAV ITEMS (dynamic navigation)
     | ========================================================= */
    public function navItems()
    {
        return Inertia::render('Admin/NavItems/Index', [
            'navItems' => NavItem::orderBy('sort_order')->get(),
        ]);
    }

    public function createNavItem()
    {
        return Inertia::render('Admin/NavItems/Form', ['navItem' => null]);
    }

    public function storeNavItem(Request $request)
    {
        $data = $this->validateNavItem($request);
        $data['is_active'] = $request->boolean('is_active');
        NavItem::create($data);

        return redirect()->route('admin.nav-items')->with('success', 'Menu item created.');
    }

    public function editNavItem(NavItem $navItem)
    {
        return Inertia::render('Admin/NavItems/Form', compact('navItem'));
    }

    public function updateNavItem(Request $request, NavItem $navItem)
    {
        $data = $this->validateNavItem($request);
        $data['is_active'] = $request->boolean('is_active');
        $navItem->update($data);

        return redirect()->route('admin.nav-items')->with('success', 'Menu item updated.');
    }

    public function destroyNavItem(NavItem $navItem)
    {
        $navItem->delete();
        return back()->with('success', 'Menu item deleted.');
    }

    private function validateNavItem(Request $request): array
    {
        return $request->validate([
            'label'      => 'required|string|max:60',
            'url'        => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
    }

    /* =========================================================
     |  SETTINGS (site-wide dynamic content)
     | ========================================================= */
    public function settings()
    {
        return Inertia::render('Admin/Settings/Index', [
            'groups'   => $this->settingsGroups(),
            'settings' => Setting::getAll(),
        ]);
    }

    /**
     * key => [label, type]  (type: text | textarea), grouped for display.
     * Ported verbatim from the old admin.settings Blade view.
     */
    private function settingsGroups(): array
    {
        return [
            'Calendly — booking embeds' => [
                'calendly_discovery_url' => ['Discovery call scheduling link (leave blank to use the form instead)', 'text'],
                'calendly_interview_url' => ['Interview scheduling link, shown after a client books from a talent link', 'text'],
            ],

            'SEO — search and social' => [
                'og_image'                  => ['Share image URL (1200x630)', 'text'],
                'social_linkedin'           => ['LinkedIn profile URL', 'text'],
                'social_facebook'           => ['Facebook page URL', 'text'],
                'social_instagram'          => ['Instagram profile URL', 'text'],
                'seo_home_title'            => ['Home — search title', 'text'],
                'seo_home_description'      => ['Home — search description', 'textarea'],
                'seo_about_title'           => ['About — search title', 'text'],
                'seo_about_description'     => ['About — search description', 'textarea'],
                'seo_services_title'        => ['Services — search title', 'text'],
                'seo_services_description'  => ['Services — search description', 'textarea'],
                'seo_audiences_title'       => ['Industries — search title', 'text'],
                'seo_audiences_description' => ['Industries — search description', 'textarea'],
                'seo_pricing_title'         => ['Pricing — search title', 'text'],
                'seo_pricing_description'   => ['Pricing — search description', 'textarea'],
                'seo_faq_title'             => ['FAQ — search title', 'text'],
                'seo_faq_description'       => ['FAQ — search description', 'textarea'],
                'seo_contact_title'         => ['Contact — search title', 'text'],
                'seo_contact_description'   => ['Contact — search description', 'textarea'],
            ],
            'Brand' => [
                'brand_word'     => ['Brand word', 'text'],
                'footer_tagline' => ['Footer tagline', 'text'],
                'home_title'     => ['Homepage browser/search title', 'text'],
                'marquee_items'  => ['Marquee phrases (one per line)', 'textarea'],
            ],
            'Hero' => [
                'hero_eyebrow'      => ['Eyebrow', 'text'],
                'hero_title'        => ['Title (line breaks allowed)', 'textarea'],
                'hero_subtitle'     => ['Subtitle', 'textarea'],
                'hero_image'        => ['Image URL', 'text'],
                'hero_badge_strong' => ['Badge — bold text', 'text'],
                'hero_badge_text'   => ['Badge — small text', 'text'],
                'hero_cta_label'    => ['Primary CTA label', 'text'],
            ],
            'Who we work with' => [
                'audiences_eyebrow' => ['Eyebrow', 'text'],
                'audiences_heading' => ['Heading', 'text'],
                'audiences_intro'   => ['Intro', 'textarea'],
            ],
            'Services' => [
                'services_eyebrow' => ['Eyebrow', 'text'],
                'services_heading' => ['Heading', 'text'],
            ],
            'How it works' => [
                'process_eyebrow' => ['Eyebrow', 'text'],
                'process_heading' => ['Heading', 'text'],
                'process_intro'   => ['Intro', 'textarea'],
            ],
            'Why Isla' => [
                'why_eyebrow' => ['Eyebrow', 'text'],
                'why_heading' => ['Heading', 'text'],
                'why_intro'   => ['Intro', 'textarea'],
                'why_image'   => ['Image URL', 'text'],
            ],
            'Pricing' => [
                'pricing_eyebrow' => ['Eyebrow', 'text'],
                'pricing_heading' => ['Heading', 'text'],
                'pricing_intro'   => ['Intro', 'textarea'],
            ],
            'FAQ' => [
                'faq_eyebrow' => ['Eyebrow', 'text'],
                'faq_heading' => ['Heading', 'text'],
            ],
            'Contact' => [
                'contact_eyebrow'  => ['Eyebrow', 'text'],
                'contact_heading'  => ['Heading', 'text'],
                'contact_intro'    => ['Intro', 'textarea'],
                'contact_email'    => ['Email', 'text'],
                'contact_phone'    => ['Phone', 'text'],
                'contact_location' => ['Location line', 'text'],
            ],
            'Trust bar (shared strip)' => [
                'trust_location'   => ['Item 1 — location', 'text'],
                'trust_response'   => ['Item 2 — response time', 'text'],
                'trust_industries' => ['Item 3 — industries', 'text'],
                'trust_managed'    => ['Item 4 — managed line', 'text'],
            ],
            'About page' => [
                'about_eyebrow'            => ['Hero eyebrow', 'text'],
                'about_heading'            => ['Hero heading', 'text'],
                'about_intro'              => ['Hero intro', 'textarea'],
                'about_image'              => ['Story image URL', 'text'],
                'about_story_eyebrow'      => ['Story eyebrow', 'text'],
                'about_story_heading'      => ['Story heading', 'text'],
                'about_story_body_1'       => ['Story paragraph 1', 'textarea'],
                'about_story_body_2'       => ['Story paragraph 2', 'textarea'],
                'about_values_eyebrow'     => ['Values eyebrow', 'text'],
                'about_values_heading'     => ['Values heading', 'text'],
                'about_values_intro'       => ['Values intro', 'textarea'],
                'about_industries_heading' => ['Industries section heading', 'text'],
                'ph_eyebrow'               => ['About the Philippines — eyebrow', 'text'],
                'ph_heading'               => ['About the Philippines — heading', 'text'],
                'ph_intro'                 => ['About the Philippines — intro', 'textarea'],
            ],
            'Team We Build page' => [
                'team_eyebrow'              => ['Hero eyebrow', 'text'],
                'team_heading'              => ['Hero heading', 'text'],
                'team_intro'                => ['Hero intro', 'textarea'],
                'team_construction_title'   => ['Construction card — title', 'text'],
                'team_construction_summary' => ['Construction card — summary', 'textarea'],
                'team_process_eyebrow'      => ['Process eyebrow', 'text'],
                'team_process_heading'      => ['Process heading', 'text'],
                'team_process_intro'        => ['Process intro', 'textarea'],
            ],
            'Book a Discovery Call page' => [
                'book_window_days'     => ['Calendar — days of availability shown (e.g. 14)', 'text'],
                'book_eyebrow'         => ['Hero eyebrow', 'text'],
                'book_heading'         => ['Hero heading', 'text'],
                'book_intro'           => ['Hero intro', 'textarea'],
                'book_form_eyebrow'    => ['Form eyebrow', 'text'],
                'book_form_heading'    => ['Form heading', 'text'],
                'book_form_intro'      => ['Form intro', 'textarea'],
                'book_next_eyebrow'    => ['What happens next — eyebrow', 'text'],
                'book_next_heading'    => ['What happens next — heading', 'text'],
                'book_lighter_eyebrow' => ['Lighter options — eyebrow', 'text'],
                'book_lighter_heading' => ['Lighter options — heading', 'text'],
                'book_lighter_intro'   => ['Lighter options — intro', 'textarea'],
                'book_faq_eyebrow'     => ['Call FAQ eyebrow', 'text'],
                'book_faq_heading'     => ['Call FAQ heading', 'text'],
            ],
            'Cost estimator page' => [
                'calc_eyebrow'                => ['Hero eyebrow', 'text'],
                'calc_heading'                => ['Hero heading', 'text'],
                'calc_intro'                  => ['Hero intro', 'textarea'],
                'calc_disclaimer'             => ['Disclaimer text', 'textarea'],
                'calc_rate_general_low'       => ['General rate — low (A$/hr)', 'text'],
                'calc_rate_general_high'      => ['General rate — high (A$/hr)', 'text'],
                'calc_rate_ndis_low'          => ['NDIS rate — low (A$/hr)', 'text'],
                'calc_rate_ndis_high'         => ['NDIS rate — high (A$/hr)', 'text'],
                'calc_rate_healthcare_low'    => ['Healthcare rate — low (A$/hr)', 'text'],
                'calc_rate_healthcare_high'   => ['Healthcare rate — high (A$/hr)', 'text'],
                'calc_rate_construction_low'  => ['Construction rate — low (A$/hr)', 'text'],
                'calc_rate_construction_high' => ['Construction rate — high (A$/hr)', 'text'],
                'calc_local_rate'             => ['Local hire equivalent (A$/hr)', 'text'],
            ],
        ];
    }

    public function updateSettings(Request $request)
    {
        $keys = $request->input('settings', []);

        foreach ($keys as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings saved.');
    }

    /* =========================================================
     |  CONTACT MESSAGES
     | ========================================================= */
    public function messages()
    {
        return Inertia::render('Admin/Messages/Index', [
            'messages' => ContactMessage::latest()->paginate(15),
        ]);
    }

    public function showMessage(ContactMessage $message)
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return Inertia::render('Admin/Messages/Show', compact('message'));
    }

    public function destroyMessage(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages')->with('success', 'Message deleted.');
    }

    /* =========================================================
     |  CAREER APPLICATIONS
     | ========================================================= */
    public function applications()
    {
        return Inertia::render('Admin/Applications/Index', [
            'applications' => JobApplication::latest()->paginate(15),
        ]);
    }

    public function showApplication(JobApplication $application)
    {
        if (! $application->is_read) {
            $application->update(['is_read' => true]);
        }

        return Inertia::render('Admin/Applications/Show', compact('application'));
    }

    public function destroyApplication(JobApplication $application)
    {
        $application->delete();
        return redirect()->route('admin.applications')->with('success', 'Application deleted.');
    }
}
