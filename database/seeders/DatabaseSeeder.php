<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Super Admin & Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@jasafotografi.com'],
            [
                'name' => 'Super Admin Studio',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'phone' => '08111222333',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=256&q=80',
                'address' => 'Headquarters LensCraft Studio, Jakarta Pusat',
            ]
        );

        $admin = User::firstOrCreate(
            ['email' => 'admin@jasafotografi.com'],
            [
                'name' => 'Admin Studio',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=256&q=80',
                'address' => 'Jl. Studio Kreatif No. 12, Jakarta Selatan',
            ]
        );

        // 2. Create Customers
        $customer1 = User::firstOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '082198765432',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=256&q=80',
                'address' => 'Jl. Mawar Merah No. 45, Bandung',
            ]
        );

        $customer2 = User::firstOrCreate(
            ['email' => 'siti@example.com'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '085712345678',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=256&q=80',
                'address' => 'Jl. Kenanga Indah No. 8, Surabaya',
            ]
        );

        // 3. Create Services
        $servicesData = [
            // Foto Wisuda
            [
                'name' => 'Paket Wisuda Silver - Studio & Outdoor',
                'slug' => 'wisuda-silver-studio-outdoor',
                'category' => 'wisuda',
                'short_description' => 'Sesi foto wisuda personal atau bersama 2 teman dengan 10 foto edit profesional.',
                'description' => 'Paket ideal bagi wisudawan yang menginginkan kenangan kelulusan elegan dan memukau. Dilengkapi fasilitas studio modern, pencahayaan studio standar broadcast, dan spot outdoor kampus.',
                'price' => 450000,
                'discount_price' => 399000,
                'duration' => '1.5 Jam',
                'features' => [
                    'Sesi foto 1.5 Jam (Studio / Lokasi Kampus)',
                    '10 Foto Edit High-Resolution',
                    'Semua file mentah (Raw/Original Jpeg) via Google Drive',
                    'Maksimal 3 Orang (Wisudawan + Pendamping)',
                    '1 Fotografer Profesional',
                ],
                'thumbnail' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=800&q=80',
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Paket Wisuda Platinum Keluarga',
                'slug' => 'wisuda-platinum-keluarga',
                'category' => 'wisuda',
                'short_description' => 'Dokumentasi wisuda lengkap bersama keluarga besar, cetak frame canvas, dan album eksklusif.',
                'description' => 'Momen wisuda adalah kebanggaan seluruh keluarga. Paket Platinum menghadirkan sesi foto intensif bersama kedua orang tua dan keluarga besar tanpa batasan anggota keluarga inti.',
                'price' => 950000,
                'discount_price' => 850000,
                'duration' => '3 Jam',
                'features' => [
                    'Sesi foto hingga 3 Jam di lokasi wisuda / studio',
                    '25 Foto Edit Master Retouched',
                    '1 Buah Cetak Canvas Frame 40x60 cm Eksklusif',
                    'Cetak Foto 10R + Frame Minimalis (3 pcs)',
                    'Semua file digital diserahkan via Flashdisk Kayu + Box',
                    '2 Fotografer + 1 Penata Gaya',
                ],
                'thumbnail' => 'https://images.unsplash.com/photo-1627556704302-624286467c65?auto=format&fit=crop&w=800&q=80',
                'is_popular' => true,
                'is_active' => true,
            ],

            // Foto Produk UMKM
            [
                'name' => 'Foto Produk Katalog Marketplace UMKM',
                'slug' => 'foto-produk-katalog-marketplace-umkm',
                'category' => 'umkm',
                'short_description' => 'Foto produk latar putih / clean background yang siap upload ke Shopee, Tokopedia, dan TikTok Shop.',
                'description' => 'Tingkatkan konversi penjualan online Anda dengan foto produk berkualitas studio e-commerce. Komposisi tepat, warna akurat 99%, dan penataan cahaya menonjolkan tekstur produk.',
                'price' => 500000,
                'discount_price' => 450000,
                'duration' => '2 Jam Sesi Foto',
                'features' => [
                    'Hingga 10 SKU / varian produk',
                    '3 Sudut foto per SKU (Total 30 foto edit)',
                    'Pilihan background: Putih bersih, Pastel, atau Flatlay',
                    'Resolusi optimized untuk e-commerce',
                    'Waktu pengerjaan cepat 3 hari kerja',
                ],
                'thumbnail' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Paket Creative Thematic Produk & F&B',
                'slug' => 'creative-thematic-produk-food-beverage',
                'category' => 'umkm',
                'short_description' => 'Foto produk tematik dengan properti estetik, lighting dramatis, cocok untuk makanan, minuman, dan skincare.',
                'description' => 'Khusus brand kuliner, kosmetik, atau fashion UMKM yang ingin membangun citra premium di Instagram. Dilengkapi properti tematik, garnishing, dan konsep visual moodboard.',
                'price' => 850000,
                'discount_price' => 750000,
                'duration' => '3 Jam Sesi Foto',
                'features' => [
                    'Maksimal 6 Menu / Produk Unggulan',
                    'Styling properti lengkap (bunga, kain, elemen bahan alami)',
                    '20 Foto Edit Tematik Instagram Look',
                    'Bonus 2 format video stopmotion pendek',
                    'Food / Product stylist khusus di lokasi',
                ],
                'thumbnail' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80',
                'is_popular' => false,
                'is_active' => true,
            ],

            // Dokumentasi Acara
            [
                'name' => 'Dokumentasi Acara Half-Day (Seminar / Workshop)',
                'slug' => 'dokumentasi-acara-half-day',
                'category' => 'acara',
                'short_description' => 'Liputan foto acara gathering, seminar kampus, atau workshop bisnis hingga 4 jam.',
                'description' => 'Abadikan setiap interaksi penting, keynote speaker, dan antusiasme audiens. Hasil foto tajam dengan lensa profesional dan penangkapan ekspresi candid alami.',
                'price' => 1200000,
                'discount_price' => 1050000,
                'duration' => '4 Jam (Half-Day)',
                'features' => [
                    '1 Fotografer Senior Dokumentasi',
                    'Unlimited Shoot selama 4 Jam',
                    '50 Foto Highlight Edit warna & kontras di hari yang sama',
                    'Semua file diupload ke Private Cloud Drive',
                    'Cocok untuk seminar, lamaran, ulang tahun, gathering',
                ],
                'thumbnail' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=800&q=80',
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Dokumentasi Acara Full-Day & Konferensi',
                'slug' => 'dokumentasi-acara-full-day',
                'category' => 'acara',
                'short_description' => 'Liputan lengkap seharian penuh untuk festival, konser, konferensi bisnis, atau pesta pernikahan.',
                'description' => 'Paket komprehensif dengan tim fotografer ganda untuk menjamin tidak ada satupun momen krusial yang terlewat dari berbagai sudut pandang panggung maupun audiens.',
                'price' => 2500000,
                'discount_price' => 2200000,
                'duration' => '8 Jam (Full-Day)',
                'features' => [
                    '2 Fotografer Profesional',
                    'Liputan nonstop hingga 8 Jam',
                    '100+ Foto Highlight Edit Cepat',
                    'Same Day Edit Preview untuk sosial media panitia',
                    'Flashdisk kayu eksklusif + hardcopy album preview',
                ],
                'thumbnail' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=800&q=80',
                'is_popular' => true,
                'is_active' => true,
            ],

            // Video Promosi
            [
                'name' => 'Video Reels & TikTok Promosi UMKM',
                'slug' => 'video-reels-tiktok-promosi-umkm',
                'category' => 'video_promosi',
                'short_description' => '3 Video vertikal pendek 9:16 sinematik dengan musik tren, subtitle dinamis, dan hook memikat.',
                'description' => 'Solusi tepat meningkatkan jangkauan di Instagram Reels dan TikTok. Kami merancang hook awal yang kuat, transisi halus, color grading punchy, dan sound effect berlisensi.',
                'price' => 900000,
                'discount_price' => 790000,
                'duration' => '2 Jam Pengambilan Gambar',
                'features' => [
                    '3 Video format 9:16 (durasi 15-45 detik per video)',
                    'Kamera sinema 4K + Gimbal Stabilizer',
                    'Pemberian subtitle animasi dinamis',
                    'Audio voiceover / sound effect & music license',
                    '2x Revisi minor per video',
                ],
                'thumbnail' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?auto=format&fit=crop&w=800&q=80',
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Video Profil Perusahaan & Brand Sinematik',
                'slug' => 'video-profil-perusahaan-brand-sinematik',
                'category' => 'video_promosi',
                'short_description' => 'Video company profile resolusi 4K dengan narasi wawancara, drone aerial shot, dan editing premium.',
                'description' => 'Bangun kepercayaan klien institusi dan investor dengan video profil perusahaan yang megah. Melibatkan sutradara, videografer profesional, drone pilot berlisensi, dan penataan audio wawancara jernih.',
                'price' => 3800000,
                'discount_price' => 3500000,
                'duration' => '1 Hari Produksi (6 Jam)',
                'features' => [
                    'Video Profil durasi 2 - 3 Menit resolusi 4K UHD',
                    'Pengambilan gambar udara dengan Drone 4K',
                    'Wawancara founder/manajemen dengan Mic Wireless Studio',
                    'Motion Graphic logo dan teks pembuka',
                    'Versi teaser 60 detik untuk Instagram feed',
                ],
                'thumbnail' => 'https://images.unsplash.com/photo-1536240478700-b869070f9279?auto=format&fit=crop&w=800&q=80',
                'is_popular' => false,
                'is_active' => true,
            ],
        ];

        $createdServices = [];
        foreach ($servicesData as $service) {
            $createdServices[] = Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        // 4. Create Sample Orders & Payments across different dates for rich financial report
        $ordersSample = [
            [
                'user' => $customer1,
                'service' => $createdServices[0], // Wisuda Silver
                'date' => Carbon::now()->subDays(12)->toDateString(),
                'time' => '09:00 - 10:30 WIB',
                'location' => 'Kampus ITB Ganesha, Bandung',
                'notes' => 'Tolong bawa reflektor outdoor ya kak.',
                'status' => 'completed',
                'payment_method' => 'qris',
                'payment_status' => 'paid',
                'paid_days_ago' => 12,
            ],
            [
                'user' => $customer2,
                'service' => $createdServices[2], // Katalog UMKM
                'date' => Carbon::now()->subDays(8)->toDateString(),
                'time' => '13:00 - 15:00 WIB',
                'location' => 'Studio Foto Ruko Central Blok B-5, Jakarta',
                'notes' => 'Produk tas kulit handmade 10 warna berbeda.',
                'status' => 'completed',
                'payment_method' => 'bca_va',
                'payment_status' => 'paid',
                'paid_days_ago' => 9,
            ],
            [
                'user' => $customer1,
                'service' => $createdServices[6], // Video Reels TikTok
                'date' => Carbon::now()->subDays(4)->toDateString(),
                'time' => '10:00 - 12:00 WIB',
                'location' => 'Cafe Kopi Teman, Jl. Braga Bandung',
                'notes' => 'Konsep barista menu signature baru.',
                'status' => 'processing',
                'payment_method' => 'mandiri_va',
                'payment_status' => 'paid',
                'paid_days_ago' => 5,
            ],
            [
                'user' => $customer2,
                'service' => $createdServices[1], // Wisuda Platinum
                'date' => Carbon::now()->addDays(3)->toDateString(),
                'time' => '08:00 - 11:00 WIB',
                'location' => 'Gedung Sasana Budaya Ganesha (Sabuga)',
                'notes' => 'Foto bersama keluarga besar 8 orang.',
                'status' => 'confirmed',
                'payment_method' => 'bni_va',
                'payment_status' => 'paid',
                'paid_days_ago' => 1,
            ],
            [
                'user' => $customer1,
                'service' => $createdServices[4], // Acara Half Day
                'date' => Carbon::now()->addDays(7)->toDateString(),
                'time' => '08:30 - 12:30 WIB',
                'location' => 'Hotel Grand Mercure Hall Lt. 3',
                'notes' => 'Workshop digital marketing 100 peserta.',
                'status' => 'pending',
                'payment_method' => 'qris',
                'payment_status' => 'unpaid',
                'paid_days_ago' => null,
            ],
            [
                'user' => $customer2,
                'service' => $createdServices[5], // Acara Full Day
                'date' => Carbon::now()->subDays(25)->toDateString(),
                'time' => '09:00 - 17:00 WIB',
                'location' => 'Convention Hall JCC Senayan, Jakarta',
                'notes' => 'Annual National Gathering Bank Mandiri Mitra.',
                'status' => 'completed',
                'payment_method' => 'credit_card',
                'payment_status' => 'paid',
                'paid_days_ago' => 26,
            ],
            [
                'user' => $customer1,
                'service' => $createdServices[3], // Creative Thematic Produk
                'date' => Carbon::now()->subDays(35)->toDateString(),
                'time' => '13:00 - 16:00 WIB',
                'location' => 'Studio Foto Kreatif, Jakarta',
                'notes' => 'Foto dessert brownies panggang dan cookies.',
                'status' => 'completed',
                'payment_method' => 'bca_va',
                'payment_status' => 'paid',
                'paid_days_ago' => 36,
            ],
        ];

        foreach ($ordersSample as $index => $item) {
            $service = $item['service'];
            $user = $item['user'];
            $price = $service->effective_price;

            $order = Order::create([
                'order_code' => 'INV-' . date('Ymd', strtotime($item['date'])) . '-' . sprintf('%04d', $index + 1),
                'user_id' => $user->id,
                'service_id' => $service->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone ?? '08123456789',
                'booking_date' => $item['date'],
                'booking_time' => $item['time'],
                'location' => $item['location'],
                'notes' => $item['notes'],
                'package_price' => $price,
                'additional_fee' => 0,
                'discount_amount' => 0,
                'total_amount' => $price,
                'status' => $item['status'],
                'created_at' => Carbon::parse($item['date'])->subDays(2),
                'updated_at' => Carbon::parse($item['date']),
            ]);

            Payment::create([
                'order_id' => $order->id,
                'transaction_code' => 'TRX-' . date('YmdHis', strtotime($order->created_at)) . '-' . sprintf('%03d', $index + 1),
                'payment_gateway' => 'midtrans_simulation',
                'payment_method' => $item['payment_method'],
                'amount' => $price,
                'status' => $item['payment_status'],
                'payment_reference' => $item['payment_status'] === 'paid' ? 'REF-' . strtoupper(bin2hex(random_bytes(4))) : null,
                'paid_at' => $item['paid_days_ago'] !== null ? Carbon::now()->subDays($item['paid_days_ago']) : null,
                'payload' => [
                    'gateway' => 'Midtrans Simulator v2.4',
                    'issuer' => strtoupper($item['payment_method']),
                    'status_message' => $item['payment_status'] === 'paid' ? 'Success, payment completed.' : 'Waiting for customer settlement',
                ],
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        }
    }
}
