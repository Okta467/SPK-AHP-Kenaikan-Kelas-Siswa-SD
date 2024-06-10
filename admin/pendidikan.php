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

  <meta name="Description" content="Data Pendidikan">
  <title>Data Pendidikan - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Pendidikan</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data pendidikan.</h6>
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
                  <h4 class="card-title"><i class="ti-agenda mr-2"></i>Data Pendidikan</h4>
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama Pendidikan</th>
                        <th>Daftar Jurusan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      $query_pendidikan = mysqli_query($connection, "SELECT 
                          a.id AS id_pendidikan, a.nama_pendidikan, IFNULL(b.jml_jurusan, 0) AS jml_jurusan
                        FROM tbl_pendidikan AS a
                        LEFT JOIN (SELECT id_pendidikan, COUNT(id) jml_jurusan FROM `tbl_jurusan_pendidikan` GROUP BY id_pendidikan) AS b
                          ON a.id = b.id_pendidikan
                        ORDER BY a.id DESC");

                      while ($pendidikan = mysqli_fetch_assoc($query_pendidikan)):
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $pendidikan['nama_pendidikan'] ?></td>
                          <td>
                            <?php if (!in_array(strtoupper($pendidikan['nama_pendidikan']), ['TIDAK_SEKOLAH', 'SD', 'SMP', 'SLTP'])): ?>
                              <button type="button" class="btn btn-outline-dark btn-icon-text py-1 toggle_daftar_jurusan"
                              data-id_pendidikan="<?= $pendidikan['id_pendidikan'] ?>">
                                <div class="badge badge-pill badge-outline-dark py-1 px-2 mr-2"><?= $pendidikan['jml_jurusan'] ?></div>
                                Lihat Jurusan
                                <i class="ti-list-ol btn-icon-append ml-1"></i>
                              </button>
                            <?php else: ?>
                              <small class="text-muted">Tidak ada</small>
                            <?php endif ?>
                          </td>
                          <td>
                            <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah"
                              data-id_pendidikan="<?= $pendidikan['id_pendidikan'] ?>"
                              data-nama_pendidikan="<?= $pendidikan['nama_pendidikan'] ?>">
                              <i class="ti-pencil-alt mr-0"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-inverse-danger btn-icon-text py-1 toggle_modal_hapus"
                              data-id_pendidikan="<?= $pendidikan['id_pendidikan'] ?>"
                              data-nama_pendidikan="<?= $pendidikan['nama_pendidikan'] ?>">
                              <i class="ti-trash mr-0"></i>
                            </button>
                          </td>
                        </tr>

                      <?php
                      endwhile;
                      mysqli_close($connection);
                      ?>

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


  <!--============================= MODAL DAFTAR JURUSAN =============================-->
  <div class="modal fade" id="ModalDaftarJurusan" tabindex="-1" role="dialog" aria-labelledby="ModalDaftarJurusan" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="ti-agenda mr-2"></i>Daftar Jurusan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <table class="table table-striped" id="tabel_daftar_jurusan">
            <thead>
              <tr>
                <th>#</th>
                <th>Pendidikan</th>
                <th>Jurusan</th>
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
  <!--/.modal-daftar-jurusan -->


  <!--============================= MODAL INPUT PENDIDIKAN =============================-->
  <div class="modal fade" id="ModalInputPendidikan" tabindex="-1" role="dialog" aria-labelledby="ModalInputPendidikan" aria-hidden="true">
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

            <input type="hidden" name="xid_pendidikan" class="xid_pendidikan" required>
          
            <div class="form-group mb-0">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ti-agenda"></i></span>
                </div>
                <input type="text" name="xnama_pendidikan" class="form-control form-control-sm xnama_pendidikan" id="xnama_pendidikan" placeholder="Nama Pendidikan" aria-label="Nama Pendidikan" required>
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
  <!--/.modal-input-pendidikan -->


  <?php include '_partials/script.php' ?>
  <?php include '../helpers/sweetalert_notify.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      $(".datatables").DataTable({});

      var datatableDaftarJurusan = $('#tabel_daftar_jurusan').DataTable({
        fixedHeader: true,
        pageLength: 5,
        lengthMenu: [
          [3, 5, 10, 25, 50, 100],
          [3, 5, 10, 25, 50, 100],
        ]
      });


      $('.datatables').on('click', '.toggle_daftar_jurusan', function() {
        const id_pendidikan = $(this).data('id_pendidikan');

        $.ajax({
          url: 'get_jurusan_pendidikan.php',
          method: 'POST',
          dataType: 'JSON',
          data: {
            'id_pendidikan': id_pendidikan
          },
          success: function(data) {
            console.log(data);
            
            // add datatables row
            let i = 1;
            let rowsData = [];
            
            for (key in data) {
              rowsData.push([i++, data[key]['nama_pendidikan'], data[key]['nama_jurusan']]);
            }
            
            datatableDaftarJurusan.clear().draw();
            datatableDaftarJurusan.rows.add(rowsData).draw();
            
            $('#ModalDaftarJurusan').modal('show');
          },
          error: function(request, status, error) {
            // console.log("ajax call went wrong:" + request.responseText);
            console.log("ajax call went wrong:" + error);
          }
        })
      });


      $('.toggle_modal_tambah').on('click', function() {
        $('#ModalInputPendidikan .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Pendidikan`);
        $('#ModalInputPendidikan form').attr({action: 'pendidikan_tambah.php', method: 'post'});

        $('#ModalInputPendidikan').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const id_pendidikan   = $(this).data('id_pendidikan');
        const nama_pendidikan = $(this).data('nama_pendidikan');

        $('#ModalInputPendidikan .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Pendidikan`);
        $('#ModalInputPendidikan form').attr({action: 'pendidikan_ubah.php', method: 'post'});

        $('#ModalInputPendidikan .xid_pendidikan').val(id_pendidikan);
        $('#ModalInputPendidikan .xnama_pendidikan').val(nama_pendidikan);

        $('#ModalInputPendidikan').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const id_pendidikan   = $(this).data('id_pendidikan');
        const nama_pendidikan = $(this).data('nama_pendidikan');
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data pendidikan: ${nama_pendidikan}?`,
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
              window.location = `pendidikan_hapus.php?xid_pendidikan=${id_pendidikan}`;
            });
          }
        });
      });

    });
  </script>

</body>

</html>

<?php endif ?>