<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Support\Collection;

class SawService
{
    /**
     * Definisi kriteria SAW
     */
    public function getCriteria(): array
    {
        return [
            [
                'code' => 'C1',
                'name' => 'Harga Properti',
                'weight' => 0.20,
                'type' => 'cost',
                'description' => 'Semakin rendah harga, semakin baik bagi nasabah'
            ],
            [
                'code' => 'C2',
                'name' => 'Lokasi & Aksesibilitas',
                'weight' => 0.18,
                'type' => 'cost',
                'description' => 'Semakin dekat ke pusat kota/aktivitas, semakin baik'
            ],
            [
                'code' => 'C3',
                'name' => 'Luas Bangunan',
                'weight' => 0.12,
                'type' => 'benefit',
                'description' => 'Semakin luas bangunan, semakin nyaman untuk keluarga'
            ],
            [
                'code' => 'C4',
                'name' => 'Luas Tanah',
                'weight' => 0.10,
                'type' => 'benefit',
                'description' => 'Semakin luas tanah, semakin leluasa ruang terbuka'
            ],
            [
                'code' => 'C5',
                'name' => 'Fasilitas Umum',
                'weight' => 0.10,
                'type' => 'benefit',
                'description' => 'Semakin lengkap fasilitas terdekat (sekolah, RS, pasar)'
            ],
            [
                'code' => 'C6',
                'name' => 'Keamanan Lingkungan',
                'weight' => 0.08,
                'type' => 'benefit',
                'description' => 'Semakin aman lingkungan, semakin tentram keluarga'
            ],
            [
                'code' => 'C7',
                'name' => 'Jumlah Kamar Tidur',
                'weight' => 0.08,
                'type' => 'benefit',
                'description' => 'Semakin banyak kamar tidur, semakin fleksibel'
            ],
            [
                'code' => 'C8',
                'name' => 'Kondisi Fisik Bangunan',
                'weight' => 0.06,
                'type' => 'benefit',
                'description' => 'Semakin baik kondisi bangunan, semakin minim perawatan'
            ],
            [
                'code' => 'C9',
                'name' => 'Sertifikat Tanah',
                'weight' => 0.04,
                'type' => 'benefit',
                'description' => 'SHM lebih baik dari SHGB dari sisi kepastian hukum'
            ],
            [
                'code' => 'C10',
                'name' => 'Potensi Investasi',
                'weight' => 0.04,
                'type' => 'benefit',
                'description' => 'Semakin tinggi potensi kenaikan nilai properti'
            ],
        ];
    }

    /**
     * Hitung min dan max untuk setiap kriteria
     */
    public function getMinMax(Collection $properties, array $criteria): array
    {
        $minMax = [];

        foreach ($criteria as $criterion) {
            $code = $criterion['code'];
            $values = $properties->map(fn($p) => $p->getCriterionValue($code))->filter();

            $minMax[$code] = [
                'min' => $values->min() ?: 0,
                'max' => $values->max() ?: 1
            ];
        }

        return $minMax;
    }

    /**
     * Normalisasi nilai berdasarkan jenis kriteria
     */
    public function normalize(float $value, array $minMax, string $type): float
    {
        $min = $minMax['min'];
        $max = $minMax['max'];

        if ($max == $min) {
            return 1;
        }

        if ($type === 'benefit') {
            return ($value - $min) / ($max - $min);
        }

        // cost
        return ($max - $value) / ($max - $min);
    }

    /**
     * Hitung skor SAW untuk semua properti
     */
    public function calculate(Collection $properties): Collection
    {
        if ($properties->isEmpty()) {
            return collect();
        }

        $criteria = $this->getCriteria();
        $minMax = $this->getMinMax($properties, $criteria);

        return $properties->map(function ($property) use ($criteria, $minMax) {
            $details = [];
            $totalScore = 0;

            foreach ($criteria as $criterion) {
                $code = $criterion['code'];
                $value = $property->getCriterionValue($code);
                $normalized = $this->normalize($value, $minMax[$code], $criterion['type']);
                $weightedScore = $normalized * $criterion['weight'];

                $details[$code] = [
                    'name' => $criterion['name'],
                    'value' => $value,
                    'normalized' => round($normalized, 4),
                    'weight' => $criterion['weight'],
                    'weighted_score' => round($weightedScore, 4),
                    'type' => $criterion['type']
                ];

                $totalScore += $weightedScore;
            }

            return (object) [
                'property' => $property,
                'details' => $details,
                'total_score' => round($totalScore * 100, 2)
            ];
        })->sortByDesc('total_score')->values();
    }
}