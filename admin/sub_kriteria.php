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
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data sub_kriteria.</h6>
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
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Kode Sub</th>
                        <th>Nama Sub</th>
                        <th>Bobot</th>
                        <th>Kode Kriteria</th>
                        <th>Nama Kriteria</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      $query_sub_kriteria = mysqli_query($connection, 
                        "SELECT
                          a.id AS id_sub_kriteria, a.kode_sub_kriteria, a.nama_sub_kriteria, a.bobot,
                          b.id AS id_kriteria, b.kode_kriteria, b.nama_kriteria, b.status_aktif,
                          c.id AS id_tingkat_kepentingan, c.nilai_kepentingan, c.keterangan
                        FROM tbl_sub_kriteria AS a
                        LEFT JOIN tbl_kriteria AS b
                          ON a.id_kriteria = b.id
                        LEFT JOIN tbl_tingkat_kepentingan AS c
                          ON b.id_tingkat_kepentingan = c.id
                        ORDER BY a.id DESC");

                      while ($sub_kriteria = mysqli_fetch_assoc($query_sub_kriteria)):
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $sub_kriteria['kode_sub_kriteria'] ?></td>
                          <td><?= $sub_kriteria['nama_sub_kriteria'] ?></td>
                          <td><?= $sub_kriteria['bobot'] ?></td>
                          <td><?= $sub_kriteria['kode_kriteria'] ?></td>
                          <td><?= $sub_kriteria['nama_kriteria'] ?></td>
                          <td>
                            <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah"
                              data-id_sub_kriteria="<?= $sub_kriteria['id_sub_kriteria'] ?>"
                              data-id_kriteria="<?= $sub_kriteria['id_kriteria'] ?>"
                              data-kode_sub_kriteria="<?= $sub_kriteria['kode_sub_kriteria'] ?>"
                              data-nama_sub_kriteria="<?= $sub_kriteria['nama_sub_kriteria'] ?>"
                              data-bobot="<?= $sub_kriteria['bobot'] ?>">
                              <i class="ti-pencil-alt mr-0"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-inverse-danger btn-icon-text py-1 toggle_modal_hapus"
                              data-id_sub_kriteria="<?= $sub_kriteria['id_sub_kriteria'] ?>"
                              data-nama_sub_kriteria="<?= $sub_kriteria['nama_sub_kriteria'] ?>">
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
  <div class="modal fade" id="ModalInputSubKriteria" tabindex="-1" role="dialog" aria-labelledby="ModalInputSubKriteria" aria-hidden="true">
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

            <input type="hidden" name="xid_sub_kriteria" class="xid_sub_kriteria" required>
            
            <div class="form-group">
              <label for="xid_kriteria">Kriteria</label>
              <select name="xid_kriteria" class="form-control form-control-sm select2 xid_kriteria" id="xid_kriteria" required style="width: 100%">
                <option value="">-- Pilih --</option>
                <?php $query_kriteria = mysqli_query($connection, "SELECT id, kode_kriteria, nama_kriteria FROM tbl_kriteria ORDER BY kode_kriteria ASC") ?>
                <?php while ($kriteria = mysqli_fetch_assoc($query_kriteria)): ?>

                  <option value="<?= $kriteria['id'] ?>"><?= "{$kriteria['kode_kriteria']} -- {$kriteria['nama_kriteria']}" ?></option>

                <?php endwhile ?>
              </select>
            </div>
            
            <div class="form-group">
              <label for="xkode_sub_kriteria">Kode Sub Kriteria</label>
              <input type="text" name="xkode_sub_kriteria" class="form-control form-control-sm xkode_sub_kriteria" id="xkode_sub_kriteria" placeholder="Contoh: K1S1" aria-label="Kode Kriteria" required>
              <small class="text-danger">Tidak boleh sama dengan sub kriteria lain!</small>
            </div>
            
            <div class="form-group">
              <label for="xnama_sub_kriteria">Nama Sub Kriteria</label>
              <input type="text" name="xnama_sub_kriteria" class="form-control form-control-sm xnama_sub_kriteria" id="xnama_sub_kriteria" placeholder="Nama Kriteria" aria-label="Nama Kriteria" required>
            </div>
            
            <div class="form-group">
              <label for="xbobot">Bobot</label>
              <input type="number" name="xbobot" class="form-control form-control-sm xbobot" id="xbobot" placeholder="Nama Kriteria" aria-label="Nama Kriteria" required>
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
        $('#ModalInputSubKriteria .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Sub Kriteria`);
        $('#ModalInputSubKriteria form').attr({action: 'sub_kriteria_tambah.php', method: 'post'});

        $('#ModalInputSubKriteria').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const data = $(this).data();

        $('#ModalInputSubKriteria .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Sub Kriteria`);
        $('#ModalInputSubKriteria form').attr({action: 'sub_kriteria_ubah.php', method: 'post'});
        
        $('#ModalInputSubKriteria .xid_sub_kriteria').val(data.id_sub_kriteria);
        $('#ModalInputSubKriteria .select2.xid_kriteria').val(data.id_kriteria).select2().trigger('change');
        $('#ModalInputSubKriteria .xkode_sub_kriteria').val(data.kode_sub_kriteria);
        $('#ModalInputSubKriteria .xnama_sub_kriteria').val(data.nama_sub_kriteria);
        $('#ModalInputSubKriteria .xbobot').val(data.bobot);

        $('#ModalInputSubKriteria').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const id_sub_kriteria   = $(this).data('id_sub_kriteria');
        const nama_sub_kriteria = $(this).data('nama_sub_kriteria');
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data sub_kriteria: ${nama_sub_kriteria}?`,
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
              window.location = `sub_kriteria_hapus.php?xid_sub_kriteria=${id_sub_kriteria}`;
            });
          }
        });
      });

    });
  </script>

</body>

</html>

<?php endif ?>