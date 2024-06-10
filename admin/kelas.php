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

  <meta name="Description" content="Data Kelas">
  <title>Data Kelas - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Kelas</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data kelas.</h6>
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
                  <h4 class="card-title"><i class="ti-file mr-2"></i>Data Kelas</h4>
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Wali Kelas</th>
                        <th>Nama Kelas</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      $query_kelas = mysqli_query($connection, 
                        "SELECT
                          a.id AS id_kelas, a.nama_kelas AS nama_kelas,
                          b.id AS id_wali_kelas, b.nip, b.nama_guru AS nama_wali_kelas, b.jk, b.alamat, b.tmp_lahir, b.tgl_lahir, b.tahun_ijazah
                        FROM tbl_kelas AS a
                        LEFT JOIN tbl_guru AS b
                          ON a.id_wali_kelas = b.id
                        ORDER BY a.id DESC");

                      while ($kelas = mysqli_fetch_assoc($query_kelas)):
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= htmlspecialchars($kelas['nama_wali_kelas']) . "<br><small class='text-muted'>({$kelas['nip']})</small>" ?></td>
                          <td><?= $kelas['nama_kelas'] ?></td>
                          <td>
                            <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah"
                              data-id_kelas="<?= $kelas['id_kelas'] ?>"
                              data-nama_kelas="<?= $kelas['nama_kelas'] ?>"
                              data-id_wali_kelas="<?= $kelas['id_wali_kelas'] ?>">
                              <i class="ti-pencil-alt mr-0"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-inverse-danger btn-icon-text py-1 toggle_modal_hapus"
                              data-id_kelas="<?= $kelas['id_kelas'] ?>"
                              data-nama_kelas="<?= $kelas['nama_kelas'] ?>">
                              <i class="ti-trash mr-0"></i>
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


  <!--============================= MODAL INPUT KELAS =============================-->
  <div class="modal fade" id="ModalInputKelas" tabindex="-1" role="dialog" aria-labelledby="ModalInputKelas" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form>
          <div class="modal-body">

            <input type="hidden" name="xid_kelas" class="xid_kelas" required>
            
            <div class="form-group">
              <label for="xnama_kelas">Nama Kelas</label>
              <input type="text" name="xnama_kelas" class="form-control form-control-sm xnama_kelas" id="xnama_kelas" placeholder="Nama Kelas" aria-label="Nama Kelas" required>
            </div>
              
            <div class="form-group">
              <label for="xid_wali_kelas">Wali Kelas</label>
              <select name="xid_wali_kelas" class="form-control form-control-sm select2 xid_wali_kelas" id="xid_wali_kelas" required style="width: 100%">
                <option value="">-- Pilih --</option>
                <?php $query_wali_kelas = mysqli_query($connection, "SELECT id, nama_guru AS nama_wali_kelas FROM tbl_guru ORDER BY nama_guru ASC") ?>
                <?php while ($wali_kelas = mysqli_fetch_assoc($query_wali_kelas)): ?>

                  <option value="<?= $wali_kelas['id'] ?>"><?= $wali_kelas['nama_wali_kelas'] ?></option>

                <?php endwhile ?>
              </select>
            </div>
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--/.modal-input-kelas -->


  <?php include '_partials/script.php' ?>
  <?php include '../helpers/sweetalert_notify.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      $(".datatables").DataTable({});
      
      $('.select2').select2({
        width: '100%'
      });
        

      $('.toggle_modal_tambah').on('click', function() {
        $('#ModalInputKelas .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Kelas`);
        $('#ModalInputKelas form').attr({action: 'kelas_tambah.php', method: 'post'});

        $('#ModalInputKelas').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const id_kelas      = $(this).data('id_kelas');
        const nama_kelas    = $(this).data('nama_kelas');
        const id_wali_kelas = $(this).data('id_wali_kelas');

        $('#ModalInputKelas .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Kelas`);
        $('#ModalInputKelas form').attr({action: 'kelas_ubah.php', method: 'post'});
        
        $('#ModalInputKelas .xid_kelas').val(id_kelas);
        $('#ModalInputKelas .xnama_kelas').val(nama_kelas);
        $('#ModalInputKelas .xid_wali_kelas').val(id_wali_kelas).select2().trigger('change');

        $('#ModalInputKelas').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const id_kelas   = $(this).data('id_kelas');
        const nama_kelas = $(this).data('nama_kelas');
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data kelas: ${nama_kelas}?`,
          icon: "warning",
          buttons: {
            cancel: "Tidak, batalkan!",
            confirm: {
              text: 'Ya, konfirmasi!',
              className: 'bg-danger'
            }
          },
        })
        .then((willDelete) => {
          if (willDelete) {
            swal({
              title: "Tindakan Dikonfirmasi!",
              text: "Halaman akan di-reload untuk memproses.",
              icon: "success",
              timer: 3000,
              buttons: {
                confirm: {
                  className: 'bg-success'
                }
              }
            }).then(() => {
              window.location = `kelas_hapus.php?xid_kelas=${id_kelas}`;
            });
          }
        });
      });

    });
  </script>

</body>

</html>

<?php endif ?>