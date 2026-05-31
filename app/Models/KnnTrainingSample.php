<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnnTrainingSample extends Model
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
        'rank',
        'ekstrakurikuler',
    ];
}
