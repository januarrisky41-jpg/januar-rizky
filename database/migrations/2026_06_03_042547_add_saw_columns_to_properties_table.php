<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Kriteria untuk SAW
            $table->float('price')->nullable()->change(); // harga
            $table->float('building_area')->nullable(); // luas bangunan
            $table->float('land_area')->nullable(); // luas tanah
            $table->integer('bedrooms')->nullable(); // jumlah kamar tidur
            $table->integer('bathrooms')->nullable(); // jumlah kamar mandi
            $table->float('distance_to_center')->nullable(); // jarak ke pusat kota (km)
            $table->integer('security_score')->nullable()->default(3); // keamanan 1-5
            $table->integer('facility_score')->nullable()->default(3); // fasilitas 1-5
            $table->integer('building_condition')->nullable()->default(3); // kondisi bangunan 1-5
            $table->enum('certificate_type', ['SHM', 'SHGB', 'Lainnya'])->nullable();
            $table->integer('investment_potential')->nullable()->default(3); // potensi investasi 1-5
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'land_area',
                'distance_to_center',
                'security_score',
                'facility_score',
                'building_condition',
                'certificate_type',
                'investment_potential'
            ]);
        });
    }
};