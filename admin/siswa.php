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
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data siswa.</h6>
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
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Ubah/<br>Hapus/<br>Detail</th>
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
                        ORDER BY a.id DESC");

                      while ($siswa = mysqli_fetch_assoc($query_siswa)): ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-outline-dark dropdown-toggle py-1" type="button" id="dropdown_aksi" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                              <div class="dropdown-menu" aria-labelledby="dropdown_aksi">

                                <button type="button" class="dropdown-item btn-link toggle_modal_ubah"
                                  data-id_siswa="<?= $siswa['id_siswa'] ?>">
                                  <i class="ti-pencil-alt mr-2"></i>Ubah
                                </button>
                                
                                <button type="button" class="dropdown-item btn-link text-danger toggle_modal_hapus"
                                  data-id_siswa="<?= $siswa['id_siswa'] ?>"
                                  data-nama_siswa="<?= $siswa['nama_siswa'] ?>">
                                  <i class="ti-trash mr-2"></i>Hapus
                                </button>
                                
                                <div class="dropdown-divider"></div>
                                
                                <button type="button" class="dropdown-item btn-link toggle_modal_detail_siswa"
                                  data-id_siswa="<?= $siswa['id_siswa'] ?>"
                                  data-nama_siswa="<?= $siswa['nama_siswa'] ?>"
                                  data-username="<?= $siswa['username'] ?>"
                                  data-hak_akses="<?= $siswa['hak_akses'] ?>"
                                  data-alamat="<?= $siswa['alamat'] ?>"
                                  data-tmp_lahir="<?= $siswa['tmp_lahir'] ?>"
                                  data-tgl_lahir="<?= $siswa['tgl_lahir'] ?>">
                                  <i class="ti-list mr-2"></i>Detail
                                </button>

                              </div>
                            </div>
                          </td>
                          <td><?= htmlspecialchars($siswa['nama_siswa']) . "<br><small class='text-muted'>({$siswa['nisn']})</small>" ?></td>
                          <td class="text-center"><?= ucfirst($siswa['jk']) ?></td>
                          <td><?= $siswa['nama_kelas'] ?></td>
                          <td><?= $siswa['no_telp'] ?></td>
                          <td><?= $siswa['email'] ?></td>
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
  <!--/.modal-detail-siswa -->


  <!--============================= MODAL INPUT SISWA =============================-->
  <div class="modal fade" id="ModalInputSiswa" tabindex="-1" role="dialog" aria-labelledby="ModalInputSiswa" aria-hidden="true">
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

            <input type="hidden" name="xid_siswa" class="xid_siswa" required>
            <input type="hidden" name="xid_pengguna" class="xid_pengguna" required>

            <div class="form-group">
              <label for="xnisn">NISN (10 Digit)</label>
              <input type="text" name="xnisn" minlength="10" maxlength="10" class="form-control form-control-sm xnisn" id="xnisn" placeholder="NISN (10 Digit)" aria-label="NISN (10 Digit)" required>
              <small class="text-danger">Tidak boleh sama dengan siswa lain!</small>
            </div>
            
            <div class="form-group">
              <label for="xnama_siswa">Nama Siswa</label>
              <input type="text" name="xnama_siswa" class="form-control form-control-sm xnama_siswa" id="xnama_siswa" placeholder="Nama Siswa" aria-label="Nama Siswa" required>
            </div>
              
            <div class="form-group">
              <label for="xid_kelas">Kelas</label>
              <select name="xid_kelas" class="form-control form-control-sm select2 xid_kelas" id="xid_kelas" required style="width: 100%">
                <option value="">-- Pilih --</option>
                <?php $query_kelas = mysqli_query($connection, "SELECT * FROM tbl_kelas ORDER BY nama_kelas ASC") ?>
                <?php while ($kelas = mysqli_fetch_assoc($query_kelas)): ?>

                  <option value="<?= $kelas['id'] ?>"><?= $kelas['nama_kelas'] ?></option>

                <?php endwhile ?>
              </select>
            </div>
            
            <div class="form-group">
              <label for="xpassword">Password Akun</label>
              <input type="password" name="xpassword" class="form-control form-control-sm xpassword" id="xpassword" placeholder="Password Akun" aria-label="Password Akun" autocomplete="new-password" required>
              <small class="text-muted xpassword_help"></small>
            </div>
            
            
            <div class="form-group row justify-content-around">
            
              <div class="col-sm-4">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input xjk" name="xjk" id="xjk1" value="l" required>Laki-laki<i class="input-helper"></i></label>
                </div>
              </div>
            
              <div class="col-sm-5">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input xjk" name="xjk" id="xjk2" value="p" required>Perempuan<i class="input-helper"></i></label>
                </div>
              </div>
            
            </div>

            
            <div class="form-group">
              <label for="xalamat">Alamat</label>
              <input type="text" name="xalamat" class="form-control form-control-sm xalamat" id="xalamat" placeholder="Alamat" aria-label="Alamat" required>
            </div>


            <div class="row">

              <div class="col-md-8">
                <div class="form-group">
                  <label for="xtmp_lahir">Tempat Lahir</label>
                  <input type="text" name="xtmp_lahir" class="form-control form-control-sm xtmp_lahir" id="xtmp_lahir" placeholder="Tempat Lahir" aria-label="Tempat Lahir" required>
                </div>
              </div>
            
              <div class="col-md-4">
                <div class="form-group">
                  <label for="xtgl_lahir">Tanggal Lahir</label>
                  <input type="date" name="xtgl_lahir" class="form-control form-control-sm xtgl_lahir" id="xtgl_lahir" placeholder="Tanggal Lahir" aria-label="Tanggal Lahir" required>
                </div>
              </div>
            
            </div>
            
            <div class="form-group">
              <label for="xno_telp">No. Telepon</label>
              <input type="text" name="xno_telp" class="form-control form-control-sm xno_telp" id="xno_telp" placeholder="Cth: 087712345678" aria-label="No. Telepon" required>
            </div>
            
            <div class="form-group">
              <label for="xemail">Email</label>
              <input type="email" name="xemail" class="form-control form-control-sm xemail" id="xemail" placeholder="Email" aria-label="Email" required>
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
  <!--/.modal-input-siswa -->


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
        title: 'Alamat, Hak Akses Akun, dan Tempat, Tanggal Lahir',
        delay: {
          show: 1000,
          hide: 100
        }
      });
      

      $('.toggle_modal_tambah').on('click', function() {
        $('#ModalInputSiswa .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Siswa`);
        $('#ModalInputSiswa form').attr({action: 'siswa_tambah.php', method: 'post'});
        $('#ModalInputSiswa .xpassword').attr('required', true);
        $('#ModalInputSiswa .xpassword_help').html('')

        $('#ModalInputSiswa').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const id_siswa = $(this).data('id_siswa');
        
        $('#ModalInputSiswa .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Siswa`);
        $('#ModalInputSiswa form').attr({action: 'siswa_ubah.php', method: 'post'});
        $('#ModalInputSiswa .xpassword').attr('required', false);
        $('#ModalInputSiswa .xpassword_help').html('Kosongkan jika tidak ingin ubah password.')

        $.ajax({
          url: 'get_siswa.php',
          method: 'POST',
          dataType: 'JSON',
          data: {
            'id_siswa': id_siswa
          },
          success: function(data) {
            console.log(data)
            $('#ModalInputSiswa .xid_siswa').val(data[0].id_siswa);
            $('#ModalInputSiswa .xid_pengguna').val(data[0].id_pengguna);
            $('#ModalInputSiswa .xnisn').val(data[0].nisn);
            $('#ModalInputSiswa .xnama_siswa').val(data[0].nama_siswa);
            $('#ModalInputSiswa .select2.xid_kelas').val(data[0].id_kelas).select2().trigger('change');
            $('#ModalInputSiswa .xhak_akses').val(data[0].hak_akses).prop('change');
            $(`#ModalInputSiswa .xjk[value="${data[0].jk}"]`).prop('checked', true);
            $('#ModalInputSiswa .xalamat').val(data[0].alamat);
            $('#ModalInputSiswa .xtmp_lahir').val(data[0].tmp_lahir);
            $('#ModalInputSiswa .xtgl_lahir').val(data[0].tgl_lahir);
            $('#ModalInputSiswa .xno_telp').val(data[0].no_telp);
            $('#ModalInputSiswa .xemail').val(data[0].email);
            
            $('#ModalInputSiswa').modal('show');
          },
          error: function(request, status, error) {
            // console.log("ajax call went wrong:" + request.responseText);
            console.log("ajax call went wrong:" + error);
          }
        })
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const id_siswa   = $(this).data('id_siswa');
        const nama_siswa = $(this).data('nama_siswa');
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data siswa: ${nama_siswa}?`,
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
              window.location = `siswa_hapus.php?xid_siswa=${id_siswa}`;
            });
          }
        });
      });


      // Simpan penilaian confirmation sweetalert
      $('#ModalInputSiswa button[type="submit"]').on('click', function(e) {
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


      $('.datatables').on('click', '.toggle_modal_detail_siswa', function() {
        const data = $(this).data();

        console.log(data)
        
        $('#ModalDetailSiswa .xnama_siswa').html(data.nama_siswa);
        $('#ModalDetailSiswa .xusername').html(data.username || 'Tidak ada (akun belum dibuat)');
        $('#ModalDetailSiswa .xhak_akses').html(data.hak_akses || 'Tidak ada (akun belum dibuat)');
        $('#ModalDetailSiswa .xalamat').html(data.alamat);
        $('#ModalDetailSiswa .xtmp_tgl_lahir').html(`${data.tmp_lahir}, ${moment(data.tgl_lahir).format("DD MMMM YYYY")}`);

        $('#ModalDetailSiswa').modal('show');
      });
      
    });
  </script>

</body>

</html>

<?php endif ?>