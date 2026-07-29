<?php

namespace App\Http\Controllers;

use App\Models\KnnPredictionHistory;
use App\Models\KnnTrainingSample;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use ZipArchive;

class KnnController extends Controller
{
    public function index(): View
    {
        return view('knn', [
            'totalTraining' => KnnTrainingSample::count(),
            'totalHistories' => KnnPredictionHistory::count(),
            'trainingSamples' => KnnTrainingSample::orderBy('nama_siswa')->get(),
            'histories' => KnnPredictionHistory::latest()->take(10)->get(),
            'defaultK' => 3,
        ]);
    }

    public function flowchart(): View
    {
        return view('flowchart');
    }

    public function cetakLaporan(): View
    {
        $histories = KnnPredictionHistory::latest()->get();

        return view('laporan_pdf', [
            'histories' => $histories,
            'title' => 'Laporan Rekapitulasi Rekomendasi Ekstrakurikuler - MTsN 2 Pesisir Selatan',
            'isDetail' => false,
        ]);
    }

    public function cetakDetailLaporan(int $id): View
    {
        $history = KnnPredictionHistory::findOrFail($id);

        return view('laporan_pdf', [
            'history' => $history,
            'title' => 'Lembar Hasil Rekomendasi Siswa - MTsN 2 Pesisir Selatan',
            'isDetail' => true,
        ]);
    }

    public function importTraining(Request $request): RedirectResponse
    {
        $request->validate([
            'training_file' => ['required', 'file', 'mimes:xlsx,csv,txt', 'max:5120'],
        ]);

        $rows = $this->parseTrainingFile($request->file('training_file'));

        if ($rows === []) {
            return redirect()
                ->route('knn.index')
                ->withErrors(['training_file' => 'File tidak memiliki data training yang valid.'])
                ->withInput();
        }

        DB::transaction(function () use ($rows): void {
            KnnTrainingSample::query()->delete();

            foreach ($rows as $row) {
                KnnTrainingSample::create($row);
            }
        });

        return redirect()
            ->route('knn.index')
            ->with('success', count($rows) . ' data training berhasil diimport. Data training lama otomatis dihapus.');
    }

    public function predict(Request $request): RedirectResponse
    {
        $validated = $this->validatedPrediction($request);
        $predictionInput = [
            ...$validated,
            'minat' => 'Otomatis',
            'prestasi_non_akademik' => 0,
        ];

        $samples = KnnTrainingSample::all();

        if ($samples->isEmpty()) {
            return redirect()
                ->route('knn.index')
                ->withErrors(['dataset' => 'Data training masih kosong. Isi data training terlebih dahulu.'])
                ->withInput();
        }

        $kValue = min((int) $validated['k_value'], $samples->count());
        $distances = $samples
            ->map(function (KnnTrainingSample $sample) use ($validated) {
                $math = $this->distanceBreakdown($validated, $sample);

                return [
                    'nama_siswa' => $sample->nama_siswa,
                    'rank' => $sample->rank,
                    'ekstrakurikuler' => $sample->ekstrakurikuler,
                    'nilai' => $math['sample_values'],
                    'selisih_kuadrat' => $math['squared_differences'],
                    'total_selisih_kuadrat' => $math['sum_squared'],
                    'jarak' => $math['distance'],
                ];
            })
            ->sortBy([
                ['jarak', 'asc'],
                ['rank', 'asc'],
            ])
            ->values();

        $neighbors = $distances->take($kValue);
        $votes = $neighbors
            ->groupBy('ekstrakurikuler')
            ->map(fn ($items) => $items->count());
        $maxVote = $votes->max();
        $candidateEkskul = $votes
            ->filter(fn ($count) => $count === $maxVote)
            ->keys()
            ->all();

        $recommendation = $neighbors
            ->first(fn ($neighbor) => in_array($neighbor['ekstrakurikuler'], $candidateEkskul, true))['ekstrakurikuler'];

        $history = KnnPredictionHistory::create([
            ...$predictionInput,
            'k_value' => $kValue,
            'hasil_rekomendasi' => $recommendation,
            'tetangga_terdekat' => $neighbors
                ->map(fn ($neighbor) => [
                    ...$neighbor,
                    'jarak' => round($neighbor['jarak'], 4),
                ])
                ->values()
                ->all(),
        ]);

        return redirect()
            ->route('knn.index')
            ->with('prediction_id', $history->id)
            ->with('success', 'Prediksi berhasil dihitung dan disimpan ke riwayat.');
    }

    private function validatedPrediction(Request $request): array
    {
        return $request->validate([
            'nama_siswa' => ['nullable', 'string', 'max:100'],
            'nilai_matematika' => ['required', 'integer', 'between:0,100'],
            'nilai_ipa' => ['required', 'integer', 'between:0,100'],
            'nilai_ips' => ['required', 'integer', 'between:0,100'],
            'nilai_bahasa_indonesia' => ['required', 'integer', 'between:0,100'],
            'nilai_pjok' => ['required', 'integer', 'between:0,100'],
            'nilai_seni_budaya' => ['required', 'integer', 'between:0,100'],
            'k_value' => ['required', 'integer', 'min:1', 'max:15'],
        ]);
    }

    private function distance(array $input, KnnTrainingSample $sample): float
    {
        return $this->distanceBreakdown($input, $sample)['distance'];
    }

    private function distanceBreakdown(array $input, KnnTrainingSample $sample): array
    {
        $inputValues = [
            'Matematika' => (int) $input['nilai_matematika'],
            'IPA' => (int) $input['nilai_ipa'],
            'IPS' => (int) $input['nilai_ips'],
            'Bahasa Indonesia' => (int) $input['nilai_bahasa_indonesia'],
            'PJOK' => (int) $input['nilai_pjok'],
            'Seni Budaya' => (int) $input['nilai_seni_budaya'],
        ];
        $sampleValues = [
            'Matematika' => $sample->nilai_matematika,
            'IPA' => $sample->nilai_ipa,
            'IPS' => $sample->nilai_ips,
            'Bahasa Indonesia' => $sample->nilai_bahasa_indonesia,
            'PJOK' => $sample->nilai_pjok,
            'Seni Budaya' => $sample->nilai_seni_budaya,
        ];
        $squaredDifferences = [];

        foreach ($inputValues as $label => $inputValue) {
            $difference = $inputValue - $sampleValues[$label];
            $squaredDifferences[$label] = $difference ** 2;
        }

        $sumSquared = array_sum($squaredDifferences);

        return [
            'sample_values' => $sampleValues,
            'squared_differences' => $squaredDifferences,
            'sum_squared' => $sumSquared,
            'distance' => sqrt($sumSquared),
        ];
    }

    /**
     * The importer scans for the header row, so exported Excel files may contain
     * title rows above the actual columns.
     */
    private function parseTrainingFile(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $rows = $extension === 'xlsx'
            ? $this->parseXlsxRows($file->getRealPath())
            : $this->parseCsvRows($file->getRealPath());

        if (count($rows) < 2) {
            return [];
        }

        $headerIndex = $this->findHeaderRowIndex($rows);

        if ($headerIndex === null) {
            return [];
        }

        $headers = array_map(fn ($value) => $this->normalizeHeader((string) $value), $rows[$headerIndex]);
        $importRows = [];

        foreach (array_slice($rows, $headerIndex + 1) as $row) {
            if ($this->isEmptyRow($row)) {
                continue;
            }

            $mapped = $this->mapTrainingRow($headers, $row);

            if ($mapped !== null) {
                $importRows[] = $mapped;
            }
        }

        return $importRows;
    }

    private function parseCsvRows(string $path): array
    {
        $handle = fopen($path, 'r');
        $rows = [];

        if ($handle === false) {
            return [];
        }

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $rows[] = $row;
        }

        fclose($handle);

        return $rows;
    }

    private function findHeaderRowIndex(array $rows): ?int
    {
        foreach ($rows as $index => $row) {
            $headers = array_map(fn ($value) => $this->normalizeHeader((string) $value), $row);

            if (
                in_array('nama', $headers, true)
                && (in_array('ekskul', $headers, true) || in_array('ekstrakurikuler', $headers, true))
            ) {
                return $index;
            }
        }

        return null;
    }

    private function parseXlsxRows(string $path): array
    {
        $zip = new ZipArchive();

        if ($zip->open($path) !== true) {
            return [];
        }

        $sharedStrings = $this->readSharedStrings($zip);
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            return [];
        }

        $sheet = simplexml_load_string($sheetXml);

        if ($sheet === false) {
            return [];
        }

        $rows = [];

        foreach ($sheet->sheetData->row as $rowNode) {
            $row = [];

            foreach ($rowNode->c as $cell) {
                $attributes = $cell->attributes();
                $cellRef = (string) ($attributes['r'] ?? '');
                $columnIndex = $this->columnIndexFromCellRef($cellRef);
                $row[$columnIndex] = $this->readCellValue($cell, $sharedStrings);
            }

            if ($row !== []) {
                $normalized = [];
                for ($index = 0; $index <= max(array_keys($row)); $index++) {
                    $normalized[] = $row[$index] ?? '';
                }
                $rows[] = $normalized;
            }
        }

        return $rows;
    }

    private function readSharedStrings(ZipArchive $zip): array
    {
        $xml = $zip->getFromName('xl/sharedStrings.xml');

        if ($xml === false) {
            return [];
        }

        $shared = simplexml_load_string($xml);

        if ($shared === false) {
            return [];
        }

        $strings = [];

        foreach ($shared->si as $item) {
            if (isset($item->t)) {
                $strings[] = (string) $item->t;
                continue;
            }

            $text = '';
            foreach ($item->r as $run) {
                $text .= (string) $run->t;
            }
            $strings[] = $text;
        }

        return $strings;
    }

    private function readCellValue(\SimpleXMLElement $cell, array $sharedStrings): string
    {
        $attributes = $cell->attributes();
        $type = (string) ($attributes['t'] ?? '');

        if ($type === 's') {
            return $sharedStrings[(int) $cell->v] ?? '';
        }

        if ($type === 'inlineStr') {
            return (string) ($cell->is->t ?? '');
        }

        return trim((string) ($cell->v ?? ''));
    }

    private function columnIndexFromCellRef(string $cellRef): int
    {
        preg_match('/^[A-Z]+/', strtoupper($cellRef), $matches);
        $letters = $matches[0] ?? 'A';
        $index = 0;

        foreach (str_split($letters) as $letter) {
            $index = ($index * 26) + (ord($letter) - 64);
        }

        return $index - 1;
    }

    private function mapTrainingRow(array $headers, array $row): ?array
    {
        $data = array_combine(
            $headers,
            array_slice(array_pad($row, count($headers), null), 0, count($headers))
        );

        if ($data === false) {
            return null;
        }

        $mapped = [
            'nama_siswa' => $this->stringValue($data, ['nama_siswa', 'nama', 'siswa', 'nama_lengkap']),
            'nilai_matematika' => $this->scoreValue($data, ['nilai_matematika', 'matematika', 'mtk']),
            'nilai_ipa' => $this->scoreValue($data, ['nilai_ipa', 'ipa']),
            'nilai_ips' => $this->scoreValue($data, ['nilai_ips', 'ips']),
            'nilai_bahasa_indonesia' => $this->scoreValue($data, ['nilai_bahasa_indonesia', 'bahasa_indonesia', 'bindo', 'bindonesia', 'b_indonesia', 'b_indo', 'bahasa_indo']),
            'nilai_pjok' => $this->scoreValue($data, ['nilai_pjok', 'pjok', 'olahraga']),
            'nilai_seni_budaya' => $this->scoreValue($data, ['nilai_seni_budaya', 'seni_budaya', 'sbp', 'seni']),
            'minat' => $this->stringValue($data, ['minat', 'minat_siswa'], 'Tidak Dicantumkan'),
            'prestasi_non_akademik' => 0,
            'rank' => max(1, min(999, $this->integerValue($data, ['rank', 'ranking', 'peringkat'], 999))),
            'ekstrakurikuler' => $this->stringValue($data, ['ekstrakurikuler', 'ekskul', 'hasil', 'label']),
        ];

        if ($mapped['nama_siswa'] === '' || $mapped['ekstrakurikuler'] === '') {
            return null;
        }

        return $mapped;
    }

    private function normalizeHeader(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '_', $value) ?? '';

        return trim($value, '_');
    }

    private function isEmptyRow(array $row): bool
    {
        return implode('', array_map('trim', array_map('strval', $row))) === '';
    }

    private function stringValue(array $data, array $keys, string $default = ''): string
    {
        foreach ($keys as $key) {
            if (isset($data[$key]) && trim((string) $data[$key]) !== '') {
                return trim((string) $data[$key]);
            }
        }

        return $default;
    }

    private function scoreValue(array $data, array $keys): int
    {
        return max(0, min(100, $this->integerValue($data, $keys, 0)));
    }

    private function integerValue(array $data, array $keys, int $default): int
    {
        foreach ($keys as $key) {
            if (isset($data[$key]) && is_numeric($data[$key])) {
                return (int) round((float) $data[$key]);
            }
        }

        return $default;
    }
}
