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
            // PROPERTI 1 - Royal K Residence
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
                'description' => 'Hunian eksklusif dengan konsep modern minimalis di kawasan elit Surabaya. Terletak strategis dekat dengan pusat bisnis, mall, dan akses tol. Dilengkapi dengan sistem keamanan canggih dan lingkungan yang asri.',
                'image' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 2 - Ijo Lake
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
                'description' => 'Perumahan asri dengan view danau yang memukau di kawasan Surabaya Barat. Lingkungan nyaman dan tenang, cocok untuk keluarga muda dengan akses mudah ke berbagai fasilitas umum.',
                'image' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=800',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 3 - Almond Living
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
                'description' => 'Perumahan premium dengan desain arsitektur modern dan fasilitas super lengkap. Berada di kawasan strategis Sidoarjo dengan akses cepat ke tol, pusat perbelanjaan, dan kawasan bisnis.',
                'image' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=800',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 4 - Green Jombang Residence
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
                'description' => 'Hunian asri dengan konsep green living di kawasan Mojokerto. Lokasi strategis dekat dengan tol, area wisata sejarah, dan berbagai fasilitas publik. Cocok untuk keluarga besar.',
                'image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800',
                'is_active' => true
            ],

            // ============================================================
            // PROPERTI 5 - Emerald Estate
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
                'description' => 'Perumahan eksklusif dengan konsep estate modern di Gresik. Dilengkapi dengan keamanan super ketat dan fasilitas premium. Akses cepat ke kawasan industri dan pusat perbelanjaan.',
                'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800',
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