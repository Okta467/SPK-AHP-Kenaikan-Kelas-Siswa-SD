<?php
include '../helpers/user_login_checker.php';

// cek apakah user yang mengakses adalah admin?
if (!isAccessAllowed('admin')):
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else:
  include_once '../config/connection.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '_partials/head.php' ?>

  <meta name="Description" content="Dashboard">
  <title>Dashboard Admin - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Selamat datang, Admin!</h3>
                  <h6 class="font-weight-normal mb-0"><?= 'Di ' . SITE_NAME . '.' ?></h6>
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


          <div class="row">

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">
                  <img src="<?= base_url('assets/images/dashboard/people.svg') ?>" alt="people">
                  <div class="weather-info">
                    <div class="d-flex">
                      <div>
                        <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i><?= rand(27, 33) ?><sup>C</sup></h2>
                      </div>
                      <div class="ml-2">
                        <h4 class="location font-weight-normal">Palembang</h4>
                        <h6 class="font-weight-normal">Indonesia</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/.col -->

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tindakan</h4>
                  <p class="card-description">Tindakan yang dapat dilakukan sebagai <span class="text-danger font-weight-bold">Admin</span>:</p>
                  <ul>
                    <li>Mengelola <a href="pengguna.php?go=pengguna" class="font-weight-bold">Pengguna</a></li>
                    <li>Mengelola <a href="siswa.php?go=siswa" class="font-weight-bold">Siswa</a> dan <a class="font-weight-bold">Guru</a></li>
                    <li>Mengelola <a href="kelas.php?go=kelas" class="font-weight-bold">Kelas</a></li>
                    <li>Mengelola <a href="jabatan.php?go=jabatan" class="font-weight-bold">Jabatan</a></li>
                    <li>Mengelola <a href="pangkat_golongan.php?go=pangkat_golongan" class="font-weight-bold">Pangkat/Golongan</a></li>
                    <li>Mengelola <a href="pendidikan.php?go=pendidikan" class="font-weight-bold">Pendidikan</a> dan <a href="jurusan_pendidikan.php?go=jurusan_pendidikan" class="font-weight-bold">Jurusan</a></li>
                    <li>Mengelola data <span class="font-weight-bold">SPK</span>, yaitu:
                      <ol>
                        <li><a href="alternatif.php?go=alternatif" class="font-weight-bold">Alternatif</a></li>
                        <li><a href="kriteria.php?go=kriteria" class="font-weight-bold">Kriteria</a> dan <a href="sub_kriteria.php?go=sub_kriteria" class="font-weight-bold">Sub Kriteria</a></li>
                      </ol>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <!--/.col -->

          </div>
          <!--/.row -->

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

</body>

</html>

<?php endif ?>