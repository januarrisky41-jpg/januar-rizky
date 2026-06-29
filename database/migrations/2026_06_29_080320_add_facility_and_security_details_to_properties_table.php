<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn('properties', 'facility_details')) {
                $table->text('facility_details')->nullable()->after('facility_score');
            }

            if (!Schema::hasColumn('properties', 'security_details')) {
                $table->text('security_details')->nullable()->after('security_score');
            }

            // Hapus kolom investment_score jika ada
            if (Schema::hasColumn('properties', 'investment_score')) {
                $table->dropColumn('investment_score');
            }
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['facility_details', 'security_details']);
            $table->integer('investment_score')->nullable()->default(3);
        });
    }
};