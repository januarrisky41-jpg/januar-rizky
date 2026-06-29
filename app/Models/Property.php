<?php
// app/Models/Property.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'title',
        'location',
        'price',
        'bedroom',
        'bathroom',
        'building_area',
        'land_area',
        'distance_to_center',
        'facility_score',
        'facility_details',
        'security_score',
        'security_details',
        'condition_score',
        'grade_score',
        'certificate_type',
        'property_type',
        'description',
        'image',
        'is_active'
    ];

    protected $casts = [
        'price' => 'float',
        'building_area' => 'float',
        'land_area' => 'float',
        'distance_to_center' => 'float',
        'facility_score' => 'integer',
        'security_score' => 'integer',
        'condition_score' => 'integer',
        'grade_score' => 'integer',
        'is_active' => 'boolean'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI (KOMENTAR SEMENTARA)
    |--------------------------------------------------------------------------
    */

    // public function favorites()
    // {
    //     return $this->hasMany(Favorite::class);
    // }

    public function simulations()
    {
        return $this->hasMany(Simulation::class);
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI BANTU
    |--------------------------------------------------------------------------
    */

    public function getCertificateScoreAttribute(): int
    {
        return match ($this->certificate_type) {
            'SHM'   => 5,
            'SHGB'  => 3,
            default => 1,
        };
    }

    public function getCertificateLabelAttribute(): string
    {
        return $this->certificate_type ?? 'Tidak Tersedia';
    }

    public function getConditionLabelAttribute(): string
    {
        return $this->condition_score . '%';
    }

    public function getFacilityDetailsArrayAttribute(): array
    {
        if (empty($this->facility_details)) {
            return ['Informasi fasilitas belum tersedia'];
        }
        return explode('|', $this->facility_details);
    }

    public function getSecurityDetailsArrayAttribute(): array
    {
        if (empty($this->security_details)) {
            return ['Informasi keamanan belum tersedia'];
        }
        return explode('|', $this->security_details);
    }
}