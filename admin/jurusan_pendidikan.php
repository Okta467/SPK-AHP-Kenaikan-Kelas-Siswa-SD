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

  <meta name="Description" content="Data Jurusan">
  <title>Data Jurusan - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Jurusan</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data jurusan.</h6>
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
                  <h4 class="card-title"><i class="ti-agenda mr-2"></i>Data Jurusan</h4>
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama Jurusan</th>
                        <th>Asal Pendidikan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      $query_jurusan = mysqli_query($connection, 
                        "SELECT a.id AS id_jurusan_pendidikan, a.nama_jurusan, b.id AS id_pendidikan, b.nama_pendidikan
                        FROM tbl_jurusan_pendidikan a
                        JOIN tbl_pendidikan b
                          ON a.id_pendidikan = b.id
                        ORDER BY a.id DESC");

                      while ($jurusan = mysqli_fetch_assoc($query_jurusan)):
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $jurusan['nama_jurusan'] ?></td>
                          <td><?= $jurusan['nama_pendidikan'] ?></td>
                          <td>
                            <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah"
                              data-id_jurusan_pendidikan="<?= $jurusan['id_jurusan_pendidikan'] ?>"
                              data-id_pendidikan="<?= $jurusan['id_pendidikan'] ?>"
                              data-nama_jurusan="<?= $jurusan['nama_jurusan'] ?>">
                              <i class="ti-pencil-alt mr-0"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-inverse-danger btn-icon-text py-1 toggle_modal_hapus"
                              data-id_jurusan_pendidikan="<?= $jurusan['id_jurusan_pendidikan'] ?>"
                              data-nama_jurusan="<?= $jurusan['nama_jurusan'] ?>">
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
  <div class="modal fade" id="ModalInputJurusan" tabindex="-1" role="dialog" aria-labelledby="ModalInputJurusan" aria-hidden="true">
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

            <input type="hidden" name="xid_jurusan_pendidikan" class="xid_jurusan_pendidikan" required>
            
            <div class="form-group">
              <label for="xid_pendidikan">Pendidikan</label>
              <select name="xid_pendidikan" class="form-control form-control-sm select2 xid_pendidikan" id="xid_pendidikan" required style="width: 100%">
                <option value="">-- Pilih --</option>
                
                <?php
                $query_pendidikan = mysqli_query($connection, "SELECT * FROM tbl_pendidikan WHERE nama_pendidikan NOT IN ('SD', 'SMP', 'sd', 'smp', 'tidak_sekolah')");
                while ($pendidikan = mysqli_fetch_assoc($query_pendidikan)): 
                ?>

                  <option value="<?= $pendidikan['id'] ?>"><?= $pendidikan['nama_pendidikan'] ?></option>

                <?php
                endwhile;
                mysqli_close($connection);
                ?>

              </select>
            </div>
            
            <div class="form-group">
              <label for="xnama_jurusan">Jurusan</label>
              <input type="text" name="xnama_jurusan" class="form-control form-control-sm typeahead xnama_jurusan" id="xnama_jurusan" placeholder="Jurusan" aria-label="Jurusan" required>
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
        $('#ModalInputJurusan .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Jurusan`);
        $('#ModalInputJurusan form').attr({action: 'jurusan_pendidikan_tambah.php', method: 'post'});

        $('#ModalInputJurusan').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const id_jurusan_pendidikan = $(this).data('id_jurusan_pendidikan');
        const id_pendidikan         = $(this).data('id_pendidikan');
        const nama_jurusan          = $(this).data('nama_jurusan');

        $('#ModalInputJurusan .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Jurusan`);
        $('#ModalInputJurusan form').attr({action: 'jurusan_pendidikan_ubah.php', method: 'post'});
        
        $('#ModalInputJurusan .select2.xid_pendidikan').val(id_pendidikan).select2().trigger('change');
        $('#ModalInputJurusan .xid_jurusan_pendidikan').val(id_jurusan_pendidikan);
        $('#ModalInputJurusan .xnama_jurusan').val(nama_jurusan);

        $('#ModalInputJurusan').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const id_jurusan_pendidikan = $(this).data('id_jurusan_pendidikan');
        const nama_jurusan          = $(this).data('nama_jurusan');
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data jurusan: ${nama_jurusan}?`,
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
              window.location = `jurusan_pendidikan_hapus.php?xid_jurusan_pendidikan=${id_jurusan_pendidikan}`;
            });
          }
        });
      });

    });
  </script>

</body>

</html>

<?php endif ?>