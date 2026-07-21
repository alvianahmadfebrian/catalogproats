<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Admin User
        User::create([
            'name' => 'Master Vian',
            'username' => 'mastervian',
            'email' => 'mastervian@proats.com',
            'password' => Hash::make('proats27&'),
        ]);

        // Create Musical Instrument Categories
        $categoriesData = [
            ['name' => 'Marching Band & Drumband', 'slug' => 'marching-band-drumband', 'icon' => 'drum'],
            ['name' => 'Musik Tradisional', 'slug' => 'musik-tradisional', 'icon' => 'compact-disc'],
            ['name' => 'Alat Musik Band', 'slug' => 'alat-musik-band', 'icon' => 'guitar'],
            ['name' => 'Keyboard & Piano', 'slug' => 'keyboard-piano', 'icon' => 'sliders'],
            ['name' => 'Aksesoris & Sound System', 'slug' => 'aksesoris-sound-system', 'icon' => 'headphones'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::create($cat);
        }

        // Musical Instrument Products Data
        $products = [
            // Marching Band & Drumband Category
            [
                'category_id' => $categories['marching-band-drumband']->id,
                'name' => 'Snare Drum Marching HTS High Tension 14 Inci Premium Harness',
                'slug' => Str::slug('Snare Drum Marching HTS High Tension 14 Inci Premium Harness'),
                'price' => 3850000,
                'original_price' => 4500000,
                'discount_percent' => 14,
                'rating' => 4.9,
                'sold_count' => 120,
                'stock' => 15,
                'location' => 'Yogyakarta',
                'image_url' => 'https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&w=800&q=80',
                'description' => 'Snare drum marching profesional tipe HTS (High Tension Snare) ukuran 14 inci dengan 12 lug aluminium alloy ultra presisi. Suara crisp, nyaring, peka, dan tahan cuaca ekstrim. Lengkap dengan carrier harness alumunium ergofit dan stik marching hts.',
                'variants' => ['White Gloss', 'Sparkle Silver', 'Metallic Red', 'Midnight Black'],
            ],
            [
                'category_id' => $categories['marching-band-drumband']->id,
                'name' => 'Bass Drum Marching 22 Inci Light Weight Carrier All Maple Shell',
                'slug' => Str::slug('Bass Drum Marching 22 Inci Light Weight Carrier All Maple Shell'),
                'price' => 4200000,
                'original_price' => 5000000,
                'discount_percent' => 16,
                'rating' => 4.8,
                'sold_count' => 85,
                'stock' => 10,
                'location' => 'Surakarta',
                'image_url' => 'https://images.unsplash.com/photo-1543791187-df796fa11835?auto=format&fit=crop&w=800&q=80',
                'description' => 'Bass drum marching 22 inci berbahan kayu 7-ply All Maple Shell untuk proyeksi nada bass yang dalam dan beresonansi kuat. Menggunakan ring lipat triple-flange dan mallets pemukul bass profesional.',
                'variants' => ['Size 18 Inci', 'Size 20 Inci', 'Size 22 Inci', 'Size 24 Inci'],
            ],
            [
                'category_id' => $categories['marching-band-drumband']->id,
                'name' => 'Marching Trio / Quarto Tenor Tom Set 8-10-12-13 Inci Complete',
                'slug' => Str::slug('Marching Trio Quarto Tenor Tom Set 8-10-12-13 Inci Complete'),
                'price' => 5600000,
                'original_price' => 6500000,
                'discount_percent' => 14,
                'rating' => 4.9,
                'sold_count' => 45,
                'stock' => 8,
                'location' => 'Yogyakarta',
                'image_url' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=800&q=80',
                'description' => 'Set Tenor Tom Quarto marching band (4 drum: 8", 10", 12", 13") dengan kerangka aluminium ringan namun kokoh. Resonansi tone jernih dan harmonis untuk atraksi melodi drumband.',
                'variants' => ['Quarto 4 Drum', 'Quint 5 Drum'],
            ],
            [
                'category_id' => $categories['marching-band-drumband']->id,
                'name' => 'Trumpet Marching Bb Brass Gold Lacquer Finish Case Included',
                'slug' => Str::slug('Trumpet Marching Bb Brass Gold Lacquer Finish Case Included'),
                'price' => 3250000,
                'original_price' => 3900000,
                'discount_percent' => 16,
                'rating' => 4.8,
                'sold_count' => 140,
                'stock' => 20,
                'location' => 'Bandung',
                'image_url' => 'https://images.unsplash.com/photo-1573871666457-7c7329118cf9?auto=format&fit=crop&w=800&q=80',
                'description' => 'Terompet Marching Band nada Dasar Bb berkonstruksi Yellow Brass tebal dengan finishing Gold Lacquer mewah. Valve piston monel super halus dengan respons tiup sangat enteng.',
                'variants' => ['Gold Lacquer', 'Silver Plated'],
            ],

            // Musik Tradisional Category
            [
                'category_id' => $categories['musik-tradisional']->id,
                'name' => 'Angklung Bambu Hitam 1 Octave Set 31 Nada Standar Seni Musik',
                'slug' => Str::slug('Angklung Bambu Hitam 1 Octave Set 31 Nada Standar Seni Musik'),
                'price' => 1450000,
                'original_price' => 1800000,
                'discount_percent' => 19,
                'rating' => 4.9,
                'sold_count' => 310,
                'stock' => 25,
                'location' => 'Bandung',
                'image_url' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80',
                'description' => 'Angklung sunda tradisional dari bahan bambu hitam (Gigantochloa atroviolacea) berkualitas tua dan awet. Stemming nada presisi standar internasional A440Hz untuk pertunjukan sekolah & sanggar seni.',
                'variants' => ['Bambu Hitam (31 Nada)', 'Bambu Kuning (18 Nada Melody)'],
            ],
            [
                'category_id' => $categories['musik-tradisional']->id,
                'name' => 'Gendang / Kendang Sunda & Jawa Kayu Nangka Kulit Sapi Pilihan',
                'slug' => Str::slug('Gendang Kendang Sunda Jawa Kayu Nangka Kulit Sapi Pilihan'),
                'price' => 2100000,
                'original_price' => 2600000,
                'discount_percent' => 19,
                'rating' => 4.9,
                'sold_count' => 180,
                'stock' => 12,
                'location' => 'Surakarta',
                'image_url' => 'https://images.unsplash.com/photo-1541689592655-f5f52825a3b8?auto=format&fit=crop&w=800&q=80',
                'description' => 'Set kendang tradisional (Kendang Indung & Kendang Ketiplak) terbuat dari batang kayu nangka utuh berkualitas tinggi dengan membran kulit sapi pilihan tebal. Suara tak-tung bulat dan mantap.',
                'variants' => ['Set Kendang Sunda Complete', 'Kendang Ciblon Jawa'],
            ],
            [
                'category_id' => $categories['musik-tradisional']->id,
                'name' => 'Sapeh / Sape Kalimantan Ukiran Khas Dayak Kayu Jati Etnik',
                'slug' => Str::slug('Sapeh Sape Kalimantan Ukiran Khas Dayak Kayu Jati Etnik'),
                'price' => 2800000,
                'original_price' => 3400000,
                'discount_percent' => 17,
                'rating' => 5.0,
                'sold_count' => 65,
                'stock' => 7,
                'location' => 'Pontianak',
                'image_url' => 'https://images.unsplash.com/photo-1525201548942-d8732f6617a0?auto=format&fit=crop&w=800&q=80',
                'description' => 'Alat musik petik tradisional Sape Khas Suku Dayak dengan ukiran relief etnik bermotif flora-fauna khas Kalimantan. Terbuat dari kayu jati tua bermutu tinggi dengan elektrik piezo pickup terpasang.',
                'variants' => ['Akustik Elektrik 4 Senar', 'Akustik Elektrik 6 Senar'],
            ],
            [
                'category_id' => $categories['musik-tradisional']->id,
                'name' => 'Gong Perunggu Tradisional Diameter 60cm Stand Kayu Ukir',
                'slug' => Str::slug('Gong Perunggu Tradisional Diameter 60cm Stand Kayu Ukir'),
                'price' => 4850000,
                'original_price' => 5500000,
                'discount_percent' => 11,
                'rating' => 4.9,
                'sold_count' => 40,
                'stock' => 5,
                'location' => 'Yogyakarta',
                'image_url' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=800&q=80',
                'description' => 'Gong berbahan perunggu campuran kuningan dengan suara dentuman mendalam (gong ageng). Dilengkapi tiang gayor penopang kayu jati ukiran naga khas Solo/Yogya.',
                'variants' => ['Diameter 50cm', 'Diameter 60cm', 'Diameter 80cm'],
            ],

            // Alat Musik Band Category
            [
                'category_id' => $categories['alat-musik-band']->id,
                'name' => 'Gitar Elektrik Custom Stratocaster Maple Neck Alnico V Pickups',
                'slug' => Str::slug('Gitar Elektrik Custom Stratocaster Maple Neck Alnico V Pickups'),
                'price' => 2650000,
                'original_price' => 3200000,
                'discount_percent' => 17,
                'rating' => 4.9,
                'sold_count' => 540,
                'stock' => 30,
                'location' => 'Jakarta Selatan',
                'image_url' => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&fit=crop&w=800&q=80',
                'description' => 'Gitar elektrik bodi Alder dengan neck Roasted Maple dan konfigurasi pickup HSS Alnico V. Menghasilkan karakter tone versatil mulai dari twang jernih hingga crunch overdrive tinggi.',
                'variants' => ['Sunburst Gloss', 'Olympic White', 'Sonic Blue', 'Black Velvet'],
            ],
            [
                'category_id' => $categories['alat-musik-band']->id,
                'name' => 'Gitar Akustik Elektrik Solid Sitka Spruce Top Fishman Presys II',
                'slug' => Str::slug('Gitar Akustik Elektrik Solid Sitka Spruce Top Fishman Presys II'),
                'price' => 1950000,
                'original_price' => 2500000,
                'discount_percent' => 22,
                'rating' => 4.8,
                'sold_count' => 890,
                'stock' => 40,
                'location' => 'Jakarta Barat',
                'image_url' => 'https://images.unsplash.com/photo-1525201548942-d8732f6617a0?auto=format&fit=crop&w=800&q=80',
                'description' => 'Gitar Akustik Dreadnought Cutaway dengan Solid Sitka Spruce top dan Rosewood back/sides. Dilengkapi Preamp Equalizer Fishman Presys II + Digital Tuner terintegrasi.',
                'variants' => ['Natural Satin', 'Vintage Sunburst', 'Black Gloss'],
            ],
            [
                'category_id' => $categories['alat-musik-band']->id,
                'name' => 'Drum Kit Akustik 5-Piece Birch Shell Hardware & Cymbals Set',
                'slug' => Str::slug('Drum Kit Akustik 5 Piece Birch Shell Hardware Cymbals Set'),
                'price' => 6900000,
                'original_price' => 8200000,
                'discount_percent' => 15,
                'rating' => 4.9,
                'sold_count' => 110,
                'stock' => 10,
                'location' => 'Tangerang',
                'image_url' => 'https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&w=800&q=80',
                'description' => 'Set Drum Akustik 5 pieces (Bass 22", Snare 14", Tom 10", 12", Floor 16") berbahan 100% Birch Wood. Paket lengkap include pedal bass, stand hardware tebal double-braced, dan set simbal Brass (Hi-hat 14", Crash 16", Ride 20").',
                'variants' => ['Wine Red Metallic', 'Deep Blue Sparkle', 'Matte Black'],
            ],
            [
                'category_id' => $categories['alat-musik-band']->id,
                'name' => 'Gitar Bass Elektrik 5 Senar Active Equalizer 3-Band Mahogany Body',
                'slug' => Str::slug('Gitar Bass Elektrik 5 Senar Active Equalizer 3 Band Mahogany Body'),
                'price' => 3100000,
                'original_price' => 3800000,
                'discount_percent' => 18,
                'rating' => 4.8,
                'sold_count' => 210,
                'stock' => 18,
                'location' => 'Surabaya',
                'image_url' => 'https://images.unsplash.com/photo-1550985616-10810253b84d?auto=format&fit=crop&w=800&q=80',
                'description' => 'Bass elektrik 5 senar bodi Kayu Mahoni tebal dengan Preamp Aktif 3-Band EQ (Bass, Middle, Treble). Suara bass punchy, artikulasi low B sangat bulat dan tidak benyek.',
                'variants' => ['Natural Oil Finish', 'Walnut Brown', 'Trans Black'],
            ],

            // Keyboard & Piano Category
            [
                'category_id' => $categories['keyboard-piano']->id,
                'name' => 'Digital Piano 88 Keys Graded Hammer Action Touch Sensitive',
                'slug' => Str::slug('Digital Piano 88 Keys Graded Hammer Action Touch Sensitive'),
                'price' => 5450000,
                'original_price' => 6500000,
                'discount_percent' => 16,
                'rating' => 4.9,
                'sold_count' => 320,
                'stock' => 14,
                'location' => 'Jakarta Pusat',
                'image_url' => 'https://images.unsplash.com/photo-1520523839897-bd0b52f945a0?auto=format&fit=crop&w=800&q=80',
                'description' => 'Piano Digital 88 tuts berbobot (Graded Hammer Standard) terasa persis seperti Piano Akustik Grand. Dilengkapi 64 polyphony, 24 voice sampel grand piano profesional, 3 pedal kualifikasi, dan koneksi USB MIDI.',
                'variants' => ['Black Elegant Stand Set', 'White Pearl Stand Set'],
            ],
            [
                'category_id' => $categories['keyboard-piano']->id,
                'name' => 'Arranger Keyboard Workstation 61 Touch Response Keys Indonesian Rhythms',
                'slug' => Str::slug('Arranger Keyboard Workstation 61 Touch Response Keys Indonesian Rhythms'),
                'price' => 3750000,
                'original_price' => 4400000,
                'discount_percent' => 14,
                'rating' => 4.8,
                'sold_count' => 460,
                'stock' => 25,
                'location' => 'Jakarta Selatan',
                'image_url' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80',
                'description' => 'Keyboard Arranger 61 tuts dinamis dengan 800+ suara alat musik dunia & 250+ style irama pengiring lengkap (Termasuk Rhythm Dangdut, Pop Indonesia, Keroncong, Campursari). Cocok untuk panggung maupun latihan.',
                'variants' => ['Standard Black Pack', 'Include Sustain & X-Stand Pack'],
            ],

            // Aksesoris & Sound System Category
            [
                'category_id' => $categories['aksesoris-sound-system']->id,
                'name' => 'Amplifier Gitar Combo 40 Watt Digital Effects & Bluetooth Stream',
                'slug' => Str::slug('Amplifier Gitar Combo 40 Watt Digital Effects Bluetooth Stream'),
                'price' => 1850000,
                'original_price' => 2300000,
                'discount_percent' => 19,
                'rating' => 4.8,
                'sold_count' => 620,
                'stock' => 30,
                'location' => 'Semarang',
                'image_url' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=800&q=80',
                'description' => 'Amp Combo 40W dengan speaker 10 inci custom. Memiliki 8 pilihan amp voicing (Clean, Crunch, Lead, Metal) + efek digital (Reverb, Delay, Chorus, Flanger) serta fitur Audio Bluetooth streaming.',
                'variants' => ['Black Vintage', 'Tweed Cream'],
            ],
            [
                'category_id' => $categories['aksesoris-sound-system']->id,
                'name' => 'Wireless Microphone System UHF Dual Handheld Metal Body 100m Range',
                'slug' => Str::slug('Wireless Microphone System UHF Dual Handheld Metal Body 100m Range'),
                'price' => 1290000,
                'original_price' => 1750000,
                'discount_percent' => 26,
                'rating' => 4.9,
                'sold_count' => 780,
                'stock' => 45,
                'location' => 'Jakarta Utara',
                'image_url' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=800&q=80',
                'description' => 'Mikrofon Wireless genggam ganda (2 mic) dengan frekuensi UHF multi-channel anti bentrok sinyal. Bodi mikrofon logam tebal tahan banting dengan jangkauan sinyal penerima hingga 100 meter.',
                'variants' => ['2 Handheld Mic', '1 Handheld + 1 Headset Lapel'],
            ],
        ];

        foreach ($products as $prodData) {
            Product::create($prodData);
        }

        // Seed realistic Orders (Jan - Jul 2026)
        $allProducts = Product::all();
        $customerNames = ['Budi Santoso', 'Siti Nurhaliza', 'Ahmad Rizky', 'Dewi Lestari', 'Raka Pratama', 'Putri Ayu', 'Fajar Hidayat', 'Nadia Safitri', 'Dimas Prasetyo', 'Rina Wulandari'];

        for ($month = 1; $month <= 7; $month++) {
            // More orders in recent months
            $orderCount = rand(8, 18) + ($month * 3);

            for ($i = 0; $i < $orderCount; $i++) {
                $product = $allProducts->random();
                $qty = rand(1, 4);
                $day = rand(1, 28);

                Order::create([
                    'product_id' => $product->id,
                    'user_id' => null,
                    'customer_name' => $customerNames[array_rand($customerNames)],
                    'customer_phone' => '08' . rand(1000000000, 9999999999),
                    'quantity' => $qty,
                    'total_price' => $product->price * $qty,
                    'status' => rand(1, 10) <= 8 ? 'completed' : (rand(0, 1) ? 'pending' : 'cancelled'),
                    'created_at' => "2026-{$month}-{$day} " . rand(8, 21) . ':' . rand(10, 59) . ':00',
                    'updated_at' => "2026-{$month}-{$day} " . rand(8, 21) . ':' . rand(10, 59) . ':00',
                ]);
            }
        }
    }
}
