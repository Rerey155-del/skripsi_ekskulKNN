<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$training = \App\Models\KnnTrainingSample::all();

// 1. Generate data_training_ekskul.csv
$fTrain = fopen(__DIR__ . '/data_training_ekskul.csv', 'w');
fputcsv($fTrain, ['nama_siswa', 'nilai_matematika', 'nilai_ipa', 'nilai_ips', 'nilai_bahasa_indonesia', 'nilai_pjok', 'nilai_seni_budaya', 'rank', 'ekstrakurikuler']);
foreach ($training as $row) {
    fputcsv($fTrain, [
        $row->nama_siswa,
        $row->nilai_matematika,
        $row->nilai_ipa,
        $row->nilai_ips,
        $row->nilai_bahasa_indonesia,
        $row->nilai_pjok,
        $row->nilai_seni_budaya,
        $row->rank,
        $row->ekstrakurikuler
    ]);
}
fclose($fTrain);

// 2. Generate data_uji_ekskul.csv
$fTest = fopen(__DIR__ . '/data_uji_ekskul.csv', 'w');
fputcsv($fTest, ['nama_siswa', 'nilai_matematika', 'nilai_ipa', 'nilai_ips', 'nilai_bahasa_indonesia', 'nilai_pjok', 'nilai_seni_budaya', 'rank']);
fputcsv($fTest, ['Abdi Wijaya', 85, 82, 80, 88, 80, 85, 3]);
fputcsv($fTest, ['Budi Santoso', 70, 75, 88, 82, 90, 78, 5]);
fputcsv($fTest, ['Citra Dewi', 90, 92, 85, 88, 75, 80, 1]);
fclose($fTest);

// 3. Generate pengujian_knn_ekskul.rmp (RapidMiner Process File)
$rmpXml = '<?xml version="1.0" encoding="UTF-8"?><process version="10.1.000">
  <context>
    <input/>
    <output/>
    <macros/>
  </context>
  <operator activated="true" class="process" compatibility="10.1.000" expanded="true" name="Process">
    <parameter key="logverbosity" value="init"/>
    <parameter key="random_seed" value="2001"/>
    <parameter key="send_mail" value="false"/>
    <parameter key="notification_email" value=""/>
    <parameter key="process_duration_for_mail" value="30"/>
    <parameter key="encoding" value="SYSTEM"/>
    <process expanded="true">
      <operator activated="true" class="read_csv" compatibility="10.1.000" expanded="true" height="68" name="Read CSV (Training Data)" width="90" x="45" y="34">
        <parameter key="csv_file" value="data_training_ekskul.csv"/>
        <parameter key="column_separators" value=","/>
        <parameter key="trim_lines" value="false"/>
        <parameter key="use_quotes" value="true"/>
        <parameter key="quotes_character" value="&quot;"/>
        <parameter key="escape_character" value="\"/>
        <parameter key="skip_comments" value="true"/>
        <parameter key="comment_characters" value="#"/>
        <parameter key="starting_row" value="1"/>
        <parameter key="parse_numbers" value="true"/>
        <parameter key="decimal_character" value="."/>
        <parameter key="grouped_digits" value="false"/>
        <parameter key="grouping_character" value=","/>
        <parameter key="infinity_representation" value=""/>
        <parameter key="date_format" value=""/>
        <parameter key="first_row_as_names" value="true"/>
        <list key="annotations"/>
        <parameter key="time_zone" value="SYSTEM"/>
        <parameter key="locale" value="English (United States)"/>
        <parameter key="encoding" value="SYSTEM"/>
        <list key="data_set_meta_data_information">
          <parameter key="0" value="nama_siswa.true.polynominal.id"/>
          <parameter key="1" value="nilai_matematika.true.integer.attribute"/>
          <parameter key="2" value="nilai_ipa.true.integer.attribute"/>
          <parameter key="3" value="nilai_ips.true.integer.attribute"/>
          <parameter key="4" value="nilai_bahasa_indonesia.true.integer.attribute"/>
          <parameter key="5" value="nilai_pjok.true.integer.attribute"/>
          <parameter key="6" value="nilai_seni_budaya.true.integer.attribute"/>
          <parameter key="7" value="rank.true.integer.attribute"/>
          <parameter key="8" value="ekstrakurikuler.true.polynominal.label"/>
        </list>
        <parameter key="read_not_matching_values_as_missings" value="false"/>
      </operator>
      <operator activated="true" class="k_nn" compatibility="10.1.000" expanded="true" height="82" name="k-NN" width="90" x="246" y="34">
        <parameter key="k" value="3"/>
        <parameter key="weighted_vote" value="false"/>
        <parameter key="measure_types" value="NumericalMeasures"/>
        <parameter key="mixed_measure" value="MixedEuclideanDistance"/>
        <parameter key="nominal_measure" value="NominalDistance"/>
        <parameter key="numerical_measure" value="EuclideanDistance"/>
        <parameter key="divergence" value="GeneralizedIDivergence"/>
        <parameter key="kernel_type" value="radial"/>
        <parameter key="kernel_gamma" value="1.0"/>
        <parameter key="kernel_sigma1" value="1.0"/>
        <parameter key="kernel_sigma2" value="0.0"/>
        <parameter key="kernel_sigma3" value="2.0"/>
        <parameter key="kernel_degree" value="3.0"/>
        <parameter key="kernel_shift" value="1.0"/>
        <parameter key="kernel_a" value="1.0"/>
        <parameter key="kernel_b" value="0.0"/>
      </operator>
      <operator activated="true" class="read_csv" compatibility="10.1.000" expanded="true" height="68" name="Read CSV (Testing Data)" width="90" x="45" y="187">
        <parameter key="csv_file" value="data_uji_ekskul.csv"/>
        <parameter key="column_separators" value=","/>
        <parameter key="trim_lines" value="false"/>
        <parameter key="use_quotes" value="true"/>
        <parameter key="quotes_character" value="&quot;"/>
        <parameter key="escape_character" value="\"/>
        <parameter key="skip_comments" value="true"/>
        <parameter key="comment_characters" value="#"/>
        <parameter key="starting_row" value="1"/>
        <parameter key="parse_numbers" value="true"/>
        <parameter key="decimal_character" value="."/>
        <parameter key="grouped_digits" value="false"/>
        <parameter key="grouping_character" value=","/>
        <parameter key="infinity_representation" value=""/>
        <parameter key="date_format" value=""/>
        <parameter key="first_row_as_names" value="true"/>
        <list key="annotations"/>
        <parameter key="time_zone" value="SYSTEM"/>
        <parameter key="locale" value="English (United States)"/>
        <parameter key="encoding" value="SYSTEM"/>
        <list key="data_set_meta_data_information">
          <parameter key="0" value="nama_siswa.true.polynominal.id"/>
          <parameter key="1" value="nilai_matematika.true.integer.attribute"/>
          <parameter key="2" value="nilai_ipa.true.integer.attribute"/>
          <parameter key="3" value="nilai_ips.true.integer.attribute"/>
          <parameter key="4" value="nilai_bahasa_indonesia.true.integer.attribute"/>
          <parameter key="5" value="nilai_pjok.true.integer.attribute"/>
          <parameter key="6" value="nilai_seni_budaya.true.integer.attribute"/>
          <parameter key="7" value="rank.true.integer.attribute"/>
        </list>
        <parameter key="read_not_matching_values_as_missings" value="false"/>
      </operator>
      <operator activated="true" class="apply_model" compatibility="10.1.000" expanded="true" height="82" name="Apply Model" width="90" x="380" y="136">
        <list key="application_parameters"/>
      </operator>
      <connect from_op="Read CSV (Training Data)" from_port="output" to_op="k-NN" to_port="training set"/>
      <connect from_op="k-NN" from_port="model" to_op="Apply Model" to_port="model"/>
      <connect from_op="Read CSV (Testing Data)" from_port="output" to_op="Apply Model" to_port="unlabelled data"/>
      <connect from_op="Apply Model" from_port="labelled data" to_port="result 1"/>
      <connect from_op="Apply Model" from_port="model" to_port="result 2"/>
      <portSpacing port="source_input 1" spacing="0"/>
      <portSpacing port="sink_result 1" spacing="0"/>
      <portSpacing port="sink_result 2" spacing="0"/>
      <portSpacing port="sink_result 3" spacing="0"/>
    </process>
  </operator>
</process>';

file_put_contents(__DIR__ . '/pengujian_knn_ekskul.rmp', $rmpXml);

echo "BERHASIL: File RapidMiner dan CSV telah dibuat di root project!\n";
