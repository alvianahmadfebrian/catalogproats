<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::ordered()->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.form', [
            'banner' => new Banner(),
            'isEdit' => false
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:1000',
            'badge_text' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'bg_color_from' => 'nullable|string|max:100',
            'bg_color_to' => 'nullable|string|max:100',
            'order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        // Handle File Upload if present
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('banners', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        unset($validated['image_file']);

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner slide berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.form', [
            'banner' => $banner,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:1000',
            'badge_text' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'bg_color_from' => 'nullable|string|max:100',
            'bg_color_to' => 'nullable|string|max:100',
            'order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        // Handle File Upload if present
        if ($request->hasFile('image_file')) {
            // Delete old file if local
            if ($banner->image_url && str_starts_with($banner->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $banner->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image_file')->store('banners', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        unset($validated['image_file']);

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner slide berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image_url && str_starts_with($banner->image_url, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $banner->image_url);
            Storage::disk('public')->delete($oldPath);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner slide berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->is_active = !$banner->is_active;
        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Status banner slide berhasil diubah!');
    }
}
