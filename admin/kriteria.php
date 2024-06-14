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
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data kriteria.</h6>
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
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
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
                        <th>Aksi</th>
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
                          <td><input type="checkbox" class="js-switch toggle_status_aktif_kriteria" data-id_kriteria="<?= $kriteria['id_kriteria'] ?>" <?= $kriteria['status_aktif'] ? 'checked' : '' ?>></td>
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
                          <td>
                            <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah"
                              data-id_kriteria="<?= $kriteria['id_kriteria'] ?>"
                              data-id_tingkat_kepentingan="<?= $kriteria['id_tingkat_kepentingan'] ?>"
                              data-kode_kriteria="<?= $kriteria['kode_kriteria'] ?>"
                              data-nama_kriteria="<?= $kriteria['nama_kriteria'] ?>">
                              <i class="ti-pencil-alt mr-0"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-inverse-danger btn-icon-text py-1 toggle_modal_hapus"
                              data-id_kriteria="<?= $kriteria['id_kriteria'] ?>"
                              data-nama_kriteria="<?= $kriteria['nama_kriteria'] ?>">
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
                <th>Bobot</th>
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


  <!--============================= MODAL INPUT JURUSAN =============================-->
  <div class="modal fade" id="ModalInputKriteria" tabindex="-1" role="dialog" aria-labelledby="ModalInputKriteria" aria-hidden="true">
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

            <input type="hidden" name="xid_kriteria" class="xid_kriteria" required>
            
            <div class="form-group">
              <label for="xid_tingkat_kepentingan">Tingkat Kepentingan</label>
              <select name="xid_tingkat_kepentingan" class="form-control form-control-sm select2 xid_tingkat_kepentingan" id="xid_tingkat_kepentingan" required style="width: 100%">
                <option value="">-- Pilih --</option>
                <?php $query_tingkat_kepentingan = mysqli_query($connection, "SELECT id, nilai_kepentingan FROM tbl_tingkat_kepentingan ORDER BY nilai_kepentingan ASC") ?>
                <?php while ($tingkat_kepentingan = mysqli_fetch_assoc($query_tingkat_kepentingan)): ?>

                  <option value="<?= $tingkat_kepentingan['id'] ?>"><?= $tingkat_kepentingan['nilai_kepentingan'] ?></option>

                <?php endwhile ?>
              </select>
            </div>
            
            <div class="form-group">
              <label for="xkode_kriteria">Kode Kriteria</label>
              <input type="text" name="xkode_kriteria" class="form-control form-control-sm xkode_kriteria" id="xkode_kriteria" placeholder="Kode Kriteria" aria-label="Kode Kriteria" required>
              <small class="text-danger">Tidak boleh sama dengan kriteria lain!</small>
            </div>
            
            <div class="form-group">
              <label for="xnama_kriteria">Nama Kriteria</label>
              <input type="text" name="xnama_kriteria" class="form-control form-control-sm xnama_kriteria" id="xnama_kriteria" placeholder="Nama Kriteria" aria-label="Nama Kriteria" required>
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
        

      $('.toggle_modal_tambah').on('click', function() {
        $('#ModalInputKriteria .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Kriteria`);
        $('#ModalInputKriteria form').attr({action: 'kriteria_tambah.php', method: 'post'});

        $('#ModalInputKriteria').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const data = $(this).data();

        $('#ModalInputKriteria .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Kriteria`);
        $('#ModalInputKriteria form').attr({action: 'kriteria_ubah.php', method: 'post'});
        
        $('#ModalInputKriteria .xid_kriteria').val(data.id_kriteria);
        $('#ModalInputKriteria .select2.xid_tingkat_kepentingan').val(data.id_tingkat_kepentingan).select2().trigger('change');
        $('#ModalInputKriteria .xkode_kriteria').val(data.kode_kriteria);
        $('#ModalInputKriteria .xnama_kriteria').val(data.nama_kriteria);

        $('#ModalInputKriteria').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const id_kriteria   = $(this).data('id_kriteria');
        const nama_kriteria = $(this).data('nama_kriteria');
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data kriteria: ${nama_kriteria}?`,
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
              window.location = `kriteria_hapus.php?xid_kriteria=${id_kriteria}`;
            });
          }
        });
      });


      $('.datatables').on('change', '.toggle_status_aktif_kriteria', function() {
        const id_kriteria = $(this).data('id_kriteria');

        $.ajax({
          url: 'set_status_aktif_kriteria.php',
          type: 'POST',
          data: {
            id_kriteria
          },
          dataType: 'JSON',
          success: function(data) {
            data
              ? console.log('Berhasil update set status kriteria!')
              : console.log('Gagal update set status kriteria!');
          }
        });
      });

      
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
            console.log(data);
            
            // add datatables row
            let i = 1;
            let rowsData = [];
            
            for (key in data) {
              rowsData.push([i++, data[key]['kode_sub_kriteria'], data[key]['nama_sub_kriteria'], data[key]['bobot']]);
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