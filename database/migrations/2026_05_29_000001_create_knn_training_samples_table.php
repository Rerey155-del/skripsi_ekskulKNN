<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knn_training_samples', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa');
            $table->unsignedTinyInteger('nilai_matematika');
            $table->unsignedTinyInteger('nilai_ipa');
            $table->unsignedTinyInteger('nilai_pjok');
            $table->unsignedTinyInteger('nilai_seni_budaya');
            $table->string('minat');
            $table->unsignedTinyInteger('prestasi_non_akademik')->default(0);
            $table->unsignedInteger('rank')->default(999);
            $table->string('ekstrakurikuler');
            $table->timestamps();

            $table->index(['ekstrakurikuler', 'minat']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knn_training_samples');
    }
};
