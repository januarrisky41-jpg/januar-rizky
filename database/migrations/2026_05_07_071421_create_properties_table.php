<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambahkan
            if (!Schema::hasColumn('properties', 'land_area')) {
                $table->float('land_area')->nullable()->after('building_area');
            }

            if (!Schema::hasColumn('properties', 'distance_to_center')) {
                $table->float('distance_to_center')->nullable()->after('land_area');
            }

            if (!Schema::hasColumn('properties', 'facility_score')) {
                $table->integer('facility_score')->nullable()->default(3)->after('distance_to_center');
            }

            if (!Schema::hasColumn('properties', 'security_score')) {
                $table->integer('security_score')->nullable()->default(3)->after('facility_score');
            }

            if (!Schema::hasColumn('properties', 'certificate_type')) {
                $table->enum('certificate_type', ['SHM', 'SHGB', 'Lainnya'])->nullable()->after('condition_score');
            }

            if (!Schema::hasColumn('properties', 'investment_score')) {
                $table->integer('investment_score')->nullable()->default(3)->after('certificate_type');
            }

            if (!Schema::hasColumn('properties', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'land_area',
                'distance_to_center',
                'facility_score',
                'security_score',
                'certificate_type',
                'investment_score',
                'is_active'
            ]);
        });
    }
};