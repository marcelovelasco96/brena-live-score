<?php

return [
    'key' => env('BRAND_KEY', 'default'),

    'name' => env('BRAND_NAME', 'Live Studio'),

    'organization' => env(
        'BRAND_ORGANIZATION',
        'Broadcast Control'
    ),

    'logo_dark' => env(
        'BRAND_LOGO_DARK',
        '/images/brands/brena/brand-full-dark.png'
    ),

    'logo_light' => env(
        'BRAND_LOGO_LIGHT',
        '/images/brands/brena/brand-wordmark-blue.png'
    ),

    'shield' => env(
        'BRAND_SHIELD',
        '/images/brands/brena/shield.png'
    ),

    'organization_logo' => env(
        'BRAND_ORGANIZATION_LOGO',
        '/images/brands/brena/brand-full-light.png'
    ),

    'wordmark_dark' => env(
        'BRAND_WORDMARK_DARK',
        '/images/brands/brena/brand-wordmark-black.png'
    ),

    'primary' => env('BRAND_PRIMARY', '#2563EB'),

    'accent' => env('BRAND_ACCENT', '#22C55E'),

    'danger' => env('BRAND_DANGER', '#EF4444'),

    'surface' => env('BRAND_SURFACE', '#0F1724'),

    'background' => env('BRAND_BACKGROUND', '#070A12'),
];
