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

  <meta name="Description" content="Data Tahun Akademik">
  <title>Data Tahun Akademik - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Tahun Akademik</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data tahun_akademik.</h6>
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
                  <h4 class="card-title"><i class="ti-calendar mr-2"></i>Data Tahun Akademik</h4>
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Dari Tahun</th>
                        <th>Sampai Tahun</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      $query_tahun_akademik = mysqli_query($connection, "SELECT * FROM tbl_tahun_akademik ORDER BY id DESC");

                      while ($tahun_akademik = mysqli_fetch_assoc($query_tahun_akademik)):
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $tahun_akademik['dari_tahun'] ?></td>
                          <td><?= $tahun_akademik['sampai_tahun'] ?></td>
                          <td>
                            <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah"
                              data-id_tahun_akademik="<?= $tahun_akademik['id'] ?>"
                              data-dari_tahun="<?= $tahun_akademik['dari_tahun'] ?>"
                              data-sampai_tahun="<?= $tahun_akademik['sampai_tahun'] ?>">
                              <i class="ti-pencil-alt mr-0"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-inverse-danger btn-icon-text py-1 toggle_modal_hapus"
                              data-id_tahun_akademik="<?= $tahun_akademik['id'] ?>"
                              data-dari_tahun="<?= $tahun_akademik['dari_tahun'] ?>"
                              data-sampai_tahun="<?= $tahun_akademik['sampai_tahun'] ?>">
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
  <div class="modal fade" id="ModalInputTahunAkademik" tabindex="-1" role="dialog" aria-labelledby="ModalInputTahunAkademik" aria-hidden="true">
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

            <input type="hidden" name="xid_tahun_akademik" class="xid_tahun_akademik" required>

            <div class="row">
            
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="xdari_tahun">Dari Tahun</label>
                  <input type="number" min="1000" max="9999" name="xdari_tahun" class="form-control form-control-sm xdari_tahun" id="xdari_tahun" placeholder="Dari Tahun" aria-label="Dari Tahun" required>
                </div>
              </div>
              
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="xsampai_tahun">Sampai Tahun</label>
                  <input type="number" min="1000" max="9999" name="xsampai_tahun" class="form-control form-control-sm xsampai_tahun" id="xsampai_tahun" placeholder="Sampai Tahun" aria-label="Sampai Tahun" required>
                </div>
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
        $('#ModalInputTahunAkademik .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Tahun Akademik`);
        $('#ModalInputTahunAkademik form').attr({action: 'tahun_akademik_tambah.php', method: 'post'});

        $('#ModalInputTahunAkademik').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const id_tahun_akademik = $(this).data('id_tahun_akademik');
        const dari_tahun        = $(this).data('dari_tahun');
        const sampai_tahun      = $(this).data('sampai_tahun');

        $('#ModalInputTahunAkademik .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Tahun Akademik`);
        $('#ModalInputTahunAkademik form').attr({action: 'tahun_akademik_ubah.php', method: 'post'});
        
        $('#ModalInputTahunAkademik .xid_tahun_akademik').val(id_tahun_akademik);
        $('#ModalInputTahunAkademik .xdari_tahun').val(dari_tahun);
        $('#ModalInputTahunAkademik .xsampai_tahun').val(sampai_tahun);

        $('#ModalInputTahunAkademik').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const id_tahun_akademik = $(this).data('id_tahun_akademik');
        const dari_tahun        = $(this).data('dari_tahun');
        const sampai_tahun      = $(this).data('sampai_tahun');
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data tahun_akademik: ${dari_tahun}/${sampai_tahun}?`,
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
              window.location = `tahun_akademik_hapus.php?xid_tahun_akademik=${id_tahun_akademik}`;
            });
          }
        });
      });

    });
  </script>

</body>

</html>

<?php endif ?>