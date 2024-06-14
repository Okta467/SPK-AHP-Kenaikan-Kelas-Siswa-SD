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
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data alternatif.</h6>
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
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Ubah/<br>Hapus/<br>Detail</th>
                        <th>Kode Alternatif</th>
                        <th>Nama/NISN</th>
                        <th class="text-center">JK</th>
                        <th>Kelas</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
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
                        GROUP BY a.id
                        ORDER BY a.id DESC");

                      while ($alternatif = mysqli_fetch_assoc($query_alternatif)): ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-outline-dark dropdown-toggle py-1" type="button" id="dropdown_aksi" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                              <div class="dropdown-menu" aria-labelledby="dropdown_aksi">

                                <button type="button" class="dropdown-item btn-link toggle_modal_ubah"
                                  data-id_alternatif="<?= $alternatif['id_alternatif'] ?>">
                                  <i class="ti-pencil-alt mr-2"></i>Ubah
                                </button>
                                
                                <button type="button" class="dropdown-item btn-link text-danger toggle_modal_hapus"
                                  data-id_alternatif="<?= $alternatif['id_alternatif'] ?>"
                                  data-kode_alternatif="<?= $alternatif['kode_alternatif'] ?>"
                                  data-nama_siswa="<?= $alternatif['nama_siswa'] ?>">
                                  <i class="ti-trash mr-2"></i>Hapus
                                </button>
                                
                                <div class="dropdown-divider"></div>
                                
                                <button type="button" class="dropdown-item btn-link toggle_modal_detail_alternatif"
                                  data-id_alternatif="<?= $alternatif['id_alternatif'] ?>"
                                  data-id_siswa="<?= $alternatif['id_siswa'] ?>"
                                  data-nama_siswa="<?= $alternatif['nama_siswa'] ?>"
                                  data-username="<?= $alternatif['username'] ?>"
                                  data-hak_akses="<?= $alternatif['hak_akses'] ?>"
                                  data-alamat="<?= $alternatif['alamat'] ?>"
                                  data-tmp_lahir="<?= $alternatif['tmp_lahir'] ?>"
                                  data-tgl_lahir="<?= $alternatif['tgl_lahir'] ?>">
                                  <i class="ti-list mr-2"></i>Detail
                                </button>

                              </div>
                            </div>
                          </td>
                          <td><?= $alternatif['kode_alternatif'] ?></td>
                          <td><?= htmlspecialchars($alternatif['nama_siswa']) . "<br><small class='text-muted'>({$alternatif['nisn']})</small>" ?></td>
                          <td class="text-center"><?= ucfirst($alternatif['jk']) ?></td>
                          <td><?= $alternatif['nama_kelas'] ?></td>
                          <td><?= $alternatif['no_telp'] ?></td>
                          <td><?= $alternatif['email'] ?></td>
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
              <h4 class="card-title"><i class="ti-key mr-2"></i>Username (NIK)</h4>
              <p class="xusername"></p>
            </div>
            <div class="card-body">
              <h4 class="card-title"><i class="ti-key mr-2"></i>Hak Akses Akun</h4>
              <p class="xhak_akses"></p>
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


  <!--============================= MODAL INPUT SISWA =============================-->
  <div class="modal fade" id="ModalInputAlternatif" tabindex="-1" role="dialog" aria-labelledby="ModalInputAlternatif" aria-hidden="true">
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

            <input type="hidden" name="xid_alternatif" class="xid_alternatif" required>
            
            <div class="form-group">
              <label for="xkode_alternatif">Kode Alternatif</label>
              <input type="text" name="xkode_alternatif" class="form-control form-control-sm xkode_alternatif" id="xkode_alternatif" placeholder="Contoh: A1" aria-label="Kode Alternatif" required>
              <small class="text-danger">Tidak boleh sama dengan alternatif lain!</small>
            </div>
            
            <div class="form-group xid_siswa toggle_fill_data_siswa">
              <label for="xid_siswa">Siswa</label>
              <select name="xid_siswa" class="form-control form-control-sm select2 xid_siswa" id="xid_siswa" required style="width: 100%">
                <option value="">-- Pilih --</option>
                <?php
                $query_siswa = mysqli_query($connection, 
                  "SELECT a.id AS id_siswa, a.nama_siswa, b.nama_kelas
                  FROM tbl_siswa AS a
                  LEFT JOIN tbl_kelas AS b
                    ON a.id_kelas = b.id
                  LEFT JOIN tbl_alternatif AS c
                    ON c.id_siswa = a.id
                  WHERE c.id IS NULL
                  ORDER BY b.nama_kelas ASC, a.nama_siswa ASC");
                ?>
                <?php while ($siswa = mysqli_fetch_assoc($query_siswa)): ?>

                  <option value="<?= $siswa['id_siswa'] ?>"><?= "(Kelas {$siswa['nama_kelas']}) -- {$siswa['nama_siswa']}" ?></option>

                <?php endwhile ?>
              </select>
              <small class="text-muted">Nama siswa yang muncul yaitu yang tidak memiliki data alternatif.</small>
            </div>
            
            <div class="form-group">
              <label for="xnisn">NISN (10 Digit)</label>
              <input type="text" name="xnisn" minlength="10" maxlength="10" class="form-control form-control-sm xnisn" id="xnisn" placeholder="NISN (10 Digit)" aria-label="NISN (10 Digit)" required readonly>
            </div>
            
            <div class="form-group">
              <label for="xnama_siswa">Nama Alternatif</label>
              <input type="text" name="xnama_siswa" class="form-control form-control-sm xnama_siswa" id="xnama_siswa" placeholder="Nama Alternatif" aria-label="Nama Alternatif" required readonly>
            </div>
              
            <div class="form-group">
              <label for="xid_kelas">Kelas</label>
              <select name="xid_kelas" class="form-control form-control-sm select2 xid_kelas" id="xid_kelas" required readonly style="width: 100%">
                <option value="">-- Pilih --</option>
                <?php $query_kelas = mysqli_query($connection, "SELECT * FROM tbl_kelas ORDER BY nama_kelas ASC") ?>
                <?php while ($kelas = mysqli_fetch_assoc($query_kelas)): ?>

                  <option value="<?= $kelas['id'] ?>"><?= $kelas['nama_kelas'] ?></option>

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
  <!--/.modal-input-alternatif -->


  <?php include '_partials/script.php' ?>
  <?php include '../helpers/sweetalert_notify.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      $(".datatables").DataTable({});
      
      $('.select2').select2({
        width: '100%'
      });

      $('.xid_kelas').select2({disabled: true});

      
      $('.toggle_modal_detail_alternatif').tooltip({
        title: 'Alamat, Hak Akses Akun, dan Tempat, Tanggal Lahir',
        delay: {
          show: 1000,
          hide: 100
        }
      });
      

      $('.toggle_modal_tambah').on('click', function() {
        $('#ModalInputAlternatif .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Alternatif`);
        $('#ModalInputAlternatif form').attr({action: 'alternatif_tambah.php', method: 'post'});

        $('#ModalInputAlternatif .xpassword').attr('required', true);
        $('#ModalInputAlternatif .xpassword_help').html('')

        $('#ModalInputAlternatif div.xid_siswa').show();
        $('#ModalInputAlternatif select.xid_siswa').prop('required', true);

        $('#ModalInputAlternatif').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const id_alternatif = $(this).data('id_alternatif');
        
        $('#ModalInputAlternatif .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Alternatif`);
        $('#ModalInputAlternatif form').attr({action: 'alternatif_ubah.php', method: 'post'});

        $('#ModalInputAlternatif .xpassword').attr('required', false);
        $('#ModalInputAlternatif .xpassword_help').html('Kosongkan jika tidak ingin ubah password.')

        $('#ModalInputAlternatif div.xid_siswa').hide();
        $('#ModalInputAlternatif select.xid_siswa').prop('required', false);

        $.ajax({
          url: 'get_alternatif.php',
          method: 'POST',
          dataType: 'JSON',
          data: {
            'id_alternatif': id_alternatif
          },
          success: function(data) {
            console.log(data)
            $('#ModalInputAlternatif .xid_alternatif').val(data[0].id_alternatif);
            $('#ModalInputAlternatif .xkode_alternatif').val(data[0].kode_alternatif);
            $('#ModalInputAlternatif .xnisn').val(data[0].nisn);
            $('#ModalInputAlternatif .xnama_siswa').val(data[0].nama_siswa);
            $('#ModalInputAlternatif .select2.xid_kelas').val(data[0].id_kelas).select2().trigger('change');
            
            $('#ModalInputAlternatif').modal('show');
          },
          error: function(request, status, error) {
            // console.log("ajax call went wrong:" + request.responseText);
            console.log("ajax call went wrong:" + error);
          }
        })
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const id_alternatif   = $(this).data('id_alternatif');
        const kode_alternatif = $(this).data('kode_alternatif');
        const nama_siswa      = $(this).data('nama_siswa');
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data alternatif: (${kode_alternatif}) ${nama_siswa}?`,
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
              window.location = `alternatif_hapus.php?xid_alternatif=${id_alternatif}`;
            });
          }
        });
      });


      // Simpan penilaian confirmation sweetalert
      $('#ModalInputAlternatif button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        var form = $(this).parents('.modal-content').find('form');

        // Validate form before showing sweetalert
        if (!form[0].checkValidity()) {
          form[0].reportValidity();
        } else {
          swal({
            title: "Konfirmasi Tindakan?",
            text: "Harap perhatikan kembali input sebelum submit.",
            icon: "warning",
            buttons: {
              cancel: "Tidak, batalkan!",
              confirm: {
                text: 'Ya, konfirmasi!',
                className: 'bg-info'
              }
            },
          })
          .then((willSubmit) => {
            if (willSubmit) {
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
                form.submit();
              });
            }
          });
        }
      });


      $('.datatables').on('click', '.toggle_modal_detail_alternatif', function() {
        const data = $(this).data();
        
        $('#ModalDetailAlternatif .xnama_siswa').html(data.nama_siswa);
        $('#ModalDetailAlternatif .xusername').html(data.username || 'Tidak ada (akun belum dibuat)');
        $('#ModalDetailAlternatif .xhak_akses').html(data.hak_akses || 'Tidak ada (akun belum dibuat)');
        $('#ModalDetailAlternatif .xalamat').html(data.alamat);
        $('#ModalDetailAlternatif .xtmp_tgl_lahir').html(`${data.tmp_lahir}, ${moment(data.tgl_lahir).format("DD MMMM YYYY")}`);

        $('#ModalDetailAlternatif').modal('show');
      });


      $('.toggle_fill_data_siswa select').on('change', function() {
        const id_siswa = $(this).val();
        
        $.ajax({
          url: 'get_siswa.php',
          method: 'POST',
          dataType: 'JSON',
          data: {
            'id_siswa': id_siswa
          },
          success: function(data) {
            $('#ModalInputAlternatif .xnisn').val(data[0].nisn);
            $('#ModalInputAlternatif .xnama_siswa').val(data[0].nama_siswa);
            $('#ModalInputAlternatif .select2.xid_kelas').val(data[0].id_kelas).select2().trigger('change');
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