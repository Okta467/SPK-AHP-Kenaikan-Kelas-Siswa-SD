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

  <meta name="Description" content="Data Jabatan">
  <title>Data Jabatan - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Jabatan</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data jabatan.</h6>
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
                  <h4 class="card-title"><i class="ti-file mr-2"></i>Data Jabatan</h4>
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama Jabatan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      $query_jabatan = mysqli_query($connection, "SELECT * FROM tbl_jabatan ORDER BY id DESC");

                      while ($jabatan = mysqli_fetch_assoc($query_jabatan)):
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $jabatan['nama_jabatan'] ?></td>
                          <td>
                            <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah"
                              data-id_jabatan="<?= $jabatan['id'] ?>"
                              data-nama_jabatan="<?= $jabatan['nama_jabatan'] ?>">
                              <i class="ti-pencil-alt mr-0"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-inverse-danger btn-icon-text py-1 toggle_modal_hapus"
                              data-id_jabatan="<?= $jabatan['id'] ?>"
                              data-nama_jabatan="<?= $jabatan['nama_jabatan'] ?>">
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


  <!--============================= MODAL INPUT JURUSAN =============================-->
  <div class="modal fade" id="ModalInputJabatan" tabindex="-1" role="dialog" aria-labelledby="ModalInputJabatan" aria-hidden="true">
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

            <input type="hidden" name="xid_jabatan" class="xid_jabatan" required>

            <div class="form-group mb-0">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ti-file"></i></span>
                </div>
                <input type="text" name="xnama_jabatan" class="form-control form-control-sm xnama_jabatan" id="xnama_jabatan" placeholder="Nama Jabatan" aria-label="Nama Jabatan" required>
              </div>
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
  <!--/.modal-input-jurusan -->


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
        $('#ModalInputJabatan .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Jabatan`);
        $('#ModalInputJabatan form').attr({action: 'jabatan_tambah.php', method: 'post'});

        $('#ModalInputJabatan').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const id_jabatan    = $(this).data('id_jabatan');
        const id_pendidikan = $(this).data('id_pendidikan');
        const nama_jabatan  = $(this).data('nama_jabatan');

        $('#ModalInputJabatan .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Jabatan`);
        $('#ModalInputJabatan form').attr({action: 'jabatan_ubah.php', method: 'post'});
        
        $('#ModalInputJabatan .select2.xid_pendidikan').val(id_pendidikan).select2().trigger('change');
        $('#ModalInputJabatan .xid_jabatan').val(id_jabatan);
        $('#ModalInputJabatan .xnama_jabatan').val(nama_jabatan);

        $('#ModalInputJabatan').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const id_jabatan   = $(this).data('id_jabatan');
        const nama_jabatan = $(this).data('nama_jabatan');
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data jabatan: ${nama_jabatan}?`,
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
              window.location = `jabatan_hapus.php?xid_jabatan=${id_jabatan}`;
            });
          }
        });
      });

    });
  </script>

</body>

</html>

<?php endif ?>