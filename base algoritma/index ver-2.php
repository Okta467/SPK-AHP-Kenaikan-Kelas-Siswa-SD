<?php
  include_once 'getStringTingkatKepentinganHelper.php';
  include_once 'getIntTingkatKepentinganHelper.php';

  $alternatif = [
    ['kode_alternatif' => 'A1', 'kehadiran' => 3, 'harian' => 4, 'tugas' => 5, 'uas' => 4],
    ['kode_alternatif' => 'A2', 'kehadiran' => 5, 'harian' => 4, 'tugas' => 4, 'uas' => 3],
    ['kode_alternatif' => 'A3', 'kehadiran' => 4, 'harian' => 3, 'tugas' => 5, 'uas' => 4],
    ['kode_alternatif' => 'A4', 'kehadiran' => 4, 'harian' => 4, 'tugas' => 3, 'uas' => 3],
  ];

  $kriteria = [
    ['nama_kriteria' => 'kehadiran', 'nilai_kepentingan' => 1],
    ['nama_kriteria' => 'harian', 'nilai_kepentingan' => 3],
    ['nama_kriteria' => 'tugas', 'nilai_kepentingan' => 5],
    ['nama_kriteria' => 'uas', 'nilai_kepentingan' => 7],
  ];
    
  $jmlKriteria = count($kriteria);

  $matriksPerbandinganBerpasangan = array();

  $totalMatriksPerbandinganBerpasangan = array();

  $hasilMatriksPerbandingan = array();

  $rataHasilMatriksPerbandingan = array();


  $formattedNormalisasiMatriks = array();

  $formattedTotalMatriksPerbandinganBerpasangan = array();

  $formattedHasilNormalisasiMatriks = array();

  $formattedRataHasilMatriksPerbandingan = array();
?>

<h4>Properti Untuk Masing-masing Alternatif</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <thead>
    <tr>
      <th>No</th>
      <th>Alternatif</th>
      <th>Kehadiran</th>
      <th>Harian</th>
      <th>Tugas</th>
      <th>UAS</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; ?>
    <?php for ($i = 0; $i < count($alternatif); $i++): ?>

      <tr>
        <td><?= $no++ ?></td>
        <td><?= $alternatif[$i]['kode_alternatif'] ?></td>
        <td><?= $alternatif[$i]['kehadiran'] ?></td>
        <td><?= $alternatif[$i]['harian'] ?></td>
        <td><?= $alternatif[$i]['tugas'] ?></td>
        <td><?= $alternatif[$i]['uas'] ?></td>
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
          <td><?= $tingkatKepentingan['data'] ?></td>

        <?php else: ?>

          <td><?= $tingkatKepentingan['data'] ?></td>
      
        <?php endif ?>

      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>


<h4>Normalisasi Matriks Perbandingan Berpasangan</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <tbody>
    <?php $totalMatriksPerbandinganBerpasangan = array(); ?>

    <?php for ($i = 0; $i < ($jmlKriteria + 2); $i++): ?>
      
      <tr>

      <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>

        <!-- First row -->
        <?php if ($i === 0 && $j === 0): ?>

          <td>&nbsp;</td>
          
        <?php endif ?>

        <?php if ($i === 0): ?>

          <td><?= $kriteria[$j]['nama_kriteria'] ?></td>

        <!-- Second row -->
        <?php elseif ($i < ($jmlKriteria + 1)): ?>
            
          <?php
          $firstKepentinganTmp  = $kriteria[$i-1]['nilai_kepentingan'];
          $secondKepentinganTmp = $kriteria[$j]['nilai_kepentingan'];

          $tingkatKepentingan   = getIntTingkatKepentingan($firstKepentinganTmp, $secondKepentinganTmp);
          $firstKepentingan     = $tingkatKepentingan['data']['first'];
          $secondKepentingan    = $tingkatKepentingan['data']['second'];

          $matriksPerbandinganBerpasangan[$i-1][$j] = $firstKepentingan / $secondKepentingan;
          
          @$totalMatriksPerbandinganBerpasangan[$j] += $matriksPerbandinganBerpasangan[$i-1][$j];

          $formattedNormalisasiMatriks[$i-1][$j] = number_format($matriksPerbandinganBerpasangan[$i-1][$j], 3, ',', '.');

          $formattedTotalMatriksPerbandinganBerpasangan[$j] = number_format($totalMatriksPerbandinganBerpasangan[$j], 3, ',', '.');
          ?>

          <?php if ($j === 0): ?>

            <td><?= $kriteria[$i-1]['nama_kriteria'] ?></td>
            <td><?= $formattedNormalisasiMatriks[$i-1][$j] ?></td>

          <?php else: ?>

            <td><?= $formattedNormalisasiMatriks[$i-1][$j] ?></td>
        
          <?php endif ?>

        <!-- Last row -->
        <?php else: ?>

          <?php if ($j === 0): ?>

            <td>Nilai</td>
            <td><?= $formattedTotalMatriksPerbandinganBerpasangan[$j] ?></td>
          
          <?php else: ?>

            <td><?= $formattedTotalMatriksPerbandinganBerpasangan[$j] ?></td>

          <?php endif ?>
          
        <?php endif ?>

      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>


<h4>Matriks Perbandingan Berpasangan</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <tbody>
    <?php for ($i = 0; $i < ($jmlKriteria + 1); $i++): ?>
      
      <tr>

      <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>

        <!-- First row -->
        <?php if ($i === 0 && $j === 0): ?>

          <td>&nbsp;</td>
          
        <?php endif ?>

        <?php if ($i === 0): ?>

          <td><?= $kriteria[$j]['nama_kriteria'] ?></td>

        <!-- Second row -->
        <?php else: ?>

          <?php if ($j === 0): ?>

            <td><?= $kriteria[$i-1]['nama_kriteria'] ?></td>
            <td><?= "{$formattedNormalisasiMatriks[$i-1][$j]} / {$formattedTotalMatriksPerbandinganBerpasangan[$j]}" ?></td>

          <?php else: ?>

            <td><?= "{$formattedNormalisasiMatriks[$i-1][$j]} / {$formattedTotalMatriksPerbandinganBerpasangan[$j]}" ?></td>
        
          <?php endif ?>
          
        <?php endif ?>

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

      <?php for ($j = 0; $j < ($jmlKriteria + 2); $j++): ?>

        <?php if ($j == 0): ?>

          <td><?= 'K' . ($i + 1) ?></td>

        <?php elseif ($j < ($jmlKriteria)): ?>

          <?php
          $hasilMatriksPerbandingan[$i][$j] = $matriksPerbandinganBerpasangan[$i][$j] / $totalMatriksPerbandinganBerpasangan[$j];
          
          @$rataHasilMatriksPerbandingan[$i] += $hasilMatriksPerbandingan[$i][$j];

          $formattedHasilNormalisasiMatriks[$i][$j] = number_format($hasilMatriksPerbandingan[$i][$j], 3, ',', '.');
          ?>
          
          <td><?= $formattedHasilNormalisasiMatriks[$i][$j] ?></td>
        
        <?php else: ?>

          <?php
          $rataHasilMatriksPerbandingan[$i] /= $jmlKriteria;
          $formattedRataHasilMatriksPerbandingan[$i] = number_format($rataHasilMatriksPerbandingan[$i], 3, ',', '.');
          ?>

          <td><?= $formattedRataHasilMatriksPerbandingan[$i] ?></td>

        <?php endif ?>

      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>


<h4>Matriks Perbandingan Berpasangan</h4>

<table border="1" cellspacing="0" cellpadding="3">
  <tbody>
    <?php for ($i = 0; $i < ($jmlKriteria + 1); $i++): ?>
      
      <tr>

      <?php for ($j = 0; $j < ($jmlKriteria + 2); $j++): ?>

        <!-- First row -->
        <?php if ($i === 0): ?>

          <?php if ($j == 0): ?>

            <td>&nbsp;</td>

          <?php elseif ($j < $jmlKriteria): ?>

            <td><?= $kriteria[$j]['nama_kriteria'] ?></td>

          <?php elseif ($j < ($jmlKriteria + 1)): ?>

            <td>Nilai Bobot Kriteria (W<sub>j</sub>)</td>

          <?php else: ?>

            <td>Hasil Perkalian Matriks</td>

          <?php endif ?>

        <!-- Second row -->
        <?php else: ?>

          <?php if ($j === 0): ?>

            <td><?= $kriteria[$i-1]['nama_kriteria'] ?></td>
            <td><?= "{$formattedNormalisasiMatriks[$i-1][$j]} / {$formattedTotalMatriksPerbandinganBerpasangan[$j]}" ?></td>

          <?php elseif ($j < ($jmlKriteria)): ?>

            <td><?= "{$formattedNormalisasiMatriks[$i-1][$j]} / {$formattedTotalMatriksPerbandinganBerpasangan[$j]}" ?></td>
            
          <?php elseif ($j < ($jmlKriteria + 1)): ?>

          <?php else: ?>

            <td>&nbsp;</td>
        
          <?php endif ?>
          
        <?php endif ?>

      <?php endfor ?>
      
      </tr>

    <?php endfor ?>
  </tbody>
</table>