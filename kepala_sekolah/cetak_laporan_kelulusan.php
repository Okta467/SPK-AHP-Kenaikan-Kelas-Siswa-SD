<?php
include '../helpers/user_login_checker.php';

// cek apakah user yang mengakses adalah kepala_sekolah?
if (!isAccessAllowed('kepala_sekolah')):
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else:
  include_once '../config/connection.php';
  include_once '../helpers/getStringTingkatKepentinganHelper.php';
  include_once '../helpers/getIntTingkatKepentinganHelper.php';
  include_once '../helpers/getNormalisasiDikaliBobotKriteriaHelper.php';
  include_once '../helpers/getConsistencyRatioHelper.php';
  include_once '../helpers/getTValueHelper.php';
  include_once '../helpers/getRankingAlternatifHelper.php';
  include_once '../helpers/getKelulusanSiswaHelper.php';

  $id_kelas_filter          = $_GET['id_kelas_filter'] ?? null;
  $id_tahun_akademik_filter = $_GET['id_tahun_akademik_filter'] ?? null;

  if ($id_kelas_filter && $id_tahun_akademik_filter):
    include_once 'get_laporan_kelulusan.php';
  endif;
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '_partials/head.php' ?>

  <meta name="Description" content="Data Penilaian Alternatif">
  <title>Data Penilaian Alternatif - <?= SITE_NAME ?></title>

  <style>
    .x_panel {
      width: 100%;
      padding: 10px 17px;
      display: inline-block;
      background: #fff;
      border: 1px solid #E6E9ED;
      -webkit-column-break-inside: avoid;
      -moz-column-break-inside: avoid;
      column-break-inside: avoid;
      opacity: 1;
      transition: all .2s ease;
    }
    
    .table td {
      font-size: unset;
    }
  </style>
</head>

<body>

<?php if (!$id_kelas_filter && !$id_tahun_akademik_filter): ?>
  
  Kelas dan Tahun Akademik tidak dipilih!

<?php elseif ($jmlAlternatif === 0 || $jmlKriteria === 0): ?>

  Data alternatif atau kriteria tidak ada!

<?php else: ?>


<!-- Matriks Perbandingan Berpasangan Setiap Kriteria -->
<?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>

  <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>
        
    <?php
    $firstKepentingan = $kriteria[$i]['nilai_kepentingan'];
    $secondKepentingan = $kriteria[$j]['nilai_kepentingan'];
    $tingkatKepentingan = getStringTingkatKepentingan($firstKepentingan, $secondKepentingan);
    ?>

  <?php endfor ?>

<?php endfor ?>
<!--/.matriks-perbandingan-berpasangan-setiap-kriteria -->


<!-- Normalisasi Matriks Perbandingan Berpasangan -->
<?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>

  <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>
        
    <?php
    $firstKepentinganTmp  = $kriteria[$i]['nilai_kepentingan'];
    $secondKepentinganTmp = $kriteria[$j]['nilai_kepentingan'];

    $tingkatKepentingan   = getIntTingkatKepentingan($firstKepentinganTmp, $secondKepentinganTmp);
    $firstKepentingan     = $tingkatKepentingan['data']['first'];
    $secondKepentingan    = $tingkatKepentingan['data']['second'];

    $normalisasiMatriks[$i][$j] = $firstKepentingan / $secondKepentingan;
    
    @$totalNormalisasiMatriks[$j] += $normalisasiMatriks[$i][$j];

    $formattedNormalisasiMatriks[$i][$j] = number_format($normalisasiMatriks[$i][$j], 3, ',', '.');

    $formattedTotalNormalisasiMatriks[$j] = number_format($totalNormalisasiMatriks[$j], 3, ',', '.');
    ?>

  <?php endfor ?>

<?php endfor ?>
<!--/.normalisasi-matriks-perbandingan-berpasangan -->


<!-- Matriks Perbandingan -->
<?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>

  <?php for ($j = 0; $j < ($jmlKriteria + 1); $j++): ?>

    <?php if ($j < ($jmlKriteria)): ?>

      <?php
      $matriksPerbandingan[$i][$j] = $normalisasiMatriks[$i][$j] / $totalNormalisasiMatriks[$j];

      @$rataMatriksPerbandingan[$i] += $matriksPerbandingan[$i][$j];

      $formattedHasilNormalisasiMatriks[$i][$j] = number_format($matriksPerbandingan[$i][$j], 3, ',', '.');
      ?>
    
    <?php else: ?>

      <?php
      $rataMatriksPerbandingan[$i] /= $jmlKriteria;

      $formattedRataMatriksPerbandingan[$i] = number_format($rataMatriksPerbandingan[$i], 3, ',', '.');
      ?>

    <?php endif ?>

  <?php endfor ?>

<?php endfor ?>
<!--/.matriks-perbandingan -->


<!-- Normalisasi Perbandingan Berpasangan * Nilai Bobot Kriteria (Wj) -->
<?php $normalisasiDikaliBobotKriteria = getNormalisasiDikaliBobotKriteria($normalisasiMatriks, $rataMatriksPerbandingan); ?>

<?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
      
  <?php $formattedNormalisasiDikaliBobotKriteria[$i] = number_format($normalisasiDikaliBobotKriteria['data'][$i], 3, ',', '.'); ?>

<?php endfor ?>
<!--/.normalisasi-perbandingan-berpasangan-*-nilai-bobot-kriteria-(wj) -->


<!-- Konsistensi Nilai -->
<?php
$nilaiT                = getTValue($jmlKriteria, $rataMatriksPerbandingan, $normalisasiDikaliBobotKriteria['data']);
$nilaiCI               = ($nilaiT - $jmlKriteria) / ($jmlKriteria - 1);
$nilaiRi               = getConsistencyRatio($jmlKriteria);
$nilaiCIDibagiRi       = $nilaiCI / $nilaiRi;
$keteranganConsistency = ($nilaiCI / $nilaiRi) <= 1 ? 'Nilainya Konsisten' : 'Nilainya Tidak Konsisten';
?>
<!--/.konsistensi-nilai -->


<!-- ALL CRITERIAS -->

<?php for ($k = 0; $k < $jmlKriteria; $k++): ?>

<?php $currentKriteria = $kriteria[$k]['nama_kriteria']; ?>


<!-- Nilai Matriks Perbandingan Berpasangan -->
<?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
  
  <?php for ($j = 0; $j < ($jmlAlternatif); $j++): ?>

    <?php
    $matriksPerbandinganKriteria[$currentKriteria][$i][$j] = ($i === $j)
      ? 1
      : $alternatif[$i][$currentKriteria] . '/' . $alternatif[$j][$currentKriteria];
    ?>

  <?php endfor ?>
  
<?php endfor ?>
<!--/.nilai-matriks-perbandingan-berpasangan -->


<!-- Transformasi Matriks Perbandingan Berpasangan -->
<?php for ($i = 0; $i < ($jmlAlternatif); $i++) : ?>

  <?php for ($j = 0; $j < ($jmlAlternatif); $j++) : ?>

    <?php
    $matriksPerbandinganKriteria[$currentKriteria][$i][$j] = ($i === $j)
      ? 1
      : $alternatif[$i][$currentKriteria] / $alternatif[$j][$currentKriteria];

    @$totalMatriksPerbandinganKriteria[$currentKriteria][$j] += $matriksPerbandinganKriteria[$currentKriteria][$i][$j];

    $formattedMatriksPerbandinganKriteria[$currentKriteria][$i][$j] = number_format($matriksPerbandinganKriteria[$currentKriteria][$i][$j], 3, ',', '.');

    $formattedTotalMatriksPerbandinganKriteria[$currentKriteria][$j] = number_format($totalMatriksPerbandinganKriteria[$currentKriteria][$j], 3, ',', '.');
    ?>

  <?php endfor ?>

<?php endfor ?>
<!--/.transformasi-matriks-perbandingan-berpasangan -->


<!-- Normalisasi Matriks Perbandingan Berpasangan -->
 
<!--/.normalisasi-matriks-perbandingan-berpasangan -->


<!-- Hasil Normalisasi dan Nilai Rata-Rata Wj -->
<?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
  
  <?php for ($j = 0; $j < ($jmlAlternatif + 1); $j++): ?>

    <?php if ($j < $jmlAlternatif): ?>

      <?php
      $hasilMatriksPerbandinganKriteria[$currentKriteria][$i][$j] = $matriksPerbandinganKriteria[$currentKriteria][$i][$j] / $totalMatriksPerbandinganKriteria[$currentKriteria][$j];

      @$rataHasilMatriksPerbandinganKriteria[$currentKriteria][$i] += $hasilMatriksPerbandinganKriteria[$currentKriteria][$i][$j] ?? 0;

      $formattedHasilMatriksPerbandinganKriteria[$currentKriteria][$i][$j] = number_format($hasilMatriksPerbandinganKriteria[$currentKriteria][$i][$j], 3, ',', '.');
      ?>

    <?php else: ?>

      <?php
      $rataHasilMatriksPerbandinganKriteria[$currentKriteria][$i] /= $jmlAlternatif;

      $formattedRataHasilMatriksPerbandinganKriteria[$currentKriteria][$i] = number_format($rataHasilMatriksPerbandinganKriteria[$currentKriteria][$i], 3, ',', '.');
      ?>

    <?php endif ?>
      
  <?php endfor ?>

<?php endfor ?>
<!--/.hasil-normalisasi-dan-nilai-rata-rata-wj -->  

<?php endfor ?>

<!-- END ALL CRITERIAS -->


<!-- Nilai Perkalian Bobot Kriteria dan Alternatif yang Selesai Dihitung -->
<?php
$jmlRataMatriksPerbandingan = count($rataMatriksPerbandingan);
$barisTambahanPerkalianBobotDanAlternatif = $jmlRataMatriksPerbandingan - $jmlAlternatif;
$jmlBarisNilaiPerkalianBobotDanAlternatif = $jmlAlternatif + $barisTambahanPerkalianBobotDanAlternatif;
?>

<?php for ($i = 0; $i < ($jmlBarisNilaiPerkalianBobotDanAlternatif); $i++): ?>
  
  <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>

    <?php
    if (
      $i === ($jmlBarisNilaiPerkalianBobotDanAlternatif - 1)
      && $barisTambahanPerkalianBobotDanAlternatif > 0
      && $j < ($jmlKriteria)
    ):
    ?>

      <!-- Empty -->

    <?php elseif ($j < ($jmlKriteria)): ?>

      <?php
      $currentKriteria = $kriteria[$j]['nama_kriteria'];

      $bobotKriteria[$i][$currentKriteria] = $rataHasilMatriksPerbandinganKriteria[$currentKriteria][$i];

      $formattedBobotKriteria[$i][$currentKriteria] = number_format($bobotKriteria[$i][$currentKriteria], 3, ',', '.');
      ?>

    <?php endif ?>

  <?php endfor ?>
  
<?php endfor ?>
<!--/.nilai-perkalian-bobot-kriteria-dan-alternatif-yang-selesai-dihitung -->


<!-- Hasil Nilai Perkalian Bobot Kriteria dan Alternatif yang Selesai Dihitung -->
<?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
  
  <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>

    <?php
    $currentKriteria = $kriteria[$j]['nama_kriteria'];

    $hasilPerkalianBobotKriteriaDanAlternatif[$i][$currentKriteria] = $bobotKriteria[$i][$currentKriteria] * $rataMatriksPerbandingan[$j];

    @$totalHasilPerkalianBobotKriteriaDanAlternatif[$i] += $hasilPerkalianBobotKriteriaDanAlternatif[$i][$currentKriteria];

    $formattedHasilPerkalianBobotKriteriaDanAlternatif[$i][$currentKriteria] = number_format($hasilPerkalianBobotKriteriaDanAlternatif[$i][$currentKriteria], 3, ',', '.');

    $formattedTotalHasilPerkalianBobotKriteriaDanAlternatif[$i] = number_format($totalHasilPerkalianBobotKriteriaDanAlternatif[$i], 3, ',', '.');
    ?>

  <?php endfor ?>
  
<?php endfor ?>
<!--/.hasil-nilai-perkalian-bobot-kriteria-dan-alternatif-yang-selesai-dihitung -->

<div class="x_panel" style="display: flex; flex-direction: row; align-items: center; justify-content: center; border: none; border-bottom: 5px groove black; margin-bottom: 1.5em" bis_skin_checked="1">
  <img src="<?= base_url('assets/images/icon_kabupaten_muara_enim.gif') ?>" style="height: 130px;margin-right: 1.5em;">
  <div bis_skin_checked="1">
    <h3 style="font-weight: bold;line-height: 1.5;text-align: center;">
      <span >
        PEMERINTAH MUARA ENIM <br>
        KECAMATAN LAWANG KIDUL <br>
      </span>
      <span >
        DESA KEBAN AGUNG
      </span>
    </h3>
    <p>Alamat: Keban Agung, Kec. Lawang Kidul, Muara Enim, Sumatera Selatan (31711)</p>
  </div>
</div>

<?php
$nama_kelas   = $alternatif[0]['nama_kelas'];
$dari_tahun   = $alternatif[0]['dari_tahun'];
$sampai_tahun = $alternatif[0]['sampai_tahun'];
?>

<h3 class="text-center my-5"><?= "Kenaikan Siswa Kelas {$nama_kelas} Periode {$dari_tahun}/{$sampai_tahun}" ?></h3>

<!-- Ranking -->
<div class="table-responsive">
  <table class="table table-striped table-bordered table-sm">
    <thead>
      <tr class="text-center">
        <th>#</th>
        <th>Alternatif</th>
        <th>NISN</th>
        <th>Siswa</th>
        <th>Kelas</th>
        <th>Wali Kelas</th>
        <th>Ranking</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
  
      $kodeAlternatif = array_column($alternatif, 'kode_alternatif');
      $nilaiAkhirs    = $totalHasilPerkalianBobotKriteriaDanAlternatif;
      $namaSiswa      = array_column($alternatif, 'nama_siswa');
      $nisnSiswa      = array_column($alternatif, 'nisn');
      $jkSiswa        = array_column($alternatif, 'jk');
      $namaKelas      = array_column($alternatif, 'nama_kelas');
      $namaWaliKelas  = array_column($alternatif, 'nama_guru');
      $nipWaliKelas   = array_column($alternatif, 'nip');
  
      $dataRankings   = getRankingAlternatif(
        $kodeAlternatif,
        $nilaiAkhirs,
        $namaSiswa,
        $nisnSiswa,
        $jkSiswa,
        $namaKelas,
        $namaWaliKelas,
        $nipWaliKelas)['data'];
  
      $namaKriterias  = array_map(fn($x) => $x['nama_kriteria'], $kriteria);
      $kelulusanSiswa = getKelulusanSiswa($alternatif_nilai_siswa, $namaKriterias)['data'];
      ?>
  
      <?php for ($i = 0; $i < count($dataRankings); $i++): ?>
  
        <tr>
          <td class="text-center"><?= $no++ ?></td>
          <td class="text-center"><?= $dataRankings[$i]['kode_alternatif'] ?></td>
          <td class="text-center"><?= $dataRankings[$i]['nisn_siswa'] ?></td>
          <td><?= htmlspecialchars($dataRankings[$i]['nama_siswa']) ?></td>
          <td class="text-center"><?= $dataRankings[$i]['nama_kelas'] ?></td>
          <td><?= htmlspecialchars($dataRankings[$i]['nama_wali_kelas']) . "<br><small class='text-muted'>({$dataRankings[$i]['nip_wali_kelas']})</small>" ?></td>
          <td class="text-center"><?= $dataRankings[$i]['rank'] ?></td>
          <td class="text-center"><?=
            strtolower($kelulusanSiswa[$i]['keterangan_kelulusan']) === 'lulus'
              ? '<span class="font-weight-bold text-success">Lulus</span>'
              : '<span class="font-weight-bold text-danger">Tidak Lulus</span>'
          ?></td>
        </tr>
        
      <?php endfor ?>
    </tbody>
  </table>
</div>
<!--/.ranking -->


<?php endif ?>
<!-- End condition from row empty-data above -->

</div>


  <?php include '_partials/script.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
  </script>

</body>

</html>

<?php endif ?>