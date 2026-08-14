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

        return view('admin.dashboard', compact('stats', 'recentMessages'));
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
        $audiences = Audience::orderBy('sort_order')->get();
        return view('admin.audiences.index', compact('audiences'));
    }

    public function createAudience()
    {
        return view('admin.audiences.create');
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
        return view('admin.audiences.edit', compact('audience'));
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
        $services = Service::orderBy('sort_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function createService()
    {
        return view('admin.services.create');
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
        return view('admin.services.edit', compact('service'));
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
        $plans = PricingPlan::orderBy('sort_order')->get();
        return view('admin.pricing.index', compact('plans'));
    }

    public function createPlan()
    {
        return view('admin.pricing.create');
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
        return view('admin.pricing.edit', compact('plan'));
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
        $steps = ProcessStep::orderBy('sort_order')->get();
        return view('admin.process.index', compact('steps'));
    }

    public function createStep()
    {
        return view('admin.process.create');
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
        return view('admin.process.edit', compact('step'));
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
        $benefits = Benefit::orderBy('sort_order')->get();
        return view('admin.benefits.index', compact('benefits'));
    }

    public function createBenefit()
    {
        return view('admin.benefits.create');
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
        return view('admin.benefits.edit', compact('benefit'));
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
        $faqs = Faq::orderBy('sort_order')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function createFaq()
    {
        return view('admin.faqs.create');
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
        return view('admin.faqs.edit', compact('faq'));
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
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function createTestimonial()
    {
        return view('admin.testimonials.create');
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
        return view('admin.testimonials.edit', compact('testimonial'));
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
        $blogs = Blog::orderByDesc('published_at')->orderBy('sort_order')->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function createBlog()
    {
        return view('admin.blogs.create');
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
        return view('admin.blogs.edit', compact('blog'));
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
        $navItems = NavItem::orderBy('sort_order')->get();
        return view('admin.nav.index', compact('navItems'));
    }

    public function createNavItem()
    {
        return view('admin.nav.create');
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
        return view('admin.nav.edit', compact('navItem'));
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
        $settings = Setting::getAll();
        return view('admin.settings', compact('settings'));
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
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function showMessage(ContactMessage $message)
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
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
        $applications = JobApplication::latest()->paginate(15);
        return view('admin.applications.index', compact('applications'));
    }

    public function showApplication(JobApplication $application)
    {
        if (! $application->is_read) {
            $application->update(['is_read' => true]);
        }

        return view('admin.applications.show', compact('application'));
    }

    public function destroyApplication(JobApplication $application)
    {
        $application->delete();
        return redirect()->route('admin.applications')->with('success', 'Application deleted.');
    }
}
