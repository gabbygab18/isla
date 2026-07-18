<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\Benefit;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\ProcessStep;
use App\Models\Service;
use Illuminate\Http\Request;
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
                    'admin-scheduling'           => 11,
                    'client-participant-support' => 12,
                    'bookkeeping-invoicing'      => 14,
                    'compliance-documentation'   => 15,
                    'marketing-social'           => 13,
                    'customer-service'           => 11,
                ][$s->slug] ?? 13),
            ])->values(),
            'calc' => [
                'managementFee' => (float) setting('calc_management_fee', 650),
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

        ContactMessage::create($validated);

        return back()->with('success', "Thanks — your enquiry is in. We'll be in touch within one business day.");
    }
}
