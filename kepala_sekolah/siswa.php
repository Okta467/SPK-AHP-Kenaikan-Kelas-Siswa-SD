<?php
include '../helpers/user_login_checker.php';

// cek apakah user yang mengakses adalah kepala_sekolah?
if (!isAccessAllowed('kepala_sekolah')):
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else:
  include_once '../config/connection.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '_partials/head.php' ?>

  <meta name="Description" content="Data Siswa">
  <title>Data Siswa - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Siswa</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk melihat data siswa yang guru pimpin sebagai wali kelasnya.</h6>
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
                  <h4 class="card-title"><i class="icon-head mr-2"></i>Data Siswa</h4>
                </div>
                <p class="card-description">Siswa yang tampil merupakan <span class="font-weight-bold text-danger">siswa</span> yang <span class="font-weight-bold text-danger">Anda pimpin</span> sebagai <span class="font-weight-bold text-danger">wali kelas</span> pada kelas tersebut.</p>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama/NISN</th>
                        <th class="text-center">JK</th>
                        <th>Kelas</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
                        <th>Detail Siswa</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $query_siswa = mysqli_query($connection, 
                        "SELECT
                          a.id AS id_siswa, a.nisn, a.nama_siswa, a.jk, a.alamat, a.tmp_lahir, a.tgl_lahir, a.no_telp, a.email,
                          b.id AS id_kelas, b.nama_kelas,
                          c.id AS id_wali_kelas, c.nama_guru AS nama_wali_kelas,
                          f.id AS id_pengguna, f.username, f.hak_akses
                        FROM tbl_siswa AS a
                        LEFT JOIN tbl_kelas AS b
                          ON b.id = a.id_kelas
                        LEFT JOIN tbl_guru AS c
                          ON c.id = b.id_wali_kelas
                        LEFT JOIN tbl_pengguna AS f
                          ON a.id = f.id_siswa
                        GROUP BY a.id
                      ORDER BY b.nama_kelas ASC, a.nama_siswa ASC");

                      while ($siswa = mysqli_fetch_assoc($query_siswa)): ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= htmlspecialchars($siswa['nama_siswa']) . "<br><small class='text-muted'>({$siswa['nisn']})</small>" ?></td>
                          <td class="text-center"><?= ucfirst($siswa['jk']) ?></td>
                          <td><?= $siswa['nama_kelas'] ?></td>
                          <td><?= $siswa['no_telp'] ?></td>
                          <td><?= $siswa['email'] ?></td>
                          <td>
                            <button type="button" class="btn btn-outline-dark btn-icon-text py-1 toggle_modal_detail_siswa"
                              data-id_siswa="<?= $siswa['id_siswa'] ?>"
                              data-nama_siswa="<?= $siswa['nama_siswa'] ?>"
                              data-username="<?= $siswa['username'] ?>"
                              data-hak_akses="<?= $siswa['hak_akses'] ?>"
                              data-alamat="<?= $siswa['alamat'] ?>"
                              data-tmp_lahir="<?= $siswa['tmp_lahir'] ?>"
                              data-tgl_lahir="<?= $siswa['tgl_lahir'] ?>">
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
  <div class="modal fade" id="ModalDetailSiswa" tabindex="-1" role="dialog" aria-labelledby="ModalDetailSiswa" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="ti-info-alt mr-2"></i>Detail Siswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"><i class="ti-medall mr-2"></i>Siswa</h4>
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
  <!--/.modal-detail-siswa -->


  <?php include '_partials/script.php' ?>
  <?php include '../helpers/sweetalert_notify.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      $(".datatables").DataTable({});
      
      $('.select2').select2({
        width: '100%'
      });

      
      $('.toggle_modal_detail_siswa').tooltip({
        title: 'Alamat, Tempat dan Tanggal Lahir',
        delay: {
          show: 1000,
          hide: 100
        }
      });


      $('.datatables').on('click', '.toggle_modal_detail_siswa', function() {
        const data = $(this).data();
        
        $('#ModalDetailSiswa .xnama_siswa').html(data.nama_siswa);
        $('#ModalDetailSiswa .xalamat').html(data.alamat);
        $('#ModalDetailSiswa .xtmp_tgl_lahir').html(`${data.tmp_lahir}, ${moment(data.tgl_lahir).format("DD MMMM YYYY")}`);

        $('#ModalDetailSiswa').modal('show');
      });
      
    });
  </script>

</body>

</html>

<?php endif ?>