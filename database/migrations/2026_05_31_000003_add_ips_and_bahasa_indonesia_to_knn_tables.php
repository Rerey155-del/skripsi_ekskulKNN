<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('knn_training_samples', function (Blueprint $table) {
            $table->unsignedTinyInteger('nilai_ips')->default(0)->after('nilai_ipa');
            $table->unsignedTinyInteger('nilai_bahasa_indonesia')->default(0)->after('nilai_ips');
        });

        Schema::table('knn_prediction_histories', function (Blueprint $table) {
            $table->unsignedTinyInteger('nilai_ips')->default(0)->after('nilai_ipa');
            $table->unsignedTinyInteger('nilai_bahasa_indonesia')->default(0)->after('nilai_ips');
        });
    }

    public function down(): void
    {
        Schema::table('knn_training_samples', function (Blueprint $table) {
            $table->dropColumn(['nilai_ips', 'nilai_bahasa_indonesia']);
        });

        Schema::table('knn_prediction_histories', function (Blueprint $table) {
            $table->dropColumn(['nilai_ips', 'nilai_bahasa_indonesia']);
        });
    }
};
