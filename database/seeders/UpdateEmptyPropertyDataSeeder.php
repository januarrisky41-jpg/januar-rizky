<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class UpdateEmptyPropertyDataSeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::all();

        // Data fasilitas dengan variasi
        $facilityOptions = [
            'Surabaya' => [
                'Dekat dengan akses tol Surabaya-Mojokerto',
                'Dekat dengan Mall Pakuwon',
                'Dekat dengan Mall Tunjungan',
                'Dekat dengan RS Dr. Soetomo',
                'Dekat dengan RS Darmo',
                'Dekat dengan Universitas Airlangga',
                'Dekat dengan ITS Surabaya',
                'Dekat dengan Sekolah Internasional',
                'Dekat dengan Pasar Atom',
                'Dekat dengan Taman Bungkul',
            ],
            'Sidoarjo' => [
                'Dekat dengan akses tol Sidoarjo',
                'Dekat dengan Mall Sidoarjo',
                'Dekat dengan RS Sidoarjo',
                'Dekat dengan Pasar Tradisional',
                'Dekat dengan Sekolah Unggulan',
                'Dekat dengan Pusat Oleh-oleh',
                'Dekat dengan Alun-alun Sidoarjo',
            ],
            'Malang' => [
                'Dekat dengan akses tol Malang',
                'Dekat dengan Mall Malang',
                'Dekat dengan RS Malang',
                'Dekat dengan Universitas Brawijaya',
                'Dekat dengan Universitas Negeri Malang',
                'Dekat dengan Sekolah Internasional',
                'Dekat dengan Alun-alun Malang',
                'Dekat dengan wisata Jatim Park',
            ],
            'Gresik' => [
                'Dekat dengan akses tol Gresik',
                'Dekat dengan Mall Gresik',
                'Dekat dengan RS Gresik',
                'Dekat dengan Kawasan Industri',
                'Dekat dengan Sekolah Unggulan',
                'Dekat dengan Pasar Gresik',
            ],
            'Pasuruan' => [
                'Dekat dengan akses tol Pasuruan',
                'Dekat dengan Pasar Pasuruan',
                'Dekat dengan RS Pasuruan',
                'Dekat dengan Sekolah Unggulan',
                'Dekat dengan Pantai Pasuruan',
            ],
            'Mojokerto' => [
                'Dekat dengan akses tol Mojokerto',
                'Dekat dengan Pasar Mojokerto',
                'Dekat dengan RS Mojokerto',
                'Dekat dengan Sekolah Unggulan',
                'Dekat dengan Candi Majapahit',
            ],
            'Kediri' => [
                'Dekat dengan akses tol Kediri',
                'Dekat dengan Pasar Kediri',
                'Dekat dengan RS Kediri',
                'Dekat dengan Sekolah Unggulan',
                'Dekat dengan Alun-alun Kediri',
                'Dekat dengan wisata Gunung Kelud',
            ],
            'Jombang' => [
                'Dekat dengan akses tol Jombang',
                'Dekat dengan Pasar Jombang',
                'Dekat dengan RS Jombang',
                'Dekat dengan Sekolah Unggulan',
                'Dekat dengan wisata Trowulan',
            ],
            'Lamongan' => [
                'Dekat dengan akses tol Lamongan',
                'Dekat dengan Pasar Lamongan',
                'Dekat dengan RS Lamongan',
                'Dekat dengan Sekolah Unggulan',
                'Dekat dengan wisata Bahari Lamongan',
            ],
            'Madiun' => [
                'Dekat dengan akses tol Madiun',
                'Dekat dengan Pasar Madiun',
                'Dekat dengan RS Madiun',
                'Dekat dengan Sekolah Unggulan',
                'Dekat dengan Alun-alun Madiun',
            ],
        ];

        // Data keamanan dengan variasi
        $securityOptions = [
            5 => [
                'Sistem keamanan 24 jam',
                'One Gate System',
                'CCTV di setiap sudut',
                'Satpam profesional 24 jam',
                'Akses kartu elektronik',
                'Patroli keamanan rutin',
            ],
            4 => [
                'Sistem keamanan 24 jam',
                'One Gate System',
                'CCTV di area utama',
                'Satpam profesional',
                'Patroli keamanan rutin',
            ],
            3 => [
                'Sistem keamanan 24 jam',
                'One Gate System',
                'Satpam profesional',
            ],
            2 => [
                'Sistem keamanan 12 jam',
                'Satpam profesional',
            ],
            1 => [
                'Keamanan lingkungan terbatas',
            ],
        ];

        foreach ($properties as $property) {
            $updates = [];

            // Isi facility_details dengan variasi
            if (is_null($property->facility_details)) {
                $location = $property->location ?? 'Surabaya';
                $options = $facilityOptions[$location] ?? $facilityOptions['Surabaya'];
                
                // Ambil 3-5 item random
                shuffle($options);
                $selected = array_slice($options, 0, rand(3, 5));
                $updates['facility_details'] = implode('|', $selected);
            }

            // Isi security_details dengan variasi
            if (is_null($property->security_details)) {
                $score = $property->security_score ?? 3;
                $options = $securityOptions[$score] ?? $securityOptions[3];
                
                // Ambil 3-4 item random
                shuffle($options);
                $selected = array_slice($options, 0, rand(3, 4));
                $updates['security_details'] = implode('|', $selected);
            }

            // Isi land_area
            if (is_null($property->land_area)) {
                $updates['land_area'] = rand(80, 350);
            }

            // Isi distance_to_center
            if (is_null($property->distance_to_center)) {
                $updates['distance_to_center'] = rand(1, 15);
            }

            // Isi facility_score
            if (is_null($property->facility_score)) {
                $updates['facility_score'] = rand(3, 5);
            }

            // Isi security_score
            if (is_null($property->security_score)) {
                $updates['security_score'] = rand(3, 5);
            }

            // Isi certificate_type
            if (is_null($property->certificate_type)) {
                $updates['certificate_type'] = ['SHM', 'SHGB', 'Lainnya'][array_rand(['SHM', 'SHGB', 'Lainnya'])];
            }

            if (!empty($updates)) {
                $property->update($updates);
                $this->command->info("✅ Updated: {$property->title}");
            }
        }

        $this->command->info('🎉 All empty fields have been updated!');
    }
}