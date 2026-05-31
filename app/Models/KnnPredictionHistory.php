<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnnPredictionHistory extends Model
{
    protected $fillable = [
        'nama_siswa',
        'nilai_matematika',
        'nilai_ipa',
        'nilai_ips',
        'nilai_bahasa_indonesia',
        'nilai_pjok',
        'nilai_seni_budaya',
        'minat',
        'prestasi_non_akademik',
        'k_value',
        'hasil_rekomendasi',
        'tetangga_terdekat',
    ];

    protected function casts(): array
    {
        return [
            'tetangga_terdekat' => 'array',
        ];
    }
}
