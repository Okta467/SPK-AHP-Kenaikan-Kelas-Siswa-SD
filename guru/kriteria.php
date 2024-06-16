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

  <meta name="Description" content="Data Kriteria"> 
  <title>Data Kriteria - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Kriteria</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk melihat data kriteria.</h6>
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
                  <h4 class="card-title"><i class="ti-agenda mr-2"></i>Data Kriteria</h4>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tingkat Kepentingan</th>
                        <th>Status Aktif</th>
                        <th>Daftar Sub Kriteria</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      $query_kriteria = mysqli_query($connection, 
                        "SELECT 
                          a.id AS id_kriteria, a.kode_kriteria, a.nama_kriteria, a.status_aktif,
                          b.id AS id_tingkat_kepentingan, b.nilai_kepentingan, b.keterangan,
                          IFNULL(c.jml_sub_kriteria, 0) AS jml_sub_kriteria
                        FROM tbl_kriteria AS a
                        LEFT JOIN tbl_tingkat_kepentingan AS b
                          ON a.id_tingkat_kepentingan = b.id
                        LEFT JOIN
                        (
                          SELECT id_kriteria, count(id) AS jml_sub_kriteria FROM tbl_sub_kriteria
                          GROUP BY id_kriteria
                        ) AS c
                          ON c.id_kriteria = a.id
                        ORDER BY a.id DESC");

                      while ($kriteria = mysqli_fetch_assoc($query_kriteria)):
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $kriteria['kode_kriteria'] ?></td>
                          <td><?= $kriteria['nama_kriteria'] ?></td>
                          <td><?= $kriteria['nilai_kepentingan'] ?></td>
                          <td><input type="checkbox" class="js-switch" data-id_kriteria="<?= $kriteria['id_kriteria'] ?>" <?= $kriteria['status_aktif'] ? 'checked' : '' ?> readonly></td>
                          <td>
                            <?php if ($kriteria['jml_sub_kriteria'] === 0): ?>
                              <small class="text-muted">Tidak ada</small>
                            <?php else: ?>
                              <button type="button" class="btn btn-outline-dark btn-icon-text py-1 toggle_daftar_sub_kriteria" data-id_kriteria="<?= $kriteria['id_kriteria'] ?>">
                                <div class="badge badge-pill badge-outline-dark py-1 px-2 mr-2"><?= $kriteria['jml_sub_kriteria'] ?></div>
                                Lihat Sub Kriteria
                                <i class="ti-list-ol btn-icon-append ml-1"></i>
                              </button>
                            <?php endif ?>
                          </td>
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


  <!--============================= MODAL DAFTAR SUB KRITERIA =============================-->
  <div class="modal fade" id="ModalDaftarKriteria" tabindex="-1" role="dialog" aria-labelledby="ModalDaftarKriteria" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="ti-agenda mr-2"></i>Daftar Sub Kriteria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <table class="table table-striped" id="tabel_daftar_sub_kriteria">
            <thead>
              <tr>
                <th>#</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Batas Bawah - Atas</th>
                <th>Range Nilai</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
  <!--/.modal-daftar-sub-kriteria -->


  <?php include '_partials/script.php' ?>
  <?php include '../helpers/sweetalert_notify.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      $(".datatables").DataTable({});
      
      var datatableDaftarSubKriteria = $('#tabel_daftar_sub_kriteria').DataTable({
        fixedHeader: true,
        pageLength: 5,
        lengthMenu: [
          [3, 5, 10, 25, 50, 100],
          [3, 5, 10, 25, 50, 100],
        ]
      });
      
      $('.select2').select2({
        width: '100%'
      });

      initAllSwitcheryJs();

      
      $('.datatables').on('click', '.toggle_daftar_sub_kriteria', function() {
        const id_kriteria = $(this).data('id_kriteria');
      
        $.ajax({
          url: 'get_sub_kriteria.php',
          method: 'POST',
          dataType: 'JSON',
          data: {
            'id_kriteria': id_kriteria
          },
          success: function(data) {
            // add datatables row
            let i = 1;
            let rowsData = [];
            
            for (key in data) {
              rowsData.push([
                i++, 
                data[key]['kode_sub_kriteria'], 
                data[key]['nama_sub_kriteria'], 
                `${data[key]['batas_bawah']} - ${data[key]['batas_bawah']}`,
                data[key]['range_nilai']
              ]);
            }
            
            datatableDaftarSubKriteria.clear().draw();
            datatableDaftarSubKriteria.rows.add(rowsData).draw();
            
            $('#ModalDaftarKriteria').modal('show');
          },
          error: function(request, status, error) {
            // console.log("ajax call went wrong:" + request.responseText);
            console.log("ajax call went wrong:" + error);
          }
        })
      });

    });
  </script>

</body>

</html>

<?php endif ?>