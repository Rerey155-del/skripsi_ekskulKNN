<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$testInput = [
    'nilai_matematika' => 85,
    'nilai_ipa' => 82,
    'nilai_ips' => 80,
    'nilai_bahasa_indonesia' => 88,
    'nilai_pjok' => 80,
    'nilai_seni_budaya' => 85,
];

$samples = \App\Models\KnnTrainingSample::all();
$distances = [];

foreach ($samples as $sample) {
    $d = sqrt(
        pow($testInput['nilai_matematika'] - $sample->nilai_matematika, 2) +
        pow($testInput['nilai_ipa'] - $sample->nilai_ipa, 2) +
        pow($testInput['nilai_ips'] - $sample->nilai_ips, 2) +
        pow($testInput['nilai_bahasa_indonesia'] - $sample->nilai_bahasa_indonesia, 2) +
        pow($testInput['nilai_pjok'] - $sample->nilai_pjok, 2) +
        pow($testInput['nilai_seni_budaya'] - $sample->nilai_seni_budaya, 2)
    );
    $distances[] = [
        'nama' => $sample->nama_siswa,
        'jarak' => round($d, 2),
        'ekskul' => $sample->ekstrakurikuler
    ];
}

usort($distances, fn($a, $b) => $a['jarak'] <=> $b['jarak']);

echo "TOP 4 TERDEKAT (K=4):\n";
for ($i = 0; $i < 4; $i++) {
    echo ($i + 1) . ". " . $distances[$i]['nama'] . " | Jarak: " . $distances[$i]['jarak'] . " | Ekskul: " . $distances[$i]['ekskul'] . "\n";
}
