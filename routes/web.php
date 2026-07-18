<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\IslaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC — Isla managed virtual staffing
|--------------------------------------------------------------------------
*/

Route::get('/', [IslaController::class, 'index'])->name('isla.index');

// Enquiry form
Route::get('/contact', [IslaController::class, 'contactPage'])->name('isla.contact.page');
Route::post('/contact', [IslaController::class, 'contact'])->name('isla.contact');

// ---- Section pages (each nav section is its own page) ----
Route::get('/who-we-work-with', [IslaController::class, 'audiencesIndex'])->name('isla.audiences.index');
Route::get('/services', [IslaController::class, 'servicesIndex'])->name('isla.services.index');
Route::get('/how-it-works', [IslaController::class, 'howItWorks'])->name('isla.how-it-works');
Route::get('/why-isla', [IslaController::class, 'whyIsla'])->name('isla.why-isla');
Route::get('/pricing', [IslaController::class, 'pricingIndex'])->name('isla.pricing.index');
Route::get('/faq', [IslaController::class, 'faqIndex'])->name('isla.faq.index');
Route::get('/about', [IslaController::class, 'about'])->name('isla.about');
Route::get('/team-we-build', [IslaController::class, 'teamWeBuild'])->name('isla.team.index');
Route::get('/book-a-call', [IslaController::class, 'bookCall'])->name('isla.book-call');
Route::get('/cost-estimator', [IslaController::class, 'costEstimator'])->name('isla.cost-estimator');

// ---- Item detail pages ----
Route::get('/who-we-work-with/{audience:slug}', [IslaController::class, 'showAudience'])->name('isla.audiences.show');
Route::get('/services/{service:slug}', [IslaController::class, 'showService'])->name('isla.services.show');
Route::get('/pricing/{plan:slug}', [IslaController::class, 'showPlan'])->name('isla.pricing.show');
Route::get('/faq/{faq:slug}', [IslaController::class, 'showFaq'])->name('isla.faqs.show');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Audiences
        Route::get('/audiences', [AdminController::class, 'audiences'])->name('audiences');
        Route::get('/audiences/create', [AdminController::class, 'createAudience'])->name('audiences.create');
        Route::post('/audiences', [AdminController::class, 'storeAudience'])->name('audiences.store');
        Route::get('/audiences/{audience}/edit', [AdminController::class, 'editAudience'])->name('audiences.edit');
        Route::put('/audiences/{audience}', [AdminController::class, 'updateAudience'])->name('audiences.update');
        Route::delete('/audiences/{audience}', [AdminController::class, 'destroyAudience'])->name('audiences.destroy');

        // Services
        Route::get('/services', [AdminController::class, 'services'])->name('services');
        Route::get('/services/create', [AdminController::class, 'createService'])->name('services.create');
        Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
        Route::get('/services/{service}/edit', [AdminController::class, 'editService'])->name('services.edit');
        Route::put('/services/{service}', [AdminController::class, 'updateService'])->name('services.update');
        Route::delete('/services/{service}', [AdminController::class, 'destroyService'])->name('services.destroy');

        // Pricing plans
        Route::get('/pricing-plans', [AdminController::class, 'pricingPlans'])->name('pricing-plans');
        Route::get('/pricing-plans/create', [AdminController::class, 'createPlan'])->name('pricing-plans.create');
        Route::post('/pricing-plans', [AdminController::class, 'storePlan'])->name('pricing-plans.store');
        Route::get('/pricing-plans/{plan}/edit', [AdminController::class, 'editPlan'])->name('pricing-plans.edit');
        Route::put('/pricing-plans/{plan}', [AdminController::class, 'updatePlan'])->name('pricing-plans.update');
        Route::delete('/pricing-plans/{plan}', [AdminController::class, 'destroyPlan'])->name('pricing-plans.destroy');

        // Process steps
        Route::get('/process-steps', [AdminController::class, 'processSteps'])->name('process-steps');
        Route::get('/process-steps/create', [AdminController::class, 'createStep'])->name('process-steps.create');
        Route::post('/process-steps', [AdminController::class, 'storeStep'])->name('process-steps.store');
        Route::get('/process-steps/{step}/edit', [AdminController::class, 'editStep'])->name('process-steps.edit');
        Route::put('/process-steps/{step}', [AdminController::class, 'updateStep'])->name('process-steps.update');
        Route::delete('/process-steps/{step}', [AdminController::class, 'destroyStep'])->name('process-steps.destroy');

        // Benefits
        Route::get('/benefits', [AdminController::class, 'benefits'])->name('benefits');
        Route::get('/benefits/create', [AdminController::class, 'createBenefit'])->name('benefits.create');
        Route::post('/benefits', [AdminController::class, 'storeBenefit'])->name('benefits.store');
        Route::get('/benefits/{benefit}/edit', [AdminController::class, 'editBenefit'])->name('benefits.edit');
        Route::put('/benefits/{benefit}', [AdminController::class, 'updateBenefit'])->name('benefits.update');
        Route::delete('/benefits/{benefit}', [AdminController::class, 'destroyBenefit'])->name('benefits.destroy');

        // FAQs
        Route::get('/faqs', [AdminController::class, 'faqs'])->name('faqs');
        Route::get('/faqs/create', [AdminController::class, 'createFaq'])->name('faqs.create');
        Route::post('/faqs', [AdminController::class, 'storeFaq'])->name('faqs.store');
        Route::get('/faqs/{faq}/edit', [AdminController::class, 'editFaq'])->name('faqs.edit');
        Route::put('/faqs/{faq}', [AdminController::class, 'updateFaq'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [AdminController::class, 'destroyFaq'])->name('faqs.destroy');

        // Nav items (dynamic navigation)
        Route::get('/nav-items', [AdminController::class, 'navItems'])->name('nav-items');
        Route::get('/nav-items/create', [AdminController::class, 'createNavItem'])->name('nav-items.create');
        Route::post('/nav-items', [AdminController::class, 'storeNavItem'])->name('nav-items.store');
        Route::get('/nav-items/{navItem}/edit', [AdminController::class, 'editNavItem'])->name('nav-items.edit');
        Route::put('/nav-items/{navItem}', [AdminController::class, 'updateNavItem'])->name('nav-items.update');
        Route::delete('/nav-items/{navItem}', [AdminController::class, 'destroyNavItem'])->name('nav-items.destroy');

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

        // Messages
        Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
        Route::get('/messages/{message}', [AdminController::class, 'showMessage'])->name('messages.show');
        Route::delete('/messages/{message}', [AdminController::class, 'destroyMessage'])->name('messages.destroy');
    });
});
