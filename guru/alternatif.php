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

  <meta name="Description" content="Data Alternatif">
  <title>Data Alternatif - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Alternatif</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk melihat data alternatif atau siswa yang guru pimpin sebagai wali kelasnya.</h6>
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
                  <h4 class="card-title"><i class="icon-head mr-2"></i>Data Alternatif</h4>
                </div>
                <p class="card-description">Data alternatif atau siswa <span class="font-weight-bold text-danger">hanya dapat dikelola</span> oleh <span class="font-weight-bold text-danger">Admin</span>. Beberapa siswa <span class="font-weight-bold text-danger">mungkin belum di-input</span> sebagai alternatif oleh Admin.</p>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Kode Alternatif</th>
                        <th>Nama/NISN</th>
                        <th class="text-center">JK</th>
                        <th>Kelas</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
                        <th>Detail Alternatif</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $query_alternatif = mysqli_query($connection, 
                        "SELECT
                          a.id AS id_alternatif, a.kode_alternatif,
                          b.id AS id_siswa, b.nisn, b.nama_siswa, b.jk, b.alamat, b.tmp_lahir, b.tgl_lahir, b.no_telp, b.email,
                          c.id AS id_kelas, c.nama_kelas,
                          d.id AS id_wali_kelas, d.nama_guru AS nama_wali_kelas,
                          e.id AS id_pengguna, e.username, e.hak_akses
                        FROM tbl_alternatif AS a
                        JOIN tbl_siswa AS b
                          ON b.id = a.id_siswa
                        LEFT JOIN tbl_kelas AS c
                          ON c.id = b.id_kelas
                        LEFT JOIN tbl_guru AS d
                          ON d.id = c.id_wali_kelas
                        LEFT JOIN tbl_pengguna AS e
                          ON b.id = e.id_siswa
                        WHERE c.id_wali_kelas = {$_SESSION['id_guru']}
                        GROUP BY a.id
                        ORDER BY a.id DESC");

                      while ($alternatif = mysqli_fetch_assoc($query_alternatif)): ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $alternatif['kode_alternatif'] ?></td>
                          <td><?= htmlspecialchars($alternatif['nama_siswa']) . "<br><small class='text-muted'>({$alternatif['nisn']})</small>" ?></td>
                          <td class="text-center"><?= ucfirst($alternatif['jk']) ?></td>
                          <td><?= $alternatif['nama_kelas'] ?></td>
                          <td><?= $alternatif['no_telp'] ?></td>
                          <td><?= $alternatif['email'] ?></td>
                          <td>
                            <button type="button" class="btn btn-outline-dark btn-icon-text py-1 toggle_modal_detail_alternatif"
                              data-id_siswa="<?= $alternatif['id_siswa'] ?>"
                              data-nama_siswa="<?= $alternatif['nama_siswa'] ?>"
                              data-username="<?= $alternatif['username'] ?>"
                              data-hak_akses="<?= $alternatif['hak_akses'] ?>"
                              data-alamat="<?= $alternatif['alamat'] ?>"
                              data-tmp_lahir="<?= $alternatif['tmp_lahir'] ?>"
                              data-tgl_lahir="<?= $alternatif['tgl_lahir'] ?>">
                              Lihat Detail
                              <i class="ti-list-ol btn-icon-append ml-1"></i>
                            </button>
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


  <!--============================= MODAL DETAIL SISWA =============================-->
  <div class="modal fade" id="ModalDetailAlternatif" tabindex="-1" role="dialog" aria-labelledby="ModalDetailAlternatif" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="ti-info-alt mr-2"></i>Detail Alternatif</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"><i class="ti-medall mr-2"></i>Alternatif</h4>
              <p class="xnama_siswa"></p>
            </div>
            <div class="card-body">
              <h4 class="card-title"><i class="ti-home mr-2"></i>Alamat</h4>
              <p class="xalamat"></p>
            </div>
            <div class="card-body">
              <h4 class="card-title"><i class="ti-gift mr-2"></i>Tempat, Tanggal Lahir</h4>
              <p class="xtmp_tgl_lahir"></p>
            </div>
          </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <!--/.modal-detail-alternatif -->


  <?php include '_partials/script.php' ?>
  <?php include '../helpers/sweetalert_notify.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      $(".datatables").DataTable({});
      
      $('.select2').select2({
        width: '100%'
      });

      
      $('.toggle_modal_detail_alternatif').tooltip({
        title: 'Alamat, Tempat dan Tanggal Lahir',
        delay: {
          show: 1000,
          hide: 100
        }
      });


      $('.datatables').on('click', '.toggle_modal_detail_alternatif', function() {
        const data = $(this).data();
        
        $('#ModalDetailAlternatif .xnama_siswa').html(data.nama_siswa);
        $('#ModalDetailAlternatif .xalamat').html(data.alamat);
        $('#ModalDetailAlternatif .xtmp_tgl_lahir').html(`${data.tmp_lahir}, ${moment(data.tgl_lahir).format("DD MMMM YYYY")}`);

        $('#ModalDetailAlternatif').modal('show');
      });
      
    });
  </script>

</body>

</html>

<?php endif ?>