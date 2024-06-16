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

  <meta name="Description" content="Data Range Nilai">
  <title>Data Range Nilai - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Range Nilai</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data range nilai.</h6>
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
                  <h4 class="card-title"><i class="ti-file mr-2"></i>Data Range Nilai</h4>
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                </div>
                <p class="card-description">
                  Data range nilai <span class="text-danger">diperlukan</span> saat <span class="text-danger">penilaian alternatif</span>, yaitu menentukan range nilai dari nilai siswa yang diinput.
                </p>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Batas (Bawah - Atas)</th>
                        <th>Range Nilai</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      $query_range_nilai = mysqli_query($connection, "SELECT * FROM tbl_range_nilai ORDER BY id DESC");

                      while ($range_nilai = mysqli_fetch_assoc($query_range_nilai)):
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= "{$range_nilai['batas_bawah']} - {$range_nilai['batas_atas']}" ?></td>
                          <td><?= $range_nilai['range_nilai'] ?></td>
                          <td>
                            <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah"
                              data-id_range_nilai="<?= $range_nilai['id'] ?>"
                              data-batas_bawah="<?= $range_nilai['batas_bawah'] ?>"
                              data-batas_atas="<?= $range_nilai['batas_atas'] ?>"
                              data-range_nilai="<?= $range_nilai['range_nilai'] ?>">
                              <i class="ti-pencil-alt mr-0"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-inverse-danger btn-icon-text py-1 toggle_modal_hapus"
                              data-id_range_nilai="<?= $range_nilai['id'] ?>"
                              data-batas_bawah="<?= $range_nilai['batas_bawah'] ?>"
                              data-batas_atas="<?= $range_nilai['batas_atas'] ?>"
                              data-range_nilai="<?= $range_nilai['range_nilai'] ?>">
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
  <div class="modal fade" id="ModalInputRangeNilai" tabindex="-1" role="dialog" aria-labelledby="ModalInputRangeNilai" aria-hidden="true">
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

            <input type="hidden" name="xid_range_nilai" class="xid_range_nilai" required>
            
            <div class="row">

              <div class="col-sm-6 form-group">
                <label for="xbatas_bawah">Batas Bawah</label>
                <input type="number" min="0" name="xbatas_bawah" class="form-control form-control-sm xbatas_bawah" id="xbatas_bawah" placeholder="Batas Bawah" aria-label="Batas Bawah" required>
              </div>
              
              <div class="col-sm-6 form-group">
                <label for="xbatas_atas">Batas Atas</label>
                <input type="number" min="0" name="xbatas_atas" class="form-control form-control-sm xbatas_atas" id="xbatas_atas" placeholder="Batas Atas" aria-label="Batas Atas" required>
              </div>

            </div>
            
            <div class="form-group">
              <label for="xrange_nilai">Range Nilai</label>
              <input type="number" min="0" name="xrange_nilai" class="form-control form-control-sm xrange_nilai" id="xrange_nilai" placeholder="Range Nilai" aria-label="Range Nilai" required>
              <small class="text-danger">Tidak boleh sama dengan data lainnya!</small>
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
        $('#ModalInputRangeNilai .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Range Nilai`);
        $('#ModalInputRangeNilai form').attr({action: 'range_nilai_tambah.php', method: 'post'});

        $('#ModalInputRangeNilai').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const data = $(this).data();

        $('#ModalInputRangeNilai .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Range Nilai`);
        $('#ModalInputRangeNilai form').attr({action: 'range_nilai_ubah.php', method: 'post'});
        
        $('#ModalInputRangeNilai .xid_range_nilai').val(data.id_range_nilai);
        $('#ModalInputRangeNilai .xbatas_bawah').val(data.batas_bawah);
        $('#ModalInputRangeNilai .xbatas_atas').val(data.batas_atas);
        $('#ModalInputRangeNilai .xrange_nilai').val(data.range_nilai);

        $('#ModalInputRangeNilai').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const data = $(this).data();
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data range nilai: ${data.batas_bawah} - ${data.batas_atas} -- (${data.range_nilai})?`,
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
              window.location = `range_nilai_hapus.php?xid_range_nilai=${data.id_range_nilai}`;
            });
          }
        });
      });

    });
  </script>

</body>

</html>

<?php endif ?>