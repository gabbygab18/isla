<?php

namespace App\Providers;

use App\Models\NavItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Make the (dynamic) primary navigation available to the public layout
        // on every page, without each controller having to pass it through.
        View::composer('layouts.app', function ($view) {
            $navItems = collect();

            try {
                $navItems = NavItem::active()->get();
            } catch (\Throwable $e) {
                // table not migrated yet — fall back to an empty menu
            }

            $view->with('navItems', $navItems);
        });
    }
}
