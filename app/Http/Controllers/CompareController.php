<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        $propertyA = null;
        $propertyB = null;

        $scoreA = 0;
        $scoreB = 0;

        $percentageA = 0;
        $percentageB = 0;

        $advantagesA = [];
        $advantagesB = [];

        $insightA = '';
        $insightB = '';

        if ($request->filled('property_a') && $request->filled('property_b')) {

            $propertyA = Property::find($request->property_a);
            $propertyB = Property::find($request->property_b);

            if ($propertyA && $propertyB) {

                /*
                |--------------------------------------------------------------------------
                | BOBOT KRITERIA SAW (10 KRITERIA)
                |--------------------------------------------------------------------------
                */

                $weights = [
                    'price'              => 0.20,
                    'distance_to_center' => 0.18,
                    'building_area'      => 0.12,
                    'land_area'          => 0.10,
                    'facility_score'     => 0.10,
                    'security_score'     => 0.08,
                    'bedroom'            => 0.08,
                    'condition_score'    => 0.06,
                    'certificate_score'  => 0.04,
                    'investment_score'   => 0.04,
                ];

                /*
                |--------------------------------------------------------------------------
                | NILAI MIN MAX
                |--------------------------------------------------------------------------
                */

                $minPrice = min($propertyA->price, $propertyB->price);
                $maxPrice = max($propertyA->price, $propertyB->price);

                $minDistance = min($propertyA->distance_to_center ?? 10, $propertyB->distance_to_center ?? 10);
                $maxDistance = max($propertyA->distance_to_center ?? 10, $propertyB->distance_to_center ?? 10);

                $maxArea = max($propertyA->building_area, $propertyB->building_area);
                $maxLand = max($propertyA->land_area ?? 1, $propertyB->land_area ?? 1);
                $maxFacility = max($propertyA->facility_score ?? 3, $propertyB->facility_score ?? 3);
                $maxSecurity = max($propertyA->security_score ?? 3, $propertyB->security_score ?? 3);
                $maxBedroom = max($propertyA->bedroom, $propertyB->bedroom);
                $maxCondition = max($propertyA->condition_score, $propertyB->condition_score);
                $maxCertificate = 5;
                $maxInvestment = max($propertyA->investment_score ?? 3, $propertyB->investment_score ?? 3);

                /*
                |--------------------------------------------------------------------------
                | NORMALISASI PROPERTY A
                |--------------------------------------------------------------------------
                */

                // 1. Harga (Cost)
                $priceScoreA = $maxPrice > $minPrice ? 1 - (($propertyA->price - $minPrice) / ($maxPrice - $minPrice)) : 1;
                $priceScoreA = max(0, min(1, $priceScoreA));

                // 2. Jarak (Cost)
                $distanceScoreA = $maxDistance > $minDistance ? 1 - (($propertyA->distance_to_center - $minDistance) / ($maxDistance - $minDistance)) : 1;
                $distanceScoreA = max(0, min(1, $distanceScoreA));

                // 3. Luas Bangunan (Benefit)
                $areaScoreA = $maxArea > 0 ? $propertyA->building_area / $maxArea : 1;
                $areaScoreA = max(0, min(1, $areaScoreA));

                // 4. Luas Tanah (Benefit)
                $landScoreA = $maxLand > 0 ? ($propertyA->land_area ?? 0) / $maxLand : 1;
                $landScoreA = max(0, min(1, $landScoreA));

                // 5. Fasilitas (Benefit)
                $facilityScoreA = $maxFacility > 0 ? ($propertyA->facility_score ?? 3) / $maxFacility : 1;
                $facilityScoreA = max(0, min(1, $facilityScoreA));

                // 6. Keamanan (Benefit)
                $securityScoreA = $maxSecurity > 0 ? ($propertyA->security_score ?? 3) / $maxSecurity : 1;
                $securityScoreA = max(0, min(1, $securityScoreA));

                // 7. Kamar Tidur (Benefit)
                $bedroomScoreA = $maxBedroom > 0 ? $propertyA->bedroom / $maxBedroom : 1;
                $bedroomScoreA = max(0, min(1, $bedroomScoreA));

                // 8. Kondisi Bangunan (Benefit)
                $conditionScoreA = $maxCondition > 0 ? $propertyA->condition_score / $maxCondition : 1;
                $conditionScoreA = max(0, min(1, $conditionScoreA));

                // 9. Sertifikat (Benefit)
                $certificateScoreA = $this->getCertificateScore($propertyA->certificate_type) / $maxCertificate;
                $certificateScoreA = max(0, min(1, $certificateScoreA));

                // 10. Investasi (Benefit)
                $investmentScoreA = $maxInvestment > 0 ? ($propertyA->investment_score ?? 3) / $maxInvestment : 1;
                $investmentScoreA = max(0, min(1, $investmentScoreA));

                /*
                |--------------------------------------------------------------------------
                | NORMALISASI PROPERTY B
                |--------------------------------------------------------------------------
                */

                $priceScoreB = $maxPrice > $minPrice ? 1 - (($propertyB->price - $minPrice) / ($maxPrice - $minPrice)) : 1;
                $priceScoreB = max(0, min(1, $priceScoreB));

                $distanceScoreB = $maxDistance > $minDistance ? 1 - (($propertyB->distance_to_center - $minDistance) / ($maxDistance - $minDistance)) : 1;
                $distanceScoreB = max(0, min(1, $distanceScoreB));

                $areaScoreB = $maxArea > 0 ? $propertyB->building_area / $maxArea : 1;
                $areaScoreB = max(0, min(1, $areaScoreB));

                $landScoreB = $maxLand > 0 ? ($propertyB->land_area ?? 0) / $maxLand : 1;
                $landScoreB = max(0, min(1, $landScoreB));

                $facilityScoreB = $maxFacility > 0 ? ($propertyB->facility_score ?? 3) / $maxFacility : 1;
                $facilityScoreB = max(0, min(1, $facilityScoreB));

                $securityScoreB = $maxSecurity > 0 ? ($propertyB->security_score ?? 3) / $maxSecurity : 1;
                $securityScoreB = max(0, min(1, $securityScoreB));

                $bedroomScoreB = $maxBedroom > 0 ? $propertyB->bedroom / $maxBedroom : 1;
                $bedroomScoreB = max(0, min(1, $bedroomScoreB));

                $conditionScoreB = $maxCondition > 0 ? $propertyB->condition_score / $maxCondition : 1;
                $conditionScoreB = max(0, min(1, $conditionScoreB));

                $certificateScoreB = $this->getCertificateScore($propertyB->certificate_type) / $maxCertificate;
                $certificateScoreB = max(0, min(1, $certificateScoreB));

                $investmentScoreB = $maxInvestment > 0 ? ($propertyB->investment_score ?? 3) / $maxInvestment : 1;
                $investmentScoreB = max(0, min(1, $investmentScoreB));

                /*
                |--------------------------------------------------------------------------
                | SKOR AKHIR
                |--------------------------------------------------------------------------
                */

                $scoreA = round(
                    ($priceScoreA * $weights['price'])
                    + ($distanceScoreA * $weights['distance_to_center'])
                    + ($areaScoreA * $weights['building_area'])
                    + ($landScoreA * $weights['land_area'])
                    + ($facilityScoreA * $weights['facility_score'])
                    + ($securityScoreA * $weights['security_score'])
                    + ($bedroomScoreA * $weights['bedroom'])
                    + ($conditionScoreA * $weights['condition_score'])
                    + ($certificateScoreA * $weights['certificate_score'])
                    + ($investmentScoreA * $weights['investment_score']),
                    4
                );

                $scoreB = round(
                    ($priceScoreB * $weights['price'])
                    + ($distanceScoreB * $weights['distance_to_center'])
                    + ($areaScoreB * $weights['building_area'])
                    + ($landScoreB * $weights['land_area'])
                    + ($facilityScoreB * $weights['facility_score'])
                    + ($securityScoreB * $weights['security_score'])
                    + ($bedroomScoreB * $weights['bedroom'])
                    + ($conditionScoreB * $weights['condition_score'])
                    + ($certificateScoreB * $weights['certificate_score'])
                    + ($investmentScoreB * $weights['investment_score']),
                    4
                );

                $percentageA = round($scoreA * 100);
                $percentageB = round($scoreB * 100);

                /*
                |--------------------------------------------------------------------------
                | KEUNGGULAN PROPERTY A
                |--------------------------------------------------------------------------
                */

                if ($propertyA->price < $propertyB->price)
                    $advantagesA[] = 'Harga lebih ekonomis';

                if (($propertyA->distance_to_center ?? 10) < ($propertyB->distance_to_center ?? 10))
                    $advantagesA[] = 'Lokasi lebih strategis';

                if ($propertyA->building_area > $propertyB->building_area)
                    $advantagesA[] = 'Luas bangunan lebih besar';

                if (($propertyA->land_area ?? 0) > ($propertyB->land_area ?? 0))
                    $advantagesA[] = 'Luas tanah lebih luas';

                if (($propertyA->facility_score ?? 0) > ($propertyB->facility_score ?? 0))
                    $advantagesA[] = 'Fasilitas umum lebih lengkap';

                if (($propertyA->security_score ?? 0) > ($propertyB->security_score ?? 0))
                    $advantagesA[] = 'Keamanan lingkungan lebih baik';

                if ($propertyA->bedroom > $propertyB->bedroom)
                    $advantagesA[] = 'Jumlah kamar tidur lebih banyak';

                if ($propertyA->bathroom > $propertyB->bathroom)
                    $advantagesA[] = 'Jumlah kamar mandi lebih banyak';

                if ($propertyA->condition_score > $propertyB->condition_score)
                    $advantagesA[] = 'Kondisi bangunan lebih baik';

                if ($this->getCertificateScore($propertyA->certificate_type) > $this->getCertificateScore($propertyB->certificate_type))
                    $advantagesA[] = 'Sertifikat tanah lebih jelas';

                if (($propertyA->investment_score ?? 0) > ($propertyB->investment_score ?? 0))
                    $advantagesA[] = 'Potensi investasi lebih tinggi';

                /*
                |--------------------------------------------------------------------------
                | KEUNGGULAN PROPERTY B
                |--------------------------------------------------------------------------
                */

                if ($propertyB->price < $propertyA->price)
                    $advantagesB[] = 'Harga lebih ekonomis';

                if (($propertyB->distance_to_center ?? 10) < ($propertyA->distance_to_center ?? 10))
                    $advantagesB[] = 'Lokasi lebih strategis';

                if ($propertyB->building_area > $propertyA->building_area)
                    $advantagesB[] = 'Luas bangunan lebih besar';

                if (($propertyB->land_area ?? 0) > ($propertyA->land_area ?? 0))
                    $advantagesB[] = 'Luas tanah lebih luas';

                if (($propertyB->facility_score ?? 0) > ($propertyA->facility_score ?? 0))
                    $advantagesB[] = 'Fasilitas umum lebih lengkap';

                if (($propertyB->security_score ?? 0) > ($propertyA->security_score ?? 0))
                    $advantagesB[] = 'Keamanan lingkungan lebih baik';

                if ($propertyB->bedroom > $propertyA->bedroom)
                    $advantagesB[] = 'Jumlah kamar tidur lebih banyak';

                if ($propertyB->bathroom > $propertyA->bathroom)
                    $advantagesB[] = 'Jumlah kamar mandi lebih banyak';

                if ($propertyB->condition_score > $propertyA->condition_score)
                    $advantagesB[] = 'Kondisi bangunan lebih baik';

                if ($this->getCertificateScore($propertyB->certificate_type) > $this->getCertificateScore($propertyA->certificate_type))
                    $advantagesB[] = 'Sertifikat tanah lebih jelas';

                if (($propertyB->investment_score ?? 0) > ($propertyA->investment_score ?? 0))
                    $advantagesB[] = 'Potensi investasi lebih tinggi';

                /*
                |--------------------------------------------------------------------------
                | INSIGHT
                |--------------------------------------------------------------------------
                */

                if ($propertyA->bedroom >= 3) {
                    $insightA = 'Cocok untuk keluarga menengah hingga besar.';
                } else {
                    $insightA = 'Cocok untuk pasangan muda atau investasi.';
                }

                if ($propertyB->bedroom >= 3) {
                    $insightB = 'Cocok untuk keluarga menengah hingga besar.';
                } else {
                    $insightB = 'Cocok untuk pasangan muda atau investasi.';
                }
            }
        }

        $properties = Property::orderBy('title')->get();

        return view(
            'compare.index',
            compact(
                'properties',
                'propertyA',
                'propertyB',
                'scoreA',
                'scoreB',
                'percentageA',
                'percentageB',
                'advantagesA',
                'advantagesB',
                'insightA',
                'insightB'
            )
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