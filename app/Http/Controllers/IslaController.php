<?php

namespace App\Http\Controllers;

use App\Mail\DiscoveryCallEnquiry;
use App\Models\Audience;
use App\Models\Benefit;
use App\Models\Blog;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\JobApplication;
use App\Models\PricingPlan;
use App\Models\ProcessStep;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class IslaController extends Controller
{
    /* =========================================================
     |  LANDING PAGE (overview of every section)
     | ========================================================= */
    public function index()
    {
        return Inertia::render('Home', [
            'audiences'    => Audience::active()->get(),
            'services'     => Service::active()->get(),
            'pricingPlans' => PricingPlan::active()->get(),
            'processSteps' => ProcessStep::active()->get(),
            'benefits'     => Benefit::active()->get(),
            'faqs'         => Faq::active()->get(),
        ]);
    }

    /* =========================================================
     |  SECTION PAGES — each nav section is its own page
     | ========================================================= */
    public function audiencesIndex()
    {
        return Inertia::render('Audiences/Index', ['audiences' => Audience::active()->get()]);
    }

    public function servicesIndex()
    {
        return Inertia::render('Services/Index', ['services' => Service::active()->get()]);
    }

    public function howItWorks()
    {
        return Inertia::render('HowItWorks', ['processSteps' => ProcessStep::active()->get()]);
    }

    public function whyIsla()
    {
        return Inertia::render('WhyIsla', ['benefits' => Benefit::active()->get()]);
    }

    public function pricingIndex()
    {
        return Inertia::render('Pricing/Index', ['pricingPlans' => PricingPlan::active()->get()]);
    }

    public function faqIndex()
    {
        return Inertia::render('Faqs/Index', ['faqs' => Faq::active()->get()]);
    }

    public function testimonials()
    {
        return Inertia::render('Testimonials', ['testimonials' => Testimonial::active()->get()]);
    }

    public function blogIndex()
    {
        return Inertia::render('Blog/Index', ['blogs' => Blog::active()->get()]);
    }

    public function contactPage()
    {
        return Inertia::render('Contact');
    }

    public function about()
    {
        return Inertia::render('About', [
            'benefits'  => Benefit::active()->get(),
            'audiences' => Audience::active()->get(),
        ]);
    }

    public function teamWeBuild()
    {
        return Inertia::render('Team', [
            'services'     => Service::active()->get(),
            'processSteps' => ProcessStep::active()->get(),
        ]);
    }

    public function bookCall()
    {
        return Inertia::render('BookCall');
    }

    public function costEstimator()
    {
        return Inertia::render('CostEstimator', [
            'pricingPlans' => PricingPlan::active()->get(),
            'services'     => Service::active()->get()->map(fn ($s) => [
                'title' => $s->title,
                'slug'  => $s->slug,
                'roles' => $s->roles ?? [],
                'rate'  => (float) setting('calc_rate_' . str_replace('-', '_', $s->slug), [
                    'administration-executive-support'        => 11,
                    'client-intake-support'                   => 12,
                    'finance-bookkeeping-payroll'             => 14,
                    'hr-workforce-administration'             => 13,
                    'compliance-quality-documentation'        => 15,
                    'customer-service-virtual-reception'      => 11,
                    'construction-administration-estimating'  => 14,
                    'engineering-cad-technical-support'       => 16,
                    'real-estate-property-support'            => 12,
                    'sales-business-development'              => 12,
                    'marketing-creative-support'              => 13,
                    'ecommerce-retail-operations'             => 11,
                    'technology-it-support'                   => 16,
                    'operations-project-coordination'         => 13,
                ][$s->slug] ?? 13),
            ])->values(),
            'calc' => [
                'localRate'     => (float) setting('calc_local_rate', 42),
            ],
        ]);
    }

    /* =========================================================
     |  ITEM DETAIL PAGES
     | ========================================================= */
    public function showAudience(Audience $audience)
    {
        abort_unless($audience->is_active, 404);
        $related = Audience::active()->where('id', '!=', $audience->id)->get();

        return Inertia::render('Audiences/Show', compact('audience', 'related'));
    }

    public function showService(Service $service)
    {
        abort_unless($service->is_active, 404);
        $related = Service::active()->where('id', '!=', $service->id)->get();

        return Inertia::render('Services/Show', compact('service', 'related'));
    }

    public function showPlan(PricingPlan $plan)
    {
        abort_unless($plan->is_active, 404);
        $others = PricingPlan::active()->where('id', '!=', $plan->id)->get();

        return Inertia::render('Pricing/Show', compact('plan', 'others'));
    }

    public function showFaq(Faq $faq)
    {
        abort_unless($faq->is_active, 404);
        $others = Faq::active()->where('id', '!=', $faq->id)->get();

        return Inertia::render('Faqs/Show', compact('faq', 'others'));
    }

    public function showBlog(Blog $blog)
    {
        abort_unless($blog->is_active, 404);
        $related = Blog::active()->where('id', '!=', $blog->id)->take(3)->get();

        return Inertia::render('Blog/Show', compact('blog', 'related'));
    }

    /* =========================================================
     |  CAREERS
     | ========================================================= */
    public function careers()
    {
        return Inertia::render('Careers', [
            'roles' => $this->openRoles(),
        ]);
    }

    public function storeApplication(Request $request)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:50',
            'role'          => 'required|string|max:255',
            'availability'  => 'nullable|string|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'resume'        => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'message'       => 'required|string|min:20|max:5000',
        ], [
            'full_name.required' => 'Please tell us your full name.',
            'email.required'     => 'We need an email to reply to you.',
            'email.email'        => 'That email address doesn\'t look right.',
            'phone.required'     => 'A contact number is required.',
            'role.required'      => 'Please choose the role you\'re applying for.',
            'portfolio_url.url'  => 'Enter a full link starting with https://',
            'resume.mimes'       => 'Upload your resume as a PDF, DOC or DOCX file.',
            'resume.max'         => 'Your resume file needs to be under 5MB.',
            'message.required'   => 'Tell us a little about yourself.',
            'message.min'        => 'Please write at least a sentence or two (20+ characters).',
        ]);

        if ($request->hasFile('resume')) {
            $validated['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }
        unset($validated['resume']);

        JobApplication::create($validated);

        return back()->with('success', "Thanks — your application is in. If it's a fit, we'll be in touch within a few business days.");
    }

    /**
     * Roles currently open. Editable copy could live in settings later;
     * for now this is the source of truth for the careers page + form.
     */
    private function openRoles(): array
    {
        return [
            [
                'title'    => 'General Virtual Assistant',
                'type'     => 'Full-time · Remote (PH)',
                'blurb'    => 'Own inboxes, calendars, data entry and day-to-day admin for an Australian business.',
                'skills'   => ['Strong written English', 'Google Workspace / MS Office', 'Reliable home internet'],
            ],
            [
                'title'    => 'NDIS & Aged Care Support VA',
                'type'     => 'Full-time · Remote (PH)',
                'blurb'    => 'Support participant enquiries, rostering and compliance admin for care providers.',
                'skills'   => ['Care or health admin background', 'Empathetic phone/email manner', 'Detail-oriented'],
            ],
            [
                'title'    => 'Bookkeeping & Accounts VA',
                'type'     => 'Full-time · Remote (PH)',
                'blurb'    => 'Handle invoicing, reconciliations and payroll support in Xero or MYOB.',
                'skills'   => ['Xero / MYOB / QuickBooks', 'Accounting fundamentals', 'Accuracy under deadlines'],
            ],
            [
                'title'    => 'Customer Service VA',
                'type'     => 'Full-time · Remote (PH)',
                'blurb'    => 'Be the friendly first response across email, chat and phone for growing brands.',
                'skills'   => ['Clear, warm communication', 'CRM / helpdesk tools', 'Problem-solving mindset'],
            ],
            [
                'title'    => 'Real Estate & Property VA',
                'type'     => 'Full-time · Remote (PH)',
                'blurb'    => 'Coordinate listings, applications and landlord/tenant admin for agencies.',
                'skills'   => ['Property admin experience', 'CRM / portal familiarity', 'Organised multitasker'],
            ],
            [
                'title'    => "Don't see your role?",
                'type'     => 'Open application',
                'blurb'    => "We're always meeting great people. Send a general application and tell us your strengths.",
                'skills'   => ['Tell us what you do best'],
            ],
        ];
    }

    /* =========================================================
     |  CONTACT / ENQUIRY FORM
     | ========================================================= */
    public function contact(Request $request)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'nullable|string|max:50',
            'sector'        => 'nullable|string|max:255',
            'message'       => 'required|string|max:5000',
        ]);

        $message = ContactMessage::create($validated);

        try {
            $to = array_values(array_filter((array) config('mail.enquiry.to'), fn($a)=>filter_var($a,FILTER_VALIDATE_EMAIL)));
            $cc = array_values(array_filter((array) config('mail.enquiry.cc'), fn($a)=>filter_var($a,FILTER_VALIDATE_EMAIL)));
            if (empty($to)) { $to = $cc; $cc = []; }
            $cc = array_values(array_diff($cc, $to));
            if (!empty($to)) { $mailer = Mail::to($to); if (!empty($cc)) $mailer->cc($cc); $mailer->send(new DiscoveryCallEnquiry($message)); }
        } catch (\Throwable $e) { report($e); }


        return back()->with('success', "Thanks — your enquiry is in. We'll be in touch within one business day.");
    }
}
