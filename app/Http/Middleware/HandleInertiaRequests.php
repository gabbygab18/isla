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
            // Keeps the browser-tab title in step with the server-rendered
            // <title> after Inertia hydrates and on client-side navigation.
            'seo' => function () use ($request) {
                $seo = \App\Support\Seo::build($request);

                return [
                    'title'       => $seo['title'],
                    'description' => $seo['description'],
                    'canonical'   => $seo['canonical'],
                    'image'       => $seo['image'],
                ];
            },
            'settings' => $settings,
            'navItems' => $navItems,
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
            ],
        ]);
    }
}
