<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knn_prediction_histories', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa')->nullable();
            $table->unsignedTinyInteger('nilai_matematika');
            $table->unsignedTinyInteger('nilai_ipa');
            $table->unsignedTinyInteger('nilai_pjok');
            $table->unsignedTinyInteger('nilai_seni_budaya');
            $table->string('minat');
            $table->unsignedTinyInteger('prestasi_non_akademik')->default(0);
            $table->unsignedTinyInteger('k_value');
            $table->string('hasil_rekomendasi');
            $table->json('tetangga_terdekat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knn_prediction_histories');
    }
};
