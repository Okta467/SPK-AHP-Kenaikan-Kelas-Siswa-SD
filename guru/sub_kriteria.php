<?php
include '../helpers/user_login_checker.php';

// cek apakah user yang mengakses adalah guru?
if (!isAccessAllowed('guru')):
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else:
  include_once '../config/connection.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '_partials/head.php' ?>

  <meta name="Description" content="Data Sub Kriteria">
  <title>Data Sub Kriteria - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Sub Kriteria</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk melihat data sub_kriteria.</h6>
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
            
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                  <h4 class="card-title"><i class="ti-agenda mr-2"></i>Data Sub Kriteria</h4>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Kode Sub</th>
                        <th>Nama Sub</th>
                        <th>Batas Nilai (Bawah - Atas)</th>
                        <th>Range Nilai</th>
                        <th>Kode Kriteria</th>
                        <th>Nama Kriteria</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      $query_sub_kriteria = mysqli_query($connection, 
                        "SELECT
                          a.id AS id_sub_kriteria, a.kode_sub_kriteria, a.nama_sub_kriteria,
                          b.id AS id_kriteria, b.kode_kriteria, b.nama_kriteria, b.status_aktif,
                          c.id AS id_tingkat_kepentingan, c.nilai_kepentingan, c.keterangan,
                          d.id AS id_range_nilai, d.batas_bawah, d.batas_atas, d.range_nilai
                        FROM tbl_sub_kriteria AS a
                        LEFT JOIN tbl_kriteria AS b
                          ON a.id_kriteria = b.id
                        LEFT JOIN tbl_tingkat_kepentingan AS c
                          ON b.id_tingkat_kepentingan = c.id
                        LEFT JOIN tbl_range_nilai AS d
                          ON a.id_range_nilai = d.id
                        ORDER BY a.id DESC");

                      while ($sub_kriteria = mysqli_fetch_assoc($query_sub_kriteria)):
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $sub_kriteria['kode_sub_kriteria'] ?></td>
                          <td><?= $sub_kriteria['nama_sub_kriteria'] ?></td>
                          <td><?= "{$sub_kriteria['batas_bawah']} - {$sub_kriteria['batas_atas']}" ?></td>
                          <td><?= $sub_kriteria['range_nilai'] ?></td>
                          <td><?= $sub_kriteria['kode_kriteria'] ?></td>
                          <td><?= $sub_kriteria['nama_kriteria'] ?></td>
                        </tr>

                      <?php endwhile ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
            
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
  <?php include '../helpers/sweetalert_notify.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      $(".datatables").DataTable({});
      
      $('.select2').select2({
        width: '100%'
      });

    });
  </script>

</body>

</html>

<?php endif ?>