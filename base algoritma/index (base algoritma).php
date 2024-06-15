<?php
  include_once 'getStringTingkatKepentinganHelper.php';
  include_once 'getIntTingkatKepentinganHelper.php';
  include_once 'getNormalisasiDikaliBobotKriteriaHelper.php';
  include_once 'getConsistencyRatioHelper.php';
  include_once 'getTValueHelper.php';
  include_once 'getRankingAlternatifHelper.php';

  $alternatif = [
    ['kode_alternatif' => 'A1', 'kehadiran' => 3, 'tugas' => 4, 'mid' => 5, 'uas' => 4, 'perilaku' => 4],
    ['kode_alternatif' => 'A2', 'kehadiran' => 5, 'tugas' => 4, 'mid' => 4, 'uas' => 3, 'perilaku' => 4],
    ['kode_alternatif' => 'A3', 'kehadiran' => 4, 'tugas' => 3, 'mid' => 5, 'uas' => 4, 'perilaku' => 4],
    ['kode_alternatif' => 'A4', 'kehadiran' => 4, 'tugas' => 4, 'mid' => 3, 'uas' => 3, 'perilaku' => 3],
  ];

  $kriteria = [
    ['nama_kriteria' => 'kehadiran', 'nilai_kepentingan' => 1],
    ['nama_kriteria' => 'tugas', 'nilai_kepentingan' => 3],
    ['nama_kriteria' => 'mid', 'nilai_kepentingan' => 5],
    ['nama_kriteria' => 'uas', 'nilai_kepentingan' => 7],
    ['nama_kriteria' => 'perilaku', 'nilai_kepentingan' => 1],
  ];
    
  $jmlAlternatif = count($alternatif);
  
  $jmlKriteria = count($kriteria);


  /**
   * I kept all variables below to make it easy to remember
   * especially when you want to use it in new table
   * 
   * Note: Of course deleting all variables below doesn't affect/error
   */

  $normalisasiMatriks = array();

  $totalNormalisasiMatriks = array();

  $matriksPerbandingan = array();

  $rataMatriksPerbandingan = array();

  $matriksPerbandinganKriteria = array();

  $totalMatriksPerbandinganKriteria = array();

  $rataHasilMatriksPerbandinganKriteria = array();

  $bobotKriteria = array();


  $formattedNormalisasiMatriks = array();

  $formattedTotalNormalisasiMatriks = array();

  $formattedHasilNormalisasiMatriks = array();

  $formattedRataMatriksPerbandingan = array();

  $formattedMatriksPerbandinganKriteria = array();
  
  $formattedTotalMatriksPerbandinganKriteria = array();

  $formattedRataHasilMatriksPerbandinganKriteria = array();

  $formattedBobotKriteria = array();


  $jmlRataMatriksPerbandingan = 0;

  $barisTambahanPerkalianBobotDanAlternatif = 0;

  $jmlBarisNilaiPerkalianBobotDanAlternatif = 0;
  ?>

<h4>Properti Untuk Masing-masing Alternatif</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <thead>
    <tr>
      <th>No</th>
      <th>Alternatif</th>
      <th>Kehadiran</th>
      <th>Tugas</th>
      <th>MID</th>
      <th>UAS</th>
      <th>Perilaku</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; ?>
    <?php for ($i = 0; $i < $jmlAlternatif; $i++): ?>

      <tr>
        <td><?= $no++ ?></td>
        <td><?= $alternatif[$i]['kode_alternatif'] ?></td>
        <td><?= $alternatif[$i]['kehadiran'] ?></td>
        <td><?= $alternatif[$i]['tugas'] ?></td>
        <td><?= $alternatif[$i]['mid'] ?></td>
        <td><?= $alternatif[$i]['uas'] ?></td>
        <td><?= $alternatif[$i]['perilaku'] ?></td>
      </tr>
    
    <?php endfor ?>
  </tbody>
</table>


<h4>Matriks Perbandingan Berpasangan Setiap Kriteria</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
        <td><?= $kriteria[$i]['nama_kriteria'] ?></td>
      <?php endfor ?>
    </tr>

    <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
      
      <tr>

      <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>
            
        <?php
        $firstKepentingan = $kriteria[$i]['nilai_kepentingan'];
        $secondKepentingan = $kriteria[$j]['nilai_kepentingan'];
        $tingkatKepentingan = getStringTingkatKepentingan($firstKepentingan, $secondKepentingan);
        ?>

        <?php if ($j === 0): ?>

          <td><?= $kriteria[$i]['nama_kriteria'] ?></td>

        <?php endif ?>

        <td><?= $tingkatKepentingan['data'] ?></td>

      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>


<h4>Normalisasi Matriks Perbandingan Berpasangan</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
        <td><?= $kriteria[$i]['nama_kriteria'] ?></td>
      <?php endfor ?>
    </tr>

    <?php for ($i = 0; $i < ($jmlKriteria + 1); $i++): ?>
      
      <tr>

      <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>

        <?php if ($i < ($jmlKriteria)): ?>
            
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

          <?php if ($j === 0): ?>

            <td><?= $kriteria[$i]['nama_kriteria'] ?></td>

          <?php endif ?>

          <td><?= $formattedNormalisasiMatriks[$i][$j] ?></td>
        
        <!-- Last row -->
        <?php else: ?>

          <?php if ($j === 0): ?>

            <td>Nilai</td>

          <?php endif ?>

          <td><?= $formattedTotalNormalisasiMatriks[$j] ?></td>
          
        <?php endif ?>

      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>


<h4>Matriks Perbandingan Berpasangan</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
        <td><?= $kriteria[$i]['nama_kriteria'] ?></td>
      <?php endfor ?>
    </tr>

    <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
      
      <tr>

      <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>

        <?php if ($j === 0): ?>

          <td><?= $kriteria[$i]['nama_kriteria'] ?></td>

        <?php endif ?>

        <td><?= "{$formattedNormalisasiMatriks[$i][$j]} / {$formattedTotalNormalisasiMatriks[$j]}" ?></td>
        
      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>


<h4>Matriks Perbandingan</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <thead>
    <tr>
      <th colspan="<?= $jmlKriteria + 1 ?>">Nilai Matriks Perbandingan Kriteria</th>
      <th>Rata-Rata (Nilai Bobot Kriteria [W<sub>j</sub>])</th>
    </tr>
  </thead>
  <tbody>
    <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
      
      <tr>

        <td><?= 'K' . ($i + 1) ?></td>

      <?php for ($j = 0; $j < ($jmlKriteria + 1); $j++): ?>

        <?php if ($j < ($jmlKriteria)): ?>

          <?php
          $matriksPerbandingan[$i][$j] = $normalisasiMatriks[$i][$j] / $totalNormalisasiMatriks[$j];

          @$rataMatriksPerbandingan[$i] += $matriksPerbandingan[$i][$j];

          $formattedHasilNormalisasiMatriks[$i][$j] = number_format($matriksPerbandingan[$i][$j], 3, ',', '.');
          ?>
          
          <td><?= $formattedHasilNormalisasiMatriks[$i][$j] ?></td>
        
        <?php else: ?>

          <?php
          $rataMatriksPerbandingan[$i] /= $jmlKriteria;

          $formattedRataMatriksPerbandingan[$i] = number_format($rataMatriksPerbandingan[$i], 3, ',', '.');
          ?>

          <td><?= $formattedRataMatriksPerbandingan[$i] ?></td>

        <?php endif ?>

      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>


<h4>Normalisasi Perbandingan Berpasangan * Nilai Bobot Kriteria (W<sub>j</sub>)</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <thead>
    <tr>
      <th colspan="<?= $jmlKriteria ?>">Normalisasi Matriks Perbandingan Berpasangan</th>
      <th>Nilai Bobot Kriteria (W<sub>j</sub>)</th>
      <th>Hasil Perkalian Matriks</th>
    </tr>
  </thead>
  <tbody>
    <?php $normalisasiDikaliBobotKriteria = getNormalisasiDikaliBobotKriteria($normalisasiMatriks, $rataMatriksPerbandingan); ?>
    
    <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
      
      <tr>

      <?php for ($j = 0; $j < ($jmlKriteria + 2); $j++): ?>

        <?php if ($j < ($jmlKriteria)): ?>

          <td><?= $formattedNormalisasiMatriks[$i][$j] ?></td>
          
        <?php elseif ($j < ($jmlKriteria + 1)): ?>
          
          <td><?= $formattedRataMatriksPerbandingan[$i] ?></td>

        <?php else: ?>
          
          <?php $formattedNormalisasiDikaliBobotKriteria[$i] = number_format($normalisasiDikaliBobotKriteria['data'][$i], 3, ',', '.'); ?>
          
          <td><?= $formattedNormalisasiDikaliBobotKriteria[$i] ?></td>
      
        <?php endif ?>

      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>


<h4>Konsistensi Nilai</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <thead>
    <tr>
      <th>n Kriteria</th>
      <th>t</th>
      <th>CI</th>
      <th>Ri</th>
      <th>CI/Ri</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $nilaiT = getTValue($jmlKriteria, $rataMatriksPerbandingan, $normalisasiDikaliBobotKriteria['data']);
    $nilaiCI = ($nilaiT - $jmlKriteria) / ($jmlKriteria - 1);
    $nilaiRi = getConsistencyRatio($jmlKriteria);
    $nilaiCIDibagiRi = $nilaiCI / $nilaiRi;
    $keteranganConsistency = ($nilaiCI / $nilaiRi) <= 1 ? 'Nilainya Konsisten' : 'Nilainya Tidak Konsisten';
    ?>
    <tr>
      <td><?= $jmlKriteria ?></td>
      <td><?= number_format($nilaiT, 3, ',', '.') ?></td>
      <td><?= number_format($nilaiCI, 3, ',', '.') ?></td>
      <td><?= $nilaiRi ?></td>
      <td><?= number_format($nilaiCIDibagiRi, 3, ',', '.') ?></td>
      <td><?= $keteranganConsistency ?></td>
    </tr>
  </tbody>
</table>


<!-- ALL CRITERIAS -->

<?php for ($k = 0; $k < $jmlKriteria; $k++): ?>

  <?php $currentKriteria = $kriteria[$k]['nama_kriteria']; ?>

  <h3 style="margin-top: 3rem"><?= '> ' . ucwords($kriteria[$k]['nama_kriteria']) ?></h3>


  <h4>Nilai Matriks Perbandingan Berpasangan</h4>

  <table border="1" cellspacing="0" cellpadding="3">
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
          <td><?= $alternatif[$i]['kode_alternatif'] ?></td>
        <?php endfor ?>
      </tr>

      <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
        
        <tr>

        <?php for ($j = 0; $j < ($jmlAlternatif); $j++): ?>

          <?php
          $matriksPerbandinganKriteria[$currentKriteria][$i][$j] = ($i === $j)
            ? 1
            : $alternatif[$i][$currentKriteria] . '/' . $alternatif[$j][$currentKriteria];
          ?>

          <?php if ($j === 0): ?>

            <td><?= $alternatif[$i]['kode_alternatif'] ?></td>

          <?php endif ?>

          <td><?= $matriksPerbandinganKriteria[$currentKriteria][$i][$j] ?></td>

        <?php endfor ?>
        
        </tr>

      <?php endfor ?>
    </tbody>
  </table>


  <h4>Transformasi Matriks Perbandingan Berpasangan</h4>

  <table border="1" cellspacing="0" cellpadding="3">
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
          <td><?= $alternatif[$i]['kode_alternatif'] ?></td>
        <?php endfor ?>
      </tr>

      <?php for ($i = 0; $i < ($jmlAlternatif + 1); $i++): ?>
        
        <tr>

        <?php for ($j = 0; $j < ($jmlAlternatif); $j++): ?>

          <?php if ($i < $jmlAlternatif): ?>

            <?php
            $matriksPerbandinganKriteria[$currentKriteria][$i][$j] = ($i === $j)
              ? 1
              : $alternatif[$i][$currentKriteria] / $alternatif[$j][$currentKriteria];

            @$totalMatriksPerbandinganKriteria[$currentKriteria][$j] += $matriksPerbandinganKriteria[$currentKriteria][$i][$j];

            $formattedMatriksPerbandinganKriteria[$currentKriteria][$i][$j] = number_format($matriksPerbandinganKriteria[$currentKriteria][$i][$j], 3, ',', '.');

            $formattedTotalMatriksPerbandinganKriteria[$currentKriteria][$j] = number_format($totalMatriksPerbandinganKriteria[$currentKriteria][$j], 3, ',', '.');
            ?>

            <?php if ($j === 0): ?>

              <td><?= $alternatif[$i]['kode_alternatif'] ?></td>

            <?php endif ?>

            <td><?= $formattedMatriksPerbandinganKriteria[$currentKriteria][$i][$j] ?></td>
        
          <!-- Last row -->
          <?php else: ?>

            <?php if ($j === 0): ?>

              <td>Jumlah</td>

            <?php endif ?>

            <td><?= $formattedTotalMatriksPerbandinganKriteria[$currentKriteria][$j] ?></td>
            
          <?php endif ?>
            
        <?php endfor ?>

      <?php endfor ?>
    </tbody>
  </table>


  <h4>Normalisasi Matriks Perbandingan Berpasangan</h4>

  <table border="1" cellspacing="0" cellpadding="3">
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
          <td><?= $alternatif[$i]['kode_alternatif'] ?></td>
        <?php endfor ?>
      </tr>

      <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
        
        <tr>

        <?php for ($j = 0; $j < ($jmlAlternatif); $j++): ?>

          <?php if ($j === 0): ?>

            <td><?= $alternatif[$i]['kode_alternatif'] ?></td>

          <?php endif ?>

          <td><?= "{$formattedMatriksPerbandinganKriteria[$currentKriteria][$i][$j]} / {$formattedTotalMatriksPerbandinganKriteria[$currentKriteria][$j]}" ?></td>
            
        <?php endfor ?>

      <?php endfor ?>
    </tbody>
  </table>


  <h4>Hasil Normalisasi dan Nilai Rata-Rata W<sub>j</sub></h4>

  <table border="1" cellspacing="0" cellpadding="3">
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
          <td><?= $alternatif[$i]['kode_alternatif'] ?></td>
        <?php endfor ?>
        <td>Rata-Rata</td>
      </tr>

      <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
        
        <tr>

        <?php for ($j = 0; $j < ($jmlAlternatif + 1); $j++): ?>

          <?php if ($j === 0): ?>

            <td><?= $alternatif[$i]['kode_alternatif'] ?></td>

          <?php endif ?>

          <?php if ($j < $jmlAlternatif): ?>

            <?php
            $hasilMatriksPerbandinganKriteria[$currentKriteria][$i][$j] = $matriksPerbandinganKriteria[$currentKriteria][$i][$j] / $totalMatriksPerbandinganKriteria[$currentKriteria][$j];

            @$rataHasilMatriksPerbandinganKriteria[$currentKriteria][$i] += $hasilMatriksPerbandinganKriteria[$currentKriteria][$i][$j] ?? 0;

            $formattedHasilMatriksPerbandinganKriteria[$currentKriteria][$i][$j] = number_format($hasilMatriksPerbandinganKriteria[$currentKriteria][$i][$j], 3, ',', '.');
            ?>

            <td><?= $formattedHasilMatriksPerbandinganKriteria[$currentKriteria][$i][$j] ?></td>

          <?php else: ?>

            <?php
            $rataHasilMatriksPerbandinganKriteria[$currentKriteria][$i] /= $jmlAlternatif;

            $formattedRataHasilMatriksPerbandinganKriteria[$currentKriteria][$i] = number_format($rataHasilMatriksPerbandinganKriteria[$currentKriteria][$i], 3, ',', '.');
            ?>

            <td><?= $formattedRataHasilMatriksPerbandinganKriteria[$currentKriteria][$i] ?></td>
            
          <?php endif ?>
            
        <?php endfor ?>

      <?php endfor ?>
    </tbody>
  </table>

<?php endfor ?>

<!-- END ALL CRITERIAS -->


<h4>Nilai Perkalian Bobot Kriteria dan Alternatif yang Selesai Dihitung</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <thead>
    <tr>
      <?php for ($i = 1; $i <= ($jmlKriteria); $i++): ?>
        <th><?= "K{$i}" ?></th>
      <?php endfor ?>
      <th>Nilai Bobot Kriteria W<sub>j</sub></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $jmlRataMatriksPerbandingan = count($rataMatriksPerbandingan);
    $barisTambahanPerkalianBobotDanAlternatif = $jmlRataMatriksPerbandingan - $jmlAlternatif;
    $jmlBarisNilaiPerkalianBobotDanAlternatif = $jmlAlternatif + $barisTambahanPerkalianBobotDanAlternatif;
    ?>

    <?php for ($i = 0; $i < ($jmlBarisNilaiPerkalianBobotDanAlternatif); $i++): ?>
      
      <tr>

      <?php for ($j = 0; $j < ($jmlKriteria + 1); $j++): ?>

        <?php
        if (
          $i === ($jmlBarisNilaiPerkalianBobotDanAlternatif - 1)
          && $barisTambahanPerkalianBobotDanAlternatif > 0
          && $j < ($jmlKriteria)
        ):
        ?>

          <td>&nbsp;</td>

        <?php elseif ($j < ($jmlKriteria)): ?>

          <?php
          $currentKriteria = $kriteria[$j]['nama_kriteria'];

          $bobotKriteria[$i][$currentKriteria] = $rataHasilMatriksPerbandinganKriteria[$currentKriteria][$i];

          $formattedBobotKriteria[$i][$currentKriteria] = number_format($bobotKriteria[$i][$currentKriteria], 3, ',', '.');
          ?>

          <td><?= $formattedBobotKriteria[$i][$currentKriteria] ?></td>

        <?php else: ?>

          <td><?= $formattedRataMatriksPerbandingan[$i] ?></td>
          
        <?php endif ?>

      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>


<h4>Hasil Nilai Perkalian Bobot Kriteria dan Alternatif yang Selesai Dihitung</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <thead>
    <tr>
      <?php for ($i = 1; $i <= ($jmlKriteria); $i++): ?>
        <th><?= "K{$i}" ?></th>
      <?php endfor ?>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
      
      <tr>

      <?php for ($j = 0; $j < ($jmlKriteria + 1); $j++): ?>

        <?php if ($j < ($jmlKriteria)): ?>

          <?php
          $currentKriteria = $kriteria[$j]['nama_kriteria'];

          $hasilPerkalianBobotKriteriaDanAlternatif[$i][$currentKriteria] = $bobotKriteria[$i][$currentKriteria] * $rataMatriksPerbandingan[$j];

          @$totalHasilPerkalianBobotKriteriaDanAlternatif[$i] += $hasilPerkalianBobotKriteriaDanAlternatif[$i][$currentKriteria];

          $formattedHasilPerkalianBobotKriteriaDanAlternatif[$i][$currentKriteria] = number_format($hasilPerkalianBobotKriteriaDanAlternatif[$i][$currentKriteria], 3, ',', '.');

          $formattedTotalHasilPerkalianBobotKriteriaDanAlternatif[$i] = number_format($totalHasilPerkalianBobotKriteriaDanAlternatif[$i], 3, ',', '.');
          ?>

          <td><?= $formattedHasilPerkalianBobotKriteriaDanAlternatif[$i][$currentKriteria] ?></td>

        <?php else: ?>

          <td><?= $formattedTotalHasilPerkalianBobotKriteriaDanAlternatif[$i] ?></td>
          
        <?php endif ?>

      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>


<h4>Ranking</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <thead>
    <tr>
      <th>No</th>
      <th>Alternatif</th>
      <th>Nilai Akhir</th>
      <th>Ranking</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $kodeAlternatif = array_column($alternatif, 'kode_alternatif');
    $nilaiAkhirs    = $totalHasilPerkalianBobotKriteriaDanAlternatif;
    $dataRankings   = getRankingAlternatif($kodeAlternatif, $nilaiAkhirs);
    ?>

    <?php foreach($dataRankings['data'] as $dataRanking): ?>

      <tr>
        <td><?= $no++ ?></td>
        <td><?= $dataRanking['kode_alternatif'] ?></td>
        <td><?= number_Format($dataRanking['nilai_akhir'], 3, ',', '.') ?></td>
        <td><?= $dataRanking['rank'] ?></td>
      </tr>
      
    <?php endforeach ?>
  </tbody>
</table>