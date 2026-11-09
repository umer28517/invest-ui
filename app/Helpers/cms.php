<?php

use App\Services\CmsService;

if (!function_exists('cms')) {
    /**
     * Bulletproof helper to fetch CMS content or fallback safely to default.
     * Guaranteed never to crash the application if content is missing or database fails.
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    function cms(string $key, string $default = ''): string
    {
        return CmsService::get($key, $default);
    }
}
