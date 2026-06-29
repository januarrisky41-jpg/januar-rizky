<?php

namespace App\Http\Controllers;

use App\Models\Property;

class RecommendationController extends Controller
{
    public function index()
    {
        $budget = session('estimated_property_price');

        if ($budget) {
            $properties = Property::where('price', '<=', $budget)->get();
        } else {
            $properties = Property::all();
        }

        if ($properties->isEmpty()) {
            return view('recommendation.index', [
                'properties' => collect(),
                'topProperties' => collect(),
                'budget' => $budget
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | NILAI MIN DAN MAX UNTUK NORMALISASI
        |--------------------------------------------------------------------------
        */

        $minPrice = $properties->min('price') ?: 0;
        $maxPrice = $properties->max('price') ?: 1;
        $minDistance = $properties->min('distance_to_center') ?: 0;
        $maxDistance = $properties->max('distance_to_center') ?: 1;
        $maxArea = $properties->max('building_area') ?: 1;
        $maxLand = $properties->max('land_area') ?: 1;
        $maxFacility = $properties->max('facility_score') ?: 1;
        $maxSecurity = $properties->max('security_score') ?: 1;
        $maxBedroom = $properties->max('bedroom') ?: 1;
        $maxCondition = $properties->max('condition_score') ?: 1;
        $maxCertificate = 5; // SHM = 5, SHGB = 3, Lainnya = 1
        $maxInvestment = $properties->max('investment_score') ?: 1;

        /*
        |--------------------------------------------------------------------------
        | BOBOT KRITERIA SAW (10 KRITERIA)
        |--------------------------------------------------------------------------
        */

        $weights = [
            'price'              => 0.20,  // 20% - Cost
            'distance_to_center' => 0.18,  // 18% - Cost
            'building_area'      => 0.12,  // 12% - Benefit
            'land_area'          => 0.10,  // 10% - Benefit
            'facility_score'     => 0.10,  // 10% - Benefit
            'security_score'     => 0.08,  // 8%  - Benefit
            'bedroom'            => 0.08,  // 8%  - Benefit
            'condition_score'    => 0.06,  // 6%  - Benefit
            'certificate_score'  => 0.04,  // 4%  - Benefit
            'investment_score'   => 0.04,  // 4%  - Benefit
        ];

        /*
        |--------------------------------------------------------------------------
        | PERHITUNGAN REKOMENDASI
        |--------------------------------------------------------------------------
        */

        foreach ($properties as $property) {
            /*
            |--------------------------------------------------------------------------
            | 1. HARGA (COST) - Semakin rendah semakin baik
            |--------------------------------------------------------------------------
            */

            if ($maxPrice > $minPrice) {
                $priceScore = 1 - (($property->price - $minPrice) / ($maxPrice - $minPrice));
            } else {
                $priceScore = 1;
            }
            $priceScore = max(0, min(1, $priceScore));

            /*
            |--------------------------------------------------------------------------
            | 2. JARAK (COST) - Semakin dekat semakin baik
            |--------------------------------------------------------------------------
            */

            $distance = $property->distance_to_center ?? 0;
            if ($maxDistance > $minDistance) {
                $distanceScore = 1 - (($distance - $minDistance) / ($maxDistance - $minDistance));
            } else {
                $distanceScore = 1;
            }
            $distanceScore = max(0, min(1, $distanceScore));

            /*
            |--------------------------------------------------------------------------
            | 3. LUAS BANGUNAN (BENEFIT)
            |--------------------------------------------------------------------------
            */

            $areaScore = $maxArea > 0 ? $property->building_area / $maxArea : 1;
            $areaScore = max(0, min(1, $areaScore));

            /*
            |--------------------------------------------------------------------------
            | 4. LUAS TANAH (BENEFIT)
            |--------------------------------------------------------------------------
            */

            $landScore = $maxLand > 0 ? ($property->land_area ?? 0) / $maxLand : 1;
            $landScore = max(0, min(1, $landScore));

            /*
            |--------------------------------------------------------------------------
            | 5. FASILITAS UMUM (BENEFIT)
            |--------------------------------------------------------------------------
            */

            $facilityScore = $maxFacility > 0 ? ($property->facility_score ?? 3) / $maxFacility : 1;
            $facilityScore = max(0, min(1, $facilityScore));

            /*
            |--------------------------------------------------------------------------
            | 6. KEAMANAN LINGKUNGAN (BENEFIT)
            |--------------------------------------------------------------------------
            */

            $securityScore = $maxSecurity > 0 ? ($property->security_score ?? 3) / $maxSecurity : 1;
            $securityScore = max(0, min(1, $securityScore));

            /*
            |--------------------------------------------------------------------------
            | 7. JUMLAH KAMAR TIDUR (BENEFIT)
            |--------------------------------------------------------------------------
            */

            $bedroomScore = $maxBedroom > 0 ? $property->bedroom / $maxBedroom : 1;
            $bedroomScore = max(0, min(1, $bedroomScore));

            /*
            |--------------------------------------------------------------------------
            | 8. KONDISI FISIK BANGUNAN (BENEFIT)
            |--------------------------------------------------------------------------
            */

            $conditionScore = $maxCondition > 0 ? $property->condition_score / $maxCondition : 1;
            $conditionScore = max(0, min(1, $conditionScore));

            /*
            |--------------------------------------------------------------------------
            | 9. SERTIFIKAT TANAH (BENEFIT)
            |--------------------------------------------------------------------------
            */

            $certificateScore = $this->getCertificateScore($property->certificate_type) / $maxCertificate;
            $certificateScore = max(0, min(1, $certificateScore));

            /*
            |--------------------------------------------------------------------------
            | 10. POTENSI INVESTASI (BENEFIT)
            |--------------------------------------------------------------------------
            */

            $investmentScore = $maxInvestment > 0 ? ($property->investment_score ?? 3) / $maxInvestment : 1;
            $investmentScore = max(0, min(1, $investmentScore));

            /*
            |--------------------------------------------------------------------------
            | SKOR AKHIR
            |--------------------------------------------------------------------------
            */

            $property->recommendation_score = round(
                ($priceScore * $weights['price'])
                + ($distanceScore * $weights['distance_to_center'])
                + ($areaScore * $weights['building_area'])
                + ($landScore * $weights['land_area'])
                + ($facilityScore * $weights['facility_score'])
                + ($securityScore * $weights['security_score'])
                + ($bedroomScore * $weights['bedroom'])
                + ($conditionScore * $weights['condition_score'])
                + ($certificateScore * $weights['certificate_score'])
                + ($investmentScore * $weights['investment_score']),
                4
            );

            $property->percentage = round($property->recommendation_score * 100);

            /*
            |--------------------------------------------------------------------------
            | STATUS REKOMENDASI
            |--------------------------------------------------------------------------
            */

            if ($property->percentage >= 80) {
                $property->recommendation_status = 'Sangat Direkomendasikan';
                $property->recommendation_class = 'success';
                $property->rating = 5;
                $property->stars = '⭐⭐⭐⭐⭐';
            } elseif ($property->percentage >= 65) {
                $property->recommendation_status = 'Direkomendasikan';
                $property->recommendation_class = 'primary';
                $property->rating = 4;
                $property->stars = '⭐⭐⭐⭐';
            } elseif ($property->percentage >= 50) {
                $property->recommendation_status = 'Cukup Direkomendasikan';
                $property->recommendation_class = 'warning';
                $property->rating = 3;
                $property->stars = '⭐⭐⭐';
            } elseif ($property->percentage >= 35) {
                $property->recommendation_status = 'Perlu Dipertimbangkan';
                $property->recommendation_class = 'secondary';
                $property->rating = 2;
                $property->stars = '⭐⭐';
            } else {
                $property->recommendation_status = 'Kurang Direkomendasikan';
                $property->recommendation_class = 'danger';
                $property->rating = 1;
                $property->stars = '⭐';
            }

            /*
            |--------------------------------------------------------------------------
            | NORMALIZED SCORES (UNTUK COMPARE)
            |--------------------------------------------------------------------------
            */

            $property->normalized_scores = [
                'price'              => round($priceScore, 4),
                'distance_to_center' => round($distanceScore, 4),
                'building_area'      => round($areaScore, 4),
                'land_area'          => round($landScore, 4),
                'facility_score'     => round($facilityScore, 4),
                'security_score'     => round($securityScore, 4),
                'bedroom'            => round($bedroomScore, 4),
                'condition_score'    => round($conditionScore, 4),
                'certificate_score'  => round($certificateScore, 4),
                'investment_score'   => round($investmentScore, 4),
            ];
        }

        $properties = $properties->sortByDesc('recommendation_score');
        $topProperties = $properties->take(10);

        return view(
            'recommendation.index',
            compact('properties', 'topProperties', 'budget')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI BANTU: SKOR SERTIFIKAT
    |--------------------------------------------------------------------------
    */

    private function getCertificateScore(?string $certificateType): int
    {
        return match ($certificateType) {
            'SHM'   => 5,
            'SHGB'  => 3,
            default => 1,
        };
    }
}