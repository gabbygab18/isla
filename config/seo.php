<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google Search Console Verification
    |--------------------------------------------------------------------------
    | Add your verification code from Google Search Console here,
    | or set GOOGLE_SITE_VERIFICATION in your .env file.
    |
    | How to get this:
    | 1. Go to search.google.com/search-console
    | 2. Add property → URL prefix → https://engrgab.gt.tc
    | 3. Choose "HTML tag" verification
    | 4. Copy the content="..." value and paste below or in .env
    */
    'google_verification' => env('GOOGLE_SITE_VERIFICATION', ''),

    /*
    |--------------------------------------------------------------------------
    | Bing Webmaster Tools Verification
    |--------------------------------------------------------------------------
    */
    'bing_verification' => env('BING_SITE_VERIFICATION', ''),

];