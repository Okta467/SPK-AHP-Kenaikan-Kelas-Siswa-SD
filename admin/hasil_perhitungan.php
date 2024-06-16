<?php
include '../helpers/user_login_checker.php';

// cek apakah user yang mengakses adalah admin?
if (!isAccessAllowed('admin')):
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
    include_once 'get_hasil_perhitungan.php';
  endif;
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '_partials/head.php' ?>

  <meta name="Description" content="Data Penilaian Alternatif">
  <title>Data Penilaian Alternatif - <?= SITE_NAME ?></title>
</head>

<body>
  <!--============================= CONTAINER =============================-->
  <div class="container-scroller">

    <!--============================= NAVBAR =============================-->
    <?php include '_partials/navbar.php' ?>
    <!--//END CONTENT -->
    
    <!--============================= WRAPPER =============================-->
    <div class="container-fluid page-body-wrapper">

      <!--============================= SIDEBAR =============================-->
      <?php include '_partials/sidebar.php' ?>
      <!--//END SIDEBAR -->

      <!--============================= CONTENT =============================-->
      <div class="main-panel">
        <div class="content-wrapper">

          <!-- Main Content Header -->
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Halaman Penilaian Alternatif</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data penilaian alternatif.</h6>
                </div>
                <div class="col-12 col-xl-4">
                  <div class="justify-content-end d-flex">
                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                      <button class="btn btn-sm btn-light bg-white" type="button" id="dropdownMenuDate2">
                        <i class="mdi mdi-calendar align-middle"></i> Tanggal: <?= date('d M Y') ?>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.main-content-header -->


          <!-- TOOLS HASIL PERHITUNGAN -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-settings mr-2"></i>Tools Hasil Perhitungan</h4>
                  </div>
                  <p class="card-description">
                    Harap input <span class="text-danger font-weight-bold">filter data</span> berikut untuk melihat hasil perhitungan alternatif.
                  </p>
                  <form action="hasil_perhitungan.php" method="GET">

                    <input type="hidden" name="go" value="penilaian_alternatif">
                  
                    <div class="form-group row">

                      <div class="col-sm-2">
                        <label for="kelas_filter">Kelas</label>
                        <select name="id_kelas_filter" class="form-control form-control-sm select2 kelas_filter" id="kelas_filter" required style="width: 100%">
                          <option value="">-- Pilih --</option>
                          <?php
                          $query_kelas = mysqli_query($connection, "SELECT id, nama_kelas FROM tbl_kelas ORDER BY nama_kelas ASC");

                          while ($kelas = mysqli_fetch_assoc($query_kelas)):
                            $select_kelas_filter = ($id_kelas_filter === $kelas['id']) ? 'selected' : '';
                          ?>

                            <option value="<?= $kelas['id'] ?>" <?= $select_kelas_filter ?>><?= $kelas['nama_kelas'] ?></option>
                            
                          <?php endwhile ?>
                        </select>
                      </div>
                      
                      <div class="col-sm-2">
                        <label for="id_tahun_akademik_filter">Tahun Akademik</label>
                        <select name="id_tahun_akademik_filter" class="form-control form-control-sm select2 id_tahun_akademik_filter" id="id_tahun_akademik_filter" required style="width: 100%">
                          <option value="">-- Pilih --</option>
                          <?php
                          $query_tahun_akademik = mysqli_query($connection, "SELECT id, dari_tahun, sampai_tahun FROM tbl_tahun_akademik ORDER BY dari_tahun DESC");

                          while ($tahun_akademik = mysqli_fetch_assoc($query_tahun_akademik)):
                            $select_tahun_akademik = ($id_tahun_akademik_filter === $tahun_akademik['id'])? 'selected' : '';
                          ?>

                            <option value="<?= $tahun_akademik['id'] ?>" <?= $select_tahun_akademik ?>><?= "{$tahun_akademik['dari_tahun']} / {$tahun_akademik['sampai_tahun']}" ?></option>
                            
                          <?php endwhile ?>
                        </select>
                      </div>
                      
                      <div class="col-sm-2 d-flex align-items-end mt-3">
                        <button type="submit" class="btn btn-md btn-dark btn-icon-text toggle_modal_tambah">Filter Data</button>
                      </div>

                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!--/.tools-hasil-perhitungan -->

          <?php if (!$id_kelas_filter && !$id_tahun_akademik_filter): ?>

          <!-- EMPTY DATA -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Data Hasil Perhitungan</h4>
                  </div>
                  <p class="card-description">Pilih <span class="text-danger font-weight-bold">kelas</span> dan <span class="text-danger font-weight-bold">tahun akademik</span> terlebih dahulu!</p>
                  <div class="table-responsive">
                    <table class="table table-striped datatables">
                      <thead>
                        <th>#</th>
                        <th>Data Hasil Perhitungan</th>
                      </thead>
                      <tbody>
                        <!-- Empty data .... -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.empty-data -->

          <?php else: ?>

          <!-- Properti Untuk Masing-masing Alternatif -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Properti Untuk Masing-masing Alternatif</h4>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped datatables">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Alternatif</th>
                          <?php for ($i = 0; $i < $jmlKriteria; $i++): ?>
                            <th><?= $kriteria[$i]['nama_kriteria'] ?></th>
                          <?php endfor ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1; ?>
                        <?php for ($i = 0; $i < $jmlAlternatif; $i++) : ?>
          
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $alternatif[$i]['kode_alternatif'] ?></td>

                            <?php for ($j = 0; $j < $jmlKriteria; $j++) : 
                              $nama_kriteria = $kriteria[$j]['nama_kriteria'];?>

                              <td><?= $alternatif[$i][$nama_kriteria] ?></td>

                            <?php endfor ?>

                          </tr>
          
                        <?php endfor ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.properti-untuk-masing-masing-alternatif -->


          <!-- Matriks Perbandingan Berpasangan Setiap Kriteria -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Matriks Perbandingan Berpasangan Setiap Kriteria</h4>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped datatables">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>&nbsp;</th>
                          <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
                            <th><?= $kriteria[$i]['nama_kriteria'] ?></th>
                          <?php endfor ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
                          
                          <tr>
                            
                            <td><?= ($i + 1) ?></td>
                    
                          <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>
                                
                            <?php
                            $firstKepentingan = $kriteria[$i]['nilai_kepentingan'];
                            $secondKepentingan = $kriteria[$j]['nilai_kepentingan'];
                            $tingkatKepentingan = getStringTingkatKepentingan($firstKepentingan, $secondKepentingan);
                            ?>
                    
                            <?php if ($j === 0): ?>
                    
                              <td class="font-weight-bold"><?= $kriteria[$i]['nama_kriteria'] ?></td>
                    
                            <?php endif ?>
                    
                            <td><?= $tingkatKepentingan['data'] ?></td>
                    
                          <?php endfor ?>
                          
                          </tr>
                    
                        <?php endfor ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.matriks-perbandingan-berpasangan-setiap-kriteria -->


          <!-- Normalisasi Matriks Perbandingan Berpasangan -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Normalisasi Matriks Perbandingan Berpasangan</h4>
                  </div>
                  <p class="card-description">Baris kolom <span class="text-danger">Nilai</span> merupakan total keseluruhan tiap kolom dari kriteria.</p>
                  <div class="table-responsive">
                    <table class="table table-striped datatables">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>&nbsp;</th>
                          <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
                            <th><?= $kriteria[$i]['nama_kriteria'] ?></th>
                          <?php endfor ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
                          
                          <tr>

                            <td><?= ($i + 1) ?></td>
                    
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
                  
                            <?php if ($j === 0): ?>
                  
                              <td class="font-weight-bold"><?= $kriteria[$i]['nama_kriteria'] ?></td>
                  
                            <?php endif ?>
                  
                            <td><?= $formattedNormalisasiMatriks[$i][$j] ?></td>
                    
                          <?php endfor ?>
                          
                          </tr>
                    
                        <?php endfor ?>
                      </tbody>
                      <tfoot>
                        <tr class="table-info">
                          <td>&nbsp;</td>
                          <td class="font-weight-bold">Nilai</td>
                          <?php for ($i = 0; $i < $jmlKriteria; $i++): ?>
                            <td class="font-weight-bold"><?= $formattedTotalNormalisasiMatriks[$i] ?></td>
                          <?php endfor ?>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.normalisasi-matriks-perbandingan-berpasangan -->


          <!-- Matriks Perbandingan Berpasangan -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Matriks Perbandingan Berpasangan</h4>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped datatables">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>&nbsp;</th>
                          <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
                            <th><?= $kriteria[$i]['nama_kriteria'] ?></th>
                          <?php endfor ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
                          
                          <tr>
                            <td><?= ($i + 1) ?></td>
                    
                          <?php for ($j = 0; $j < ($jmlKriteria); $j++): ?>
                    
                            <?php if ($j === 0): ?>
                    
                              <td class="font-weight-bold"><?= $kriteria[$i]['nama_kriteria'] ?></td>
                    
                            <?php endif ?>
                    
                            <td><?= "{$formattedNormalisasiMatriks[$i][$j]} / {$formattedTotalNormalisasiMatriks[$j]}" ?></td>
                            
                          <?php endfor ?>
                          
                          </tr>
                    
                        <?php endfor ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.matriks-perbandingan-berpasangan -->


          <!-- Matriks Perbandingan -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Matriks Perbandingan</h4>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped datatables w-100">
                      <thead>
                        <tr>
                          <th rowspan="2">#</th>
                          <th colspan="<?= $jmlKriteria + 1 ?>">Nilai Matriks Perbandingan Kriteria</th>
                          <th rowspan="2">Rata-Rata (Nilai Bobot Kriteria [W<sub>j</sub>])</th>
                        </tr>
                        <tr>
                          <?php for ($i = 0; $i < ($jmlKriteria + 1); $i++): ?>
                            <?php if ($i === 0): ?>
                              <th class="d-none">Kriteria</th>
                            <?php else: ?>
                              <th class="d-none">Nilai</th>
                            <?php endif ?>
                          <?php endfor ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
                          
                          <tr>

                            <td><?= ($i + 1) ?></td>
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
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.matriks-perbandingan -->


          <!-- Normalisasi Perbandingan Berpasangan * Nilai Bobot Kriteria (Wj) -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Normalisasi Perbandingan Berpasangan * Nilai Bobot Kriteria (W<sub>j</sub>)</h4>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped datatables w-100">
                      <thead>
                        <tr>
                          <th rowspan="2">#</th>
                          <th colspan="<?= $jmlKriteria ?>">Normalisasi Matriks Perbandingan Berpasangan</th>
                          <th rowspan="2">Nilai Bobot Kriteria (W<sub>j</sub>)</th>
                          <th rowspan="2">Hasil Perkalian Matriks</th>
                        </tr>
                        <tr>
                          <?php for ($i = 0; $i < $jmlKriteria; $i++): ?>
                            <th class="d-none">Nilai</th>
                          <?php endfor ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $normalisasiDikaliBobotKriteria = getNormalisasiDikaliBobotKriteria($normalisasiMatriks, $rataMatriksPerbandingan); ?>
                        
                        <?php for ($i = 0; $i < ($jmlKriteria); $i++): ?>
                          
                          <tr>
                    
                            <td><?= ($i + 1) ?></td>
                          
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
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.normalisasi-perbandingan-berpasangan-*-nilai-bobot-kriteria-(wj) -->


          <!-- Konsistensi Nilai -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Konsistensi Nilai</h4>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped">
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
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.konsistensi-nilai -->

          
          <!-- ALL CRITERIAS -->
          
          <?php for ($k = 0; $k < $jmlKriteria; $k++): ?>
          
            <?php $currentKriteria = $kriteria[$k]['nama_kriteria']; ?>
            
            <h3 class="mb-4"><?= '<i class="ti-pencil mr-2"></i> ' . ucwords($kriteria[$k]['nama_kriteria']) ?></h3>


            <!-- Nilai Matriks Perbandingan Berpasangan -->
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                      <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Nilai Matriks Perbandingan Berpasangan</h4>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped datatables w-100">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>&nbsp;</th>
                            <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
                              <th><?= $alternatif[$i]['kode_alternatif'] ?></th>
                            <?php endfor ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
                            
                            <tr>

                              <td><?= ($i + 1) ?></td>
                    
                            <?php for ($j = 0; $j < ($jmlAlternatif); $j++): ?>
                    
                              <?php
                              $matriksPerbandinganKriteria[$currentKriteria][$i][$j] = ($i === $j)
                                ? 1
                                : $alternatif[$i][$currentKriteria] . '/' . $alternatif[$j][$currentKriteria];
                              ?>
                    
                              <?php if ($j === 0): ?>
                    
                                <td class="font-weight-bold"><?= $alternatif[$i]['kode_alternatif'] ?></td>
                    
                              <?php endif ?>
                    
                              <td><?= $matriksPerbandinganKriteria[$currentKriteria][$i][$j] ?></td>
                    
                            <?php endfor ?>
                            
                            </tr>
                    
                          <?php endfor ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/.nilai-matriks-perbandingan-berpasangan -->

            
            <!-- Transformasi Matriks Perbandingan Berpasangan -->
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                      <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Transformasi Matriks Perbandingan Berpasangan</h4>
                    </div>
                    <p class="card-description">
                      Baris kolom <span class="text-danger">Jumlah</span> merupakan total keseluruhan tiap kolom dari kriteria.
                    </p>
                    <div class="table-responsive">
                      <table class="table table-striped datatables w-100">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>&nbsp;</th>
                            <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
                              <th><?= $alternatif[$i]['kode_alternatif'] ?></th>
                            <?php endfor ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
                            
                            <tr>

                              <td><?= ($i + 1) ?></td>
                    
                            <?php for ($j = 0; $j < ($jmlAlternatif); $j++): ?>
                    
                              <?php
                              $matriksPerbandinganKriteria[$currentKriteria][$i][$j] = ($i === $j)
                                ? 1
                                : $alternatif[$i][$currentKriteria] / $alternatif[$j][$currentKriteria];
                  
                              @$totalMatriksPerbandinganKriteria[$currentKriteria][$j] += $matriksPerbandinganKriteria[$currentKriteria][$i][$j];
                  
                              $formattedMatriksPerbandinganKriteria[$currentKriteria][$i][$j] = number_format($matriksPerbandinganKriteria[$currentKriteria][$i][$j], 3, ',', '.');
                  
                              $formattedTotalMatriksPerbandinganKriteria[$currentKriteria][$j] = number_format($totalMatriksPerbandinganKriteria[$currentKriteria][$j], 3, ',', '.');
                              ?>
                  
                              <?php if ($j === 0): ?>
                  
                                <td class="font-weight-bold"><?= $alternatif[$i]['kode_alternatif'] ?></td>
                  
                              <?php endif ?>
                  
                              <td><?= $formattedMatriksPerbandinganKriteria[$currentKriteria][$i][$j] ?></td>
                                
                            <?php endfor ?>
                    
                          <?php endfor ?>
                        </tbody>
                        <tfoot>
                          <tr class="table-info">
                            <td>&nbsp;</td>
                            <td class="font-weight-bold">Jumlah</td>
                            <?php for ($i = 0; $i < $jmlAlternatif; $i++): ?>
                              <td class="font-weight-bold"><?= $formattedTotalMatriksPerbandinganKriteria[$currentKriteria][$i] ?></td>
                            <?php endfor ?>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/.transformasi-matriks-perbandingan-berpasangan -->

            
            <!-- Normalisasi Matriks Perbandingan Berpasangan -->
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                      <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Normalisasi Matriks Perbandingan Berpasangan</h4>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped datatables w-100">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>&nbsp;</th>
                            <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
                              <th><?= $alternatif[$i]['kode_alternatif'] ?></th>
                            <?php endfor ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
                            
                            <tr>

                              <td><?= ($i + 1) ?></td>
                    
                            <?php for ($j = 0; $j < ($jmlAlternatif); $j++): ?>
                    
                              <?php if ($j === 0): ?>
                    
                                <td class="font-weight-bold"><?= $alternatif[$i]['kode_alternatif'] ?></td>
                    
                              <?php endif ?>
                    
                              <td><?= "{$formattedMatriksPerbandinganKriteria[$currentKriteria][$i][$j]} / {$formattedTotalMatriksPerbandinganKriteria[$currentKriteria][$j]}" ?></td>
                                
                            <?php endfor ?>
                    
                          <?php endfor ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/.normalisasi-matriks-perbandingan-berpasangan -->

            
            <!-- Hasil Normalisasi dan Nilai Rata-Rata Wj -->
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                      <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Hasil Normalisasi dan Nilai Rata-Rata W<sub>j</sub></h4>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped datatables w-100">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>&nbsp;</th>
                            <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
                              <th><?= $alternatif[$i]['kode_alternatif'] ?></th>
                            <?php endfor ?>
                            <th>Rata-Rata</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
                            
                            <tr>

                              <td><?= ($i + 1) ?></td>
                    
                            <?php for ($j = 0; $j < ($jmlAlternatif + 1); $j++): ?>
                    
                              <?php if ($j === 0): ?>
                    
                                <td class="font-weight-bold"><?= $alternatif[$i]['kode_alternatif'] ?></td>
                    
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/.hasil-normalisasi-dan-nilai-rata-rata-wj -->
          

          <?php endfor ?>
          
          <!-- END ALL CRITERIAS -->

          
          <!-- Nilai Perkalian Bobot Kriteria dan Alternatif yang Selesai Dihitung -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Nilai Perkalian Bobot Kriteria dan Alternatif yang Selesai Dihitung</h4>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped datatables w-100">
                      <thead>
                        <tr>
                          <th>#</th>
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

                            <td><?= ($i + 1) ?></td>
                    
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
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.nilai-perkalian-bobot-kriteria-dan-alternatif-yang-selesai-dihitung -->

          
          <!-- Hasil Nilai Perkalian Bobot Kriteria dan Alternatif yang Selesai Dihitung -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Hasil Nilai Perkalian Bobot Kriteria dan Alternatif yang Selesai Dihitung</h4>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped datatables w-100">
                      <thead>
                        <tr>
                          <th>#</th>
                          <?php for ($i = 1; $i <= ($jmlKriteria); $i++): ?>
                            <th><?= "K{$i}" ?></th>
                          <?php endfor ?>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i = 0; $i < ($jmlAlternatif); $i++): ?>
                          
                          <tr>
  
                            <td><?= ($i + 1) ?></td>
                    
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
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.hasil-nilai-perkalian-bobot-kriteria-dan-alternatif-yang-selesai-dihitung -->

          
          <!-- Ranking -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-pencil-alt mr-2"></i>Ranking</h4>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped datatables w-100">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Alternatif</th>
                          <th>Nilai Akhir</th>
                          <th>Ranking</th>
                          <th>Keterangan Lulus</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        $kodeAlternatif = array_column($alternatif, 'kode_alternatif');
                        $nilaiAkhirs    = $totalHasilPerkalianBobotKriteriaDanAlternatif;
                        $dataRankings   = getRankingAlternatif($kodeAlternatif, $nilaiAkhirs)['data'];
                        $namaKriterias  = array_map(fn($x) => $x['nama_kriteria'], $kriteria);
                        $kelulusanSiswa = getKelulusanSiswa($alternatif_nilai_siswa, $namaKriterias)['data'];
                        ?>
                    
                        <?php for ($i = 0; $i < count($dataRankings); $i++): ?>
                    
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $dataRankings[$i]['kode_alternatif'] ?></td>
                            <td><?= number_Format($dataRankings[$i]['nilai_akhir'], 3, ',', '.') ?></td>
                            <td><?= $dataRankings[$i]['rank'] ?></td>
                            <td><?=
                              strtolower($kelulusanSiswa[$i]['keterangan_kelulusan']) === 'lulus'
                                ? '<span class="text-success">Lulus</span>'
                                : '<span class="text-danger">Tidak Lulus</span>'
                            ?></td>
                          </tr>
                          
                        <?php endfor ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.ranking -->

          <?php endif ?>
          <!-- End condition from row empty-data above -->

        </div>
        <!-- content-wrapper ends -->

        <!--============================= FOOTER =============================-->
        <?php include '_partials/footer.php' ?>
        <!--//END FOOTER -->

      </div>
      <!--//END CONTENT -->

    </div>
    <!--//END WRAPPER -->
  </div>
  <!--//END CONTAINER -->


  <?php include '_partials/script.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      $(".datatables").DataTable({
        pageLength: 5,
        lengthMenu: [
          [3, 5, 10, 25, 50, 100, -1],
          [3, 5, 10, 25, 50, 100, 'All'],
        ]
      });
      
      $('.select2').select2({
        width: '100%'
      });

      $('.toggle_tooltip').tooltip({
        placement: 'top',
        delay: {
          show: 100,
          hide: 100
        }
      })

    });
  </script>

</body>

</html>

<?php endif ?>