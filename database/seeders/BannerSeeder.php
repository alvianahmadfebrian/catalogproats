<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::truncate();

        Banner::create([
            'badge_text' => 'PROMO EKSKLUSIF ALAT MUSIK',
            'title' => 'Pusat Alat Musik Marching Band, Tradisional & Band',
            'subtitle' => 'Melayani pemesanan drumband, marching band HTS, instrumen etnik tradisional, hingga peralatan band profesional.',
            'button_text' => 'Jelajahi Instrumen',
            'button_url' => '#catalog-section',
            'image_url' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=1200&q=80',
            'bg_color_from' => 'amber-400',
            'bg_color_to' => 'amber-300',
            'order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'badge_text' => 'SUPER DISKON DRUMBAND & MARCHING BAND',
            'title' => 'Set Drumband & Marching Band HTS Terlengkap',
            'subtitle' => 'Dapatkan penawaran harga pabrik & garansi resmi untuk pemesanan unit sekolah, instansi, dan umum seluruh Indonesia.',
            'button_text' => 'Lihat Produk Marching',
            'button_url' => '#catalog-section',
            'image_url' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=1200&q=80',
            'bg_color_from' => 'amber-500',
            'bg_color_to' => 'yellow-400',
            'order' => 2,
            'is_active' => true,
        ]);

        Banner::create([
            'badge_text' => 'WARISAN BUDAYA NUSANTARA',
            'title' => 'Alat Musik Tradisional Khas Etnik Indonesia',
            'subtitle' => 'Koleksi Angklung Bambu Hitam, Gendang Sunda/Jawa, Sapeh Dayak, hingga Gong Perunggu berkualitas tinggi.',
            'button_text' => 'Jelajahi Musik Tradisional',
            'button_url' => '#catalog-section',
            'image_url' => 'https://images.unsplash.com/photo-1511192336575-5a79af67a629?auto=format&fit=crop&w=1200&q=80',
            'bg_color_from' => 'yellow-400',
            'bg_color_to' => 'amber-400',
            'order' => 3,
            'is_active' => true,
        ]);
    }
}
