<?php

namespace App\Services;

use App\Models\SiteContent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Throwable;

class CmsService
{
    /**
     * Runtime in-memory cache to prevent multiple DB/Cache hits during a single request.
     */
    protected static ?array $memoryCache = null;

    /**
     * Cache key for storing compiled CMS values.
     */
    public const CACHE_KEY = 'site_cms_contents_map';

    /**
     * Bulletproof getter for CMS content.
     * Guaranteed NEVER to throw an exception or interrupt page execution.
     */
    public static function get(string $key, string $default = ''): string
    {
        try {
            if (static::$memoryCache === null) {
                static::loadAll();
            }

            if (isset(static::$memoryCache[$key])) {
                $val = static::$memoryCache[$key];
                if ($val !== null && trim((string) $val) !== '') {
                    return (string) $val;
                }
            }
        } catch (Throwable $e) {
            // Silently fallback to the supplied default text on any error
            return $default;
        }

        return $default;
    }

    /**
     * Load all contents into memory cache.
     */
    public static function loadAll(): void
    {
        try {
            static::$memoryCache = Cache::remember(self::CACHE_KEY, 3600, function () {
                if (!Schema::hasTable('site_contents')) {
                    return [];
                }

                return SiteContent::query()
                    ->get()
                    ->mapWithKeys(function ($item) {
                        $effective = !empty($item->value) && trim($item->value) !== '' 
                            ? $item->value 
                            : ($item->default_value ?? '');
                        return [$item->key => $effective];
                    })
                    ->toArray();
            });
        } catch (Throwable $e) {
            static::$memoryCache = [];
        }
    }

    /**
     * Clear all cached CMS content across memory and storage.
     */
    public static function clearCache(): void
    {
        static::$memoryCache = null;
        try {
            Cache::forget(self::CACHE_KEY);
        } catch (Throwable $e) {
            // Ignore cache forget failure
        }
    }
}
