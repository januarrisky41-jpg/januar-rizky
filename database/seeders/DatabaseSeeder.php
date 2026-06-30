<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Property;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama
        DB::table('favorites')->delete();
        DB::table('properties')->delete();

        $cities = [
            'Surabaya',
            'Sidoarjo',
            'Gresik',
            'Malang',
            'Pasuruan',
            'Mojokerto',
            'Kediri',
            'Jombang',
            'Lamongan',
            'Madiun'
        ];

        $propertyNames = [
            'Grand Emerald Residence',
            'Royal Park Residence',
            'Green Lake City',
            'The Mansion Residence',
            'Citra Harmoni Residence',
            'Golden Hill Residence',
            'Bukit Palma Residence',
            'Puri Surya Jaya',
            'The Royal Living',
            'Emerald Garden Residence',
            'Taman Cendana Residence',
            'Green Village Estate',
            'Grand Kahuripan',
            'Citra Garden Residence',
            'Safira Residence',
            'Suncity Living',
            'Permata Residence',
            'Golden Residence',
            'Royal Green Estate',
            'The Green Residence',
        ];

        // DESKRIPSI YANG LEBIH VARIATIF DAN PROFESIONAL
        $descriptions = [
            'Kawasan elit dengan akses langsung ke pusat bisnis dan perbelanjaan. Dilengkapi dengan fasilitas clubhouse, kolam renang, dan taman bermain anak yang luas.',
            'Hunian eksklusif dengan konsep modern minimalis. Terletak di kawasan strategis dengan akses mudah ke tol, stasiun kereta, dan pusat perbelanjaan terdekat.',
            'Perumahan dengan konsep resort living yang menawarkan ketenangan dan kenyamanan. Didukung dengan keamanan 24 jam dan area hijau yang asri.',
            'Lokasi premium di jantung kota dengan aksesibilitas tinggi. Dekat dengan sekolah internasional, rumah sakit, dan berbagai fasilitas umum lainnya.',
            'Dirancang untuk keluarga modern dengan konsep terbuka dan pencahayaan alami. Lingkungan yang aman dan nyaman dengan akses ke berbagai fasilitas publik.',
            'Perpaduan sempurna antara kenyamanan dan kemewahan. Terletak di area dengan view pegunungan dan udara segar, cocok untuk gaya hidup sehat.',
            'Kompleks perumahan dengan konsep smart living yang terintegrasi dengan teknologi modern. Dilengkapi dengan sistem keamanan canggih dan lingkungan ramah lingkungan.',
            'Berlokasi di kawasan berkembang dengan potensi investasi tinggi. Dekat dengan pusat pemerintahan, kawasan bisnis, dan berbagai fasilitas pendukung.',
            'Hunian dengan arsitektur kontemporer dan desain interior fungsional. Menawarkan privasi maksimal dengan lingkungan yang tenang dan asri.',
            'Perumahan terpadu dengan berbagai fasilitas seperti sekolah, klinik, dan pusat perbelanjaan. Akses mudah ke berbagai titik strategis di kota.',
        ];

        // GAMBAR RUMAH
        $images = [
            'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800',
            'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=800',
            'https://images.unsplash.com/photo-1494526585095-c41746248156?w=800',
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800',
            'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800',
            'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800',
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=800',
            'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?w=800',
            'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800',
            'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=800',
            'https://images.unsplash.com/photo-1574362848149-11496d93a7c7?w=800',
        ];

        $propertyTypes = ['Rumah', 'Cluster', 'Townhouse', 'Villa'];

        foreach ($cities as $city) {
            for ($i = 1; $i <= 10; $i++) {
                $randomName = $propertyNames[array_rand($propertyNames)];
                $randomDesc = $descriptions[array_rand($descriptions)];

                Property::create([
                    'title' => $randomName . ' - ' . $city . ' ' . $i,
                    'location' => $city,
                    'property_type' => $propertyTypes[array_rand($propertyTypes)],
                    'price' => rand(250000000, 2500000000),
                    'bedroom' => rand(2, 5),
                    'bathroom' => rand(1, 4),
                    'building_area' => rand(45, 250),
                    'land_area' => rand(80, 350),
                    'distance_to_center' => rand(1, 15),
                    'facility_score' => rand(3, 5),
                    'facility_details' => 'Dekat dengan akses tol|Dekat dengan pusat perbelanjaan|Dekat dengan rumah sakit|Dekat dengan sekolah unggulan',
                    'security_score' => rand(3, 5),
                    'security_details' => 'Security 24 jam|One Gate System|CCTV|Satpam profesional',
                    'condition_score' => rand(65, 100),
                    'grade_score' => rand(60, 95),
                    'certificate_type' => ['SHM', 'SHGB', 'Lainnya'][array_rand(['SHM', 'SHGB', 'Lainnya'])],
                    'description' => $randomDesc,
                    'image' => $images[array_rand($images)],
                    'is_active' => true
                ]);
            }
        }

        $this->call(PropertySeeder::class);
    }
}