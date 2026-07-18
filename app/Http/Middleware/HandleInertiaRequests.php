<?php

namespace App\Http\Middleware;

use App\Models\NavItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template loaded on the first page visit.
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version (busts Inertia's cache on deploy).
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Props shared with every Inertia page.
     */
    public function share(Request $request): array
    {
        $settings = [];
        $navItems = [];

        try {
            $settings = Setting::getAll();
        } catch (\Throwable $e) {
            // DB not migrated yet — pages fall back to their default copy.
        }

        try {
            $navItems = NavItem::active()->get(['label', 'url'])->toArray();
        } catch (\Throwable $e) {
            $navItems = [];
        }

        return array_merge(parent::share($request), [
            'settings' => $settings,
            'navItems' => $navItems,
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
            ],
        ]);
    }
}
