<?php

namespace Database\Seeders;

use App\Models\KnnTrainingSample;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ],
        );

        $samples = [
            ['Andi Pratama', 88, 86, 82, 84, 74, 70, 'Sains dan Teknologi', 72, 4, 'KIR'],
            ['Bima Saputra', 72, 70, 76, 78, 91, 76, 'Olahraga', 88, 6, 'Futsal'],
            ['Citra Lestari', 78, 75, 80, 88, 72, 92, 'Seni', 90, 3, 'Seni Tari'],
            ['Dewi Anggraini', 84, 88, 83, 86, 70, 73, 'Sains dan Teknologi', 80, 2, 'Robotik'],
            ['Eko Firmansyah', 68, 72, 74, 75, 89, 75, 'Olahraga', 84, 8, 'Basket'],
            ['Fajar Maulana', 76, 78, 82, 80, 80, 74, 'Kepemimpinan', 82, 5, 'Pramuka'],
            ['Gita Rahma', 74, 76, 84, 87, 71, 89, 'Seni', 86, 7, 'Paduan Suara'],
            ['Hani Zahra', 80, 82, 85, 83, 76, 78, 'Keagamaan', 79, 9, 'Rohis'],
        ];

        foreach ($samples as [$nama, $mtk, $ipa, $ips, $bindo, $pjok, $seni, $minat, $prestasi, $rank, $ekskul]) {
            KnnTrainingSample::firstOrCreate(
                ['nama_siswa' => $nama],
                [
                    'nilai_matematika' => $mtk,
                    'nilai_ipa' => $ipa,
                    'nilai_ips' => $ips,
                    'nilai_bahasa_indonesia' => $bindo,
                    'nilai_pjok' => $pjok,
                    'nilai_seni_budaya' => $seni,
                    'minat' => $minat,
                    'prestasi_non_akademik' => $prestasi,
                    'rank' => $rank,
                    'ekstrakurikuler' => $ekskul,
                ],
            );
        }
    }
}
