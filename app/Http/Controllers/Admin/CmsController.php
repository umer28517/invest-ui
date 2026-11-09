<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use App\Services\CmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CmsController extends Controller
{
    /**
     * Display the CMS content editor organized by tabs & sections.
     */
    public function index(): View
    {
        // Auto-seed defaults if table is empty
        if (SiteContent::count() === 0) {
            (new \Database\Seeders\SiteContentSeeder())->run();
        }

        $allContents = SiteContent::all();
        $homeContents = $allContents->where('group', 'home')->groupBy('section');
        $authContents = $allContents->where('group', 'auth')->groupBy('section');
        $dashboardContents = $allContents->where('group', 'dashboard')->groupBy('section');

        return view('admin.cms.index', compact(
            'homeContents',
            'authContents',
            'dashboardContents'
        ));
    }

    /**
     * Update CMS content fields.
     */
    public function update(Request $request): RedirectResponse
    {
        $contents = $request->input('contents', []);

        foreach ($contents as $key => $val) {
            $record = SiteContent::where('key', $key)->first();
            if ($record) {
                // If value is null or empty string, store null so it falls back safely to default
                $trimmed = is_string($val) ? trim($val) : '';
                $record->value = ($trimmed !== '') ? $trimmed : null;
                $record->save();
            }
        }

        // Flush memory and file/redis cache
        CmsService::clearCache();

        return redirect()->route('admin.cms.index')->with('status', 'Platform content updated successfully!');
    }

    /**
     * Reset all content in a specific group or everything back to system defaults.
     */
    public function reset(Request $request): RedirectResponse
    {
        $group = $request->input('group');

        if ($group) {
            SiteContent::where('group', $group)->update(['value' => null]);
        } else {
            SiteContent::query()->update(['value' => null]);
        }

        CmsService::clearCache();

        return redirect()->route('admin.cms.index')->with('status', 'Content reset to platform defaults successfully!');
    }
}
