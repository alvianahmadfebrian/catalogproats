<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'store_name' => Setting::get('store_name', 'Proats E-Catalog'),
            'store_tagline' => Setting::get('store_tagline', 'Toko Alat Musik Terlengkap & Terpercaya'),
            'store_phone' => Setting::get('store_phone', '081234567890'),
            'store_email' => Setting::get('store_email', 'cs@proats-music.com'),
            'store_address' => Setting::get('store_address', 'Jl. Musik Nusantara No. 27, Bandung'),
            'store_hours' => Setting::get('store_hours', 'Senin - Sabtu (08:00 - 20:00 WIB)'),
            
            'announcement_bar' => Setting::get('announcement_bar', 'Gratis Ongkir Seluruh Indonesia Untuk Pembelian Marching Band & Set Musik!'),
            'enable_chat' => Setting::get('enable_chat', '1'),
            'enable_cart' => Setting::get('enable_cart', '1'),
            'maintenance_mode' => Setting::get('maintenance_mode', '0'),

            // Social Media links
            'social_facebook' => Setting::get('social_facebook', 'https://www.facebook.com/pro.ats.5'),
            'social_instagram' => Setting::get('social_instagram', 'https://www.instagram.com/proats.marchingproduct?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=='),
            'social_tiktok' => Setting::get('social_tiktok', 'https://www.tiktok.com/@proats'),

            // 2 Stacked Right Promo Banners
            'promo_banner_1_badge' => Setting::get('promo_banner_1_badge', 'PROATSPAY DISKON'),
            'promo_banner_1_title' => Setting::get('promo_banner_1_title', 'Marching Band & Drumband'),
            'promo_banner_1_subtitle' => Setting::get('promo_banner_1_subtitle', '100% Produk Original Garansi Resmi'),
            'promo_banner_1_link' => Setting::get('promo_banner_1_link', '?category=marching-band-drumband'),
            'promo_banner_1_image' => Setting::get('promo_banner_1_image', 'https://images.unsplash.com/photo-1511192336575-5a79af67a629?auto=format&fit=crop&w=600&q=80'),

            'promo_banner_2_badge' => Setting::get('promo_banner_2_badge', 'PILIHAN LOKAL'),
            'promo_banner_2_title' => Setting::get('promo_banner_2_title', 'Peralatan Band Lengkap'),
            'promo_banner_2_subtitle' => Setting::get('promo_banner_2_subtitle', 'Gitar, Keyboard, Drum & Bass'),
            'promo_banner_2_link' => Setting::get('promo_banner_2_link', '?category=alat-musik-band'),
            'promo_banner_2_image' => Setting::get('promo_banner_2_image', 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&fit=crop&w=600&q=80'),
        ];

        $admin = Auth::user();

        return view('admin.settings.index', compact('settings', 'admin'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', 'admin_username', 'admin_password', 'admin_password_confirmation', 'promo_banner_1_file', 'promo_banner_2_file']);

        // Handle Banner 1 File Upload
        if ($request->hasFile('promo_banner_1_file')) {
            $file = $request->file('promo_banner_1_file');
            $fileName = 'promo_banner_1_' . time() . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/banners'))) {
                mkdir(public_path('uploads/banners'), 0755, true);
            }
            
            $file->move(public_path('uploads/banners'), $fileName);
            Setting::set('promo_banner_1_image', '/uploads/banners/' . $fileName);
        }

        // Handle Banner 2 File Upload
        if ($request->hasFile('promo_banner_2_file')) {
            $file = $request->file('promo_banner_2_file');
            $fileName = 'promo_banner_2_' . time() . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/banners'))) {
                mkdir(public_path('uploads/banners'), 0755, true);
            }
            
            $file->move(public_path('uploads/banners'), $fileName);
            Setting::set('promo_banner_2_image', '/uploads/banners/' . $fileName);
        }

        foreach ($inputs as $key => $val) {
            Setting::set($key, $val);
        }

        // Ensure toggles are saved if unchecked
        Setting::set('enable_chat', $request->has('enable_chat') ? '1' : '0');
        Setting::set('enable_cart', $request->has('enable_cart') ? '1' : '0');
        Setting::set('maintenance_mode', $request->has('maintenance_mode') ? '1' : '0');

        // Handle Admin Credentials update if provided
        $admin = Auth::user();
        if ($request->filled('admin_username')) {
            $admin->username = $request->input('admin_username');
        }

        if ($request->filled('admin_password')) {
            $request->validate([
                'admin_password' => 'required|min:6|confirmed'
            ]);
            $admin->password = Hash::make($request->input('admin_password'));
        }

        $admin->save();

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan sistem CMS berhasil diperbarui!');
    }
}
