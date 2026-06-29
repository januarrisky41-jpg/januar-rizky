<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            // ============================================================
            // PROPERTI 1 - Royal K Residence (Keamanan: HIGH TECH)
            // ============================================================
            [
                'title' => 'Royal K Residence',
                'location' => 'Surabaya',
                'price' => 500000000,
                'bedroom' => 3,
                'bathroom' => 2,
                'building_area' => 90,
                'land_area' => 150,
                'distance_to_center' => 5.5,
                'facility_score' => 4,
                'facility_details' => 'Dekat dengan akses tol Surabaya-Mojokerto (2 km)|Dekat dengan Mall Pakuwon (3 km)|Dekat dengan RS Dr. Soetomo (4 km)|Dekat dengan Universitas Airlangga (5 km)',
                'security_score' => 4,
                'security_details' => '1. Security 24 jam dengan 3 shift|2. One Gate System akses kartu RFID|3. CCTV 16 titik resolusi tinggi|4. Satpam bersertifikat|5. Patroli motor setiap 2 jam',
                'condition_score' => 85,
                'grade_score' => 80,
                'certificate_type' => 'SHM',
                'property_type' => 'Rumah',
                'description' => 'Hunian modern minimalis dengan akses strategis.',
                'image' => 'https://picsum.photos/800/500?random=1',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 2 - Ijo Lake (Keamanan: STANDAR)
            // ============================================================
            [
                'title' => 'Ijo Lake',
                'location' => 'Surabaya Barat',
                'price' => 450000000,
                'bedroom' => 2,
                'bathroom' => 1,
                'building_area' => 72,
                'land_area' => 120,
                'distance_to_center' => 3.0,
                'facility_score' => 5,
                'facility_details' => 'Dekat dengan Mall Tunjungan (1 km)|Dekat dengan RS Darmo (2 km)|Dekat dengan Taman Bungkul (500 m)|Dekat dengan Pasar Atom (1.5 km)|Dekat dengan Sekolah Internasional (2 km)',
                'security_score' => 3,
                'security_details' => '1. Security 24 jam|2. One Gate System|3. Satpam 2 orang shift|4. CCTV 8 titik|5. Alarm perumahan',
                'condition_score' => 75,
                'grade_score' => 70,
                'certificate_type' => 'SHM',
                'property_type' => 'Rumah',
                'description' => 'Lingkungan nyaman dan cocok untuk keluarga muda.',
                'image' => 'https://picsum.photos/800/500?random=2',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 3 - Almond Living (Keamanan: PREMIUM)
            // ============================================================
            [
                'title' => 'Almond Living',
                'location' => 'Sidoarjo',
                'price' => 650000000,
                'bedroom' => 4,
                'bathroom' => 2,
                'building_area' => 120,
                'land_area' => 200,
                'distance_to_center' => 8.0,
                'facility_score' => 3,
                'facility_details' => 'Dekat dengan akses tol Sidoarjo (3 km)|Dekat dengan Pasar Tradisional (1 km)|Dekat dengan RS Sidoarjo (2.5 km)|Dekat dengan Pusat Oleh-oleh (1.5 km)',
                'security_score' => 5,
                'security_details' => '1. Security premium 24 jam|2. One Gate System biometrik fingerprint|3. CCTV 32 titik 4K|4. Satpam bersertifikat IPPK 6 orang|5. Patroli kendaraan setiap 1 jam|6. Alarm terintegrasi|7. Akses tamu terdaftar',
                'condition_score' => 90,
                'grade_score' => 85,
                'certificate_type' => 'SHGB',
                'property_type' => 'Rumah',
                'description' => 'Perumahan premium dengan fasilitas lengkap.',
                'image' => 'https://picsum.photos/800/500?random=3',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 4 - Green Jombang (Keamanan: LENGKAP)
            // ============================================================
            [
                'title' => 'Green Jombang Residence',
                'location' => 'Mojokerto',
                'price' => 301135130,
                'bedroom' => 5,
                'bathroom' => 1,
                'building_area' => 169,
                'land_area' => 220,
                'distance_to_center' => 6.0,
                'facility_score' => 4,
                'facility_details' => 'Dekat dengan akses tol Mojokerto (4 km)|Dekat dengan Pasar Mojokerto (2 km)|Dekat dengan RS Mojokerto (3 km)|Dekat dengan Candi Majapahit (5 km)|Dekat dengan Sekolah Unggulan (2 km)',
                'security_score' => 4,
                'security_details' => '1. Security 24 jam|2. One Gate System kartu RFID|3. CCTV 12 titik|4. Satpam 4 orang|5. Pos keamanan utama dan belakang|6. Patroli rutin',
                'condition_score' => 82,
                'grade_score' => 78,
                'certificate_type' => 'SHM',
                'property_type' => 'Rumah',
                'description' => 'Perumahan asri dengan lingkungan yang nyaman.',
                'image' => 'https://picsum.photos/800/500?random=4',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 5 - Emerald Estate (Keamanan: EKSTRA)
            // ============================================================
            [
                'title' => 'Emerald Estate',
                'location' => 'Gresik',
                'price' => 304717939,
                'bedroom' => 5,
                'bathroom' => 4,
                'building_area' => 104,
                'land_area' => 180,
                'distance_to_center' => 4.5,
                'facility_score' => 4,
                'facility_details' => 'Dekat dengan akses tol Gresik (2 km)|Dekat dengan Mall Gresik (3 km)|Dekat dengan RS Gresik (2.5 km)|Dekat dengan Kawasan Industri (4 km)|Dekat dengan Sekolah Unggulan (1.5 km)',
                'security_score' => 5,
                'security_details' => '1. Security 24 jam 4 shift|2. One Gate System fingerprint|3. CCTV 28 titik|4. Satpam bersertifikat 6 orang|5. Patroli motor setiap 1 jam|6. Interkom terintegrasi|7. Akses tamu database',
                'condition_score' => 88,
                'grade_score' => 85,
                'certificate_type' => 'SHM',
                'property_type' => 'Rumah',
                'description' => 'Perumahan eksklusif dengan keamanan 24 jam.',
                'image' => 'https://picsum.photos/800/500?random=5',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 6 - Lamongan Green (Keamanan: DASAR)
            // ============================================================
            [
                'title' => 'Lamongan Green Residence',
                'location' => 'Pasuruan',
                'price' => 280237738,
                'bedroom' => 5,
                'bathroom' => 2,
                'building_area' => 95,
                'land_area' => 160,
                'distance_to_center' => 7.0,
                'facility_score' => 3,
                'facility_details' => 'Dekat dengan akses tol Pasuruan (5 km)|Dekat dengan Pasar Pasuruan (1 km)|Dekat dengan RS Pasuruan (2 km)|Dekat dengan Pantai Pasuruan (6 km)|Dekat dengan Sekolah Unggulan (1.5 km)',
                'security_score' => 3,
                'security_details' => '1. Security 24 jam|2. One Gate System|3. Satpam 2 orang|4. CCTV 6 titik|5. Pos keamanan utama',
                'condition_score' => 76,
                'grade_score' => 72,
                'certificate_type' => 'SHGB',
                'property_type' => 'Rumah',
                'description' => 'Lokasi strategis dengan harga terjangkau.',
                'image' => 'https://picsum.photos/800/500?random=6',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 7 - Harmony Lamongan (Keamanan: SEDANG)
            // ============================================================
            [
                'title' => 'Harmony Lamongan Village',
                'location' => 'Malang',
                'price' => 254244311,
                'bedroom' => 3,
                'bathroom' => 2,
                'building_area' => 193,
                'land_area' => 250,
                'distance_to_center' => 9.0,
                'facility_score' => 3,
                'facility_details' => 'Dekat dengan akses tol Malang (6 km)|Dekat dengan Pasar Malang (2 km)|Dekat dengan RS Malang (3 km)|Dekat dengan wisata Jatim Park (8 km)|Dekat dengan Sekolah Unggulan (2.5 km)',
                'security_score' => 3,
                'security_details' => '1. Security 24 jam|2. One Gate System|3. Satpam 3 orang shift|4. CCTV 8 titik|5. Pos keamanan utama',
                'condition_score' => 70,
                'grade_score' => 68,
                'certificate_type' => 'SHGB',
                'property_type' => 'Rumah',
                'description' => 'Lingkungan asri dengan luas bangunan besar.',
                'image' => 'https://picsum.photos/800/500?random=7',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 8 - Harmony Residence (Keamanan: MINIMAL)
            // ============================================================
            [
                'title' => 'Harmony Residence',
                'location' => 'Malang',
                'price' => 251994421,
                'bedroom' => 2,
                'bathroom' => 1,
                'building_area' => 79,
                'land_area' => 100,
                'distance_to_center' => 8.5,
                'facility_score' => 3,
                'facility_details' => 'Dekat dengan Universitas Brawijaya (3 km)|Dekat dengan Universitas Negeri Malang (4 km)|Dekat dengan Alun-alun Malang (2 km)|Dekat dengan Sekolah Internasional (3 km)',
                'security_score' => 2,
                'security_details' => '1. Security 12 jam (06.00-18.00)|2. Satpam 1 orang|3. Portal sederhana|4. Keamanan berbasis RT/RW',
                'condition_score' => 65,
                'grade_score' => 60,
                'certificate_type' => 'Lainnya',
                'property_type' => 'Rumah',
                'description' => 'Hunian sederhana dengan harga terjangkau.',
                'image' => 'https://picsum.photos/800/500?random=8',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 9 - Grand Kahuripan (Keamanan: SEDANG PLUS)
            // ============================================================
            [
                'title' => 'Grand Kahuripan',
                'location' => 'Malang',
                'price' => 250034088,
                'bedroom' => 2,
                'bathroom' => 1,
                'building_area' => 61,
                'land_area' => 80,
                'distance_to_center' => 7.5,
                'facility_score' => 4,
                'facility_details' => 'Dekat dengan Mall Malang (2 km)|Dekat dengan RS Malang (1.5 km)|Dekat dengan Alun-alun Malang (1 km)|Dekat dengan wisata Jatim Park (5 km)|Dekat dengan Sekolah Unggulan (2 km)',
                'security_score' => 3,
                'security_details' => '1. Security 24 jam|2. One Gate System|3. Satpam 2 orang|4. CCTV 4 titik|5. Alarm terintegrasi',
                'condition_score' => 68,
                'grade_score' => 65,
                'certificate_type' => 'SHGB',
                'property_type' => 'Rumah',
                'description' => 'Lokasi strategis dekat dengan pusat kota.',
                'image' => 'https://picsum.photos/800/500?random=9',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 10 - Arava Residence (Keamanan: LENGKAP)
            // ============================================================
            [
                'title' => 'Arava Residence',
                'location' => 'Sidoarjo',
                'price' => 1033477175,
                'bedroom' => 5,
                'bathroom' => 2,
                'building_area' => 84,
                'land_area' => 150,
                'distance_to_center' => 4.0,
                'facility_score' => 4,
                'facility_details' => 'Dekat dengan akses tol Sidoarjo (1.5 km)|Dekat dengan Mall Sidoarjo (2 km)|Dekat dengan RS Sidoarjo (2 km)|Dekat dengan Pasar Tradisional (1 km)|Dekat dengan Alun-alun Sidoarjo (1.5 km)',
                'security_score' => 4,
                'security_details' => '1. Security 24 jam|2. One Gate System kartu akses|3. CCTV 16 titik|4. Satpam 4 orang|5. Patroli keliling|6. Alarm perumahan',
                'condition_score' => 73,
                'grade_score' => 85,
                'certificate_type' => 'SHM',
                'property_type' => 'Townhouse',
                'description' => 'Townhouse modern dengan desain minimalis.',
                'image' => 'https://picsum.photos/800/500?random=10',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 11 - Emerald Garden (Keamanan: HIGH TECH)
            // ============================================================
            [
                'title' => 'Emerald Garden Residence - Sidoarjo 7',
                'location' => 'Sidoarjo',
                'price' => 1586026027,
                'bedroom' => 5,
                'bathroom' => 2,
                'building_area' => 217,
                'land_area' => 141,
                'distance_to_center' => 4.5,
                'facility_score' => 4,
                'facility_details' => 'Dekat dengan akses tol Sidoarjo (2 km)|Dekat dengan Mall Sidoarjo (1.5 km)|Dekat dengan RS Sidoarjo (2.5 km)|Dekat dengan Pasar Tradisional (1 km)|Dekat dengan Alun-alun Sidoarjo (3 km)|Dekat dengan Sekolah Unggulan (1 km)',
                'security_score' => 4,
                'security_details' => '1. Security 24 jam|2. One Gate System face recognition|3. CCTV 20 titik|4. Satpam 5 orang|5. Patroli motor setiap 1.5 jam|6. Terintegrasi dengan polisi',
                'condition_score' => 91,
                'grade_score' => 88,
                'certificate_type' => 'SHM',
                'property_type' => 'Townhouse',
                'description' => 'Townhouse modern dengan fasilitas lengkap dan akses strategis.',
                'image' => 'https://picsum.photos/800/500?random=11',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 12 - Bukit Palma (Keamanan: STANDAR)
            // ============================================================
            [
                'title' => 'Bukit Palma Residence - Malang 10',
                'location' => 'Malang',
                'price' => 1810489974,
                'bedroom' => 3,
                'bathroom' => 2,
                'building_area' => 108,
                'land_area' => 185,
                'distance_to_center' => 7.0,
                'facility_score' => 3,
                'facility_details' => 'Dekat dengan akses tol Malang (4 km)|Dekat dengan Mall Malang (3 km)|Dekat dengan RS Malang (3.5 km)|Dekat dengan Universitas Brawijaya (5 km)|Dekat dengan Sekolah Internasional (4 km)|Dekat dengan wisata Jatim Park (7 km)',
                'security_score' => 3,
                'security_details' => '1. Security 24 jam|2. One Gate System|3. Satpam 2 orang shift|4. CCTV 8 titik|5. Pos keamanan utama dan belakang',
                'condition_score' => 76,
                'grade_score' => 72,
                'certificate_type' => 'SHGB',
                'property_type' => 'Cluster',
                'description' => 'Cluster eksklusif dengan view pegunungan dan udara sejuk.',
                'image' => 'https://picsum.photos/800/500?random=12',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 13 - Grand Kediri (Keamanan: PREMIUM)
            // ============================================================
            [
                'title' => 'Grand Kediri Residence - Kediri 7',
                'location' => 'Kediri',
                'price' => 1947705014,
                'bedroom' => 5,
                'bathroom' => 2,
                'building_area' => 209,
                'land_area' => 299,
                'distance_to_center' => 6.0,
                'facility_score' => 4,
                'facility_details' => 'Dekat dengan akses tol Kediri (3 km)|Dekat dengan Pasar Kediri (1.5 km)|Dekat dengan RS Kediri (2 km)|Dekat dengan Sekolah Unggulan (1 km)|Dekat dengan Alun-alun Kediri (2.5 km)|Dekat dengan wisata Gunung Kelud (10 km)',
                'security_score' => 4,
                'security_details' => '1. Security 24 jam|2. One Gate System kartu RFID|3. CCTV 14 titik|4. Satpam 4 orang|5. Patroli keliling|6. Alarm cluster',
                'condition_score' => 98,
                'grade_score' => 95,
                'certificate_type' => 'SHGB',
                'property_type' => 'Cluster',
                'description' => 'Cluster premium dengan view gunung dan udara sejuk.',
                'image' => 'https://picsum.photos/800/500?random=13',
                'is_active' => true
            ],
        ];

        foreach ($properties as $property) {
            Property::updateOrCreate(
                ['title' => $property['title']],
                $property
            );
        }
    }
}