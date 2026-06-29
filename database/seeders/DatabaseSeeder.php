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

            'Grand Gresik Estate',
            'Bukit Gresik Residence',
            'Green Valley Residence',
            'Royal Gresik Living',
            'Emerald Village',
            'Harmony Residence',
            'Golden Village',
            'The Harmony Living',
            'Grand Harmony Residence',
            'Cendana Residence',

            'Malang Hills Residence',
            'Green Mountain Estate',
            'Royal Malang Residence',
            'The Highland Living',
            'Golden Valley Residence',
            'Araya Residence',
            'Permata Hills',
            'Emerald Park Residence',
            'The Green Park',
            'Harmony Hills',

            'Mojokerto Green Village',
            'Royal Mojokerto Residence',
            'Permata Mojokerto',
            'Golden Village Estate',
            'The Green Living',
            'Grand Village Residence',
            'Harmony Estate',
            'Emerald Estate',
            'The Royal Estate',
            'Cendana Village',

            'Kediri Garden Estate',
            'Grand Kediri Residence',
            'Royal Kediri Living',
            'Golden Kediri Residence',
            'Harmony Kediri Estate',

            'Jombang City Residence',
            'Grand Jombang Living',
            'Royal Jombang Estate',
            'Green Jombang Residence',
            'Harmony Village',

            'Lamongan Green Residence',
            'Grand Lamongan Estate',
            'Royal Lamongan Living',
            'Golden Lamongan Residence',
            'Harmony Lamongan Village',

            'Madiun Green Estate',
            'Grand Madiun Residence',
            'Royal Madiun Living',
            'Golden Madiun Residence',
            'Harmony Madiun Estate'
        ];

        $images = [

            'https://images.unsplash.com/photo-1568605114967-8130f3a36994',

            'https://images.unsplash.com/photo-1570129477492-45c003edd2be',

            'https://images.unsplash.com/photo-1494526585095-c41746248156',

            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750',

            'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688'
        ];

        foreach ($cities as $city) {

            for ($i = 1; $i <= 10; $i++) {

                $randomName =
                    $propertyNames[
                        array_rand($propertyNames)
                    ];

                Property::create([

                    'title' =>
                        $randomName .
                        ' - ' .
                        $city .
                        ' ' .
                        $i,

                    'location' => $city,

                    'property_type' => [
                        'Rumah',
                        'Cluster',
                        'Townhouse',
                        'Villa'
                    ][array_rand([
                        'Rumah',
                        'Cluster',
                        'Townhouse',
                        'Villa'
                    ])],

                    'price' => rand(
                        250000000,
                        2500000000
                    ),

                    'bedroom' => rand(2, 5),

                    'bathroom' => rand(1, 4),

                    'building_area' => rand(45, 250),

                    'condition_score' => rand(70, 100),

                    'grade_score' => rand(70, 100),

                    'description' =>
                        $randomName .
                        ' merupakan hunian modern di kawasan ' .
                        $city .
                        ' dengan akses strategis, fasilitas lengkap, dan lingkungan yang nyaman untuk keluarga.',

                    'image' =>
                        $images[
                            array_rand($images)
                        ]
                ]);
            }
        }
    }
}