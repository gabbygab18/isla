<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Fetch a site setting by key, with a fallback default.
     * Settings are cached per-request to avoid repeat queries.
     */
    function setting(string $key, $default = null)
    {
        static $cache = null;

        if ($cache === null) {
            try {
                $cache = Setting::getAll();
            } catch (\Throwable $e) {
                $cache = [];
            }
        }

        return $cache[$key] ?? $default;
    }
}
