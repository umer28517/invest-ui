<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display the package management page.
     */
    public function index(): View
    {
        $packages = Package::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Store a newly created package.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'investment_amount' => ['required', 'numeric', 'min:1'],
            'daily_commission_percent' => ['required', 'numeric', 'min:0.01', 'max:100'],
            'min_withdrawal_limit' => ['required', 'numeric', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $package = Package::create($validated);

        return redirect()->route('admin.packages.index')->with('status', "Package '{$package->name}' created successfully.");
    }

    /**
     * Update an existing package.
     */
    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'investment_amount' => ['required', 'numeric', 'min:1'],
            'daily_commission_percent' => ['required', 'numeric', 'min:0.01', 'max:100'],
            'min_withdrawal_limit' => ['required', 'numeric', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('status', "Package '{$package->name}' updated successfully.");
    }

    /**
     * Remove the specified package.
     */
    public function destroy(Package $package): RedirectResponse
    {
        $name = $package->name;
        $package->delete();

        return redirect()->route('admin.packages.index')->with('status', "Package '{$name}' deleted successfully.");
    }
}
