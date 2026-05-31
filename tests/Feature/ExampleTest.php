<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use App\Models\KnnPredictionHistory;
use App\Models\KnnTrainingSample;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_training_data_can_be_imported_from_csv(): void
    {
        $csv = implode("\n", [
            'Nama,MTK,IPA,IPS,BINDO,PJOK,SBP,RANK,Ekskul',
            'Alya,90,88,84,87,75,80,1,KIR',
        ]);

        $response = $this->post(route('knn.training.import'), [
            'training_file' => UploadedFile::fake()->createWithContent('training.csv', $csv),
        ]);

        $response->assertRedirect(route('knn.index'));
        $this->assertDatabaseHas('knn_training_samples', [
            'nama_siswa' => 'Alya',
            'nilai_matematika' => 90,
            'nilai_ipa' => 88,
            'nilai_ips' => 84,
            'nilai_bahasa_indonesia' => 87,
            'nilai_pjok' => 75,
            'nilai_seni_budaya' => 80,
            'rank' => 1,
            'ekstrakurikuler' => 'KIR',
        ]);
        $this->assertSame(1, KnnTrainingSample::count());
    }

    public function test_training_import_finds_header_after_title_rows(): void
    {
        $csv = implode("\n", [
            'Laporan Nilai Siswa',
            'Semester Genap',
            'No,NIS,NISN,Nama,JK,BINDO,MTK,IPA,IPS,PJOK,SBP,Jumlah,RANK,Ekskul',
            '1,251236,3122808372,AFFIFAH NADIRA,P,80,83,81,84,81,85,1276,15,Voli',
        ]);

        $response = $this->post(route('knn.training.import'), [
            'training_file' => UploadedFile::fake()->createWithContent('nilai.csv', $csv),
        ]);

        $response->assertRedirect(route('knn.index'));
        $this->assertDatabaseHas('knn_training_samples', [
            'nama_siswa' => 'AFFIFAH NADIRA',
            'nilai_matematika' => 83,
            'nilai_ipa' => 81,
            'nilai_ips' => 84,
            'nilai_bahasa_indonesia' => 80,
            'nilai_pjok' => 81,
            'nilai_seni_budaya' => 85,
            'rank' => 15,
            'ekstrakurikuler' => 'Voli',
        ]);
    }

    public function test_prediction_recommends_ekstrakurikuler_automatically_from_scores(): void
    {
        KnnTrainingSample::create([
            'nama_siswa' => 'Data Latih',
            'nilai_matematika' => 80,
            'nilai_ipa' => 81,
            'nilai_ips' => 82,
            'nilai_bahasa_indonesia' => 83,
            'nilai_pjok' => 81,
            'nilai_seni_budaya' => 85,
            'minat' => 'Tidak Dicantumkan',
            'prestasi_non_akademik' => 0,
            'rank' => 15,
            'ekstrakurikuler' => 'Voli',
        ]);

        $response = $this->post(route('knn.predict'), [
            'nama_siswa' => 'Siswa Uji',
            'nilai_matematika' => 80,
            'nilai_ipa' => 81,
            'nilai_ips' => 82,
            'nilai_bahasa_indonesia' => 83,
            'nilai_pjok' => 81,
            'nilai_seni_budaya' => 85,
            'k_value' => 1,
        ]);

        $response->assertRedirect(route('knn.index'));
        $this->assertDatabaseHas('knn_prediction_histories', [
            'nama_siswa' => 'Siswa Uji',
            'minat' => 'Otomatis',
            'prestasi_non_akademik' => 0,
            'hasil_rekomendasi' => 'Voli',
        ]);
        $this->assertSame(1, KnnPredictionHistory::count());
    }

    public function test_new_training_import_replaces_old_data_and_training_table_is_alphabetical(): void
    {
        KnnTrainingSample::create([
            'nama_siswa' => 'Data Lama',
            'nilai_matematika' => 70,
            'nilai_ipa' => 70,
            'nilai_ips' => 70,
            'nilai_bahasa_indonesia' => 70,
            'nilai_pjok' => 70,
            'nilai_seni_budaya' => 70,
            'minat' => 'Tidak Dicantumkan',
            'prestasi_non_akademik' => 0,
            'rank' => 9,
            'ekstrakurikuler' => 'Pramuka',
        ]);

        $csv = implode("\n", [
            'Nama,MTK,IPA,IPS,BINDO,PJOK,SBP,RANK,Ekskul',
            'Zahra,86,88,80,82,75,80,2,KIR',
            'Alya,88,90,81,84,78,82,1,Voli',
        ]);

        $this->post(route('knn.training.import'), [
            'training_file' => UploadedFile::fake()->createWithContent('training.csv', $csv),
        ])->assertRedirect(route('knn.index'));

        $this->assertDatabaseMissing('knn_training_samples', [
            'nama_siswa' => 'Data Lama',
        ]);
        $this->assertSame(2, KnnTrainingSample::count());

        $this->get('/')
            ->assertSeeInOrder(['Alya', 'Zahra']);
    }
}
