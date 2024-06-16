<?php
include '../helpers/user_login_checker.php';

// cek apakah user yang mengakses adalah admin?
if (!isAccessAllowed('admin')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="Description" content="Data Pengguna">
    <title>Data Pengguna - <?= SITE_NAME ?></title>
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
                    <h3 class="font-weight-bold">Halaman Pengguna</h3>
                    <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data pengguna.</h6>
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
                      <h4 class="card-title"><i class="icon-head mr-2"></i>Data Pengguna</h4>
                      <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                    </div>
                    <p class="card-description mb-3">
                      Pengguna yang dapat memiliki <span class="text-danger">username</span> berbeda yaitu pengguna dengan hak akses <span class="text-danger">Guru</span> dan <span class="text-danger">Kepala Sekolah</span>.
                    </p>
                    <div class="table-responsive">
                      <table class="table table-striped datatables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Username</th>
                            <th>Pemilik</th>
                            <th>Hak Akses</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $no = 1;
                          $query_pengguna = mysqli_query($connection,
                            "SELECT 
                              a.id AS id_pengguna, a.username, a.hak_akses, 
                              b.id AS id_guru, b.nip AS nip_guru, b.nama_guru, b.jk AS jk_guru, 
                              c.id AS id_siswa, c.nisn AS nisn_siswa, c.nama_siswa, c.jk AS jk_siswa, 
                              d.nama_jabatan
                            FROM tbl_pengguna AS a
                            LEFT JOIN tbl_guru AS b
                              ON a.id_guru = b.id
                            LEFT JOIN tbl_siswa AS c
                              ON a.id_siswa = c.id
                            LEFT JOIN tbl_jabatan AS d
                              ON b.id_jabatan = d.id
                            ORDER BY a.id DESC");

                          while ($pengguna = mysqli_fetch_assoc($query_pengguna)) :
                          ?>

                            <tr>
                              <td><?= $no++ ?></td>
                              <td class="py-1">
                                <img src="<?= base_url('assets/images/faces/face' . rand(1, 7) . '.jpg') ?>" alt="image">
                              </td>
                              <td><?= $pengguna['username'] ?></td>
                              <td>
                                <?php
                                $nama_pengguna_html = '';

                                if ($pengguna['hak_akses'] === 'admin'):

                                  $nama_pengguna_html = 'Admin';

                                elseif (!empty($pengguna['id_guru'])):
                                  
                                  $nama_pengguna_html .= htmlspecialchars($pengguna['nama_guru']);
                                  $nama_pengguna_html .= !empty($pengguna['nip_guru'])
                                    ? "<br><small class='text-muted'>({$pengguna['nip_guru']})</small>"
                                    : "<br><small class='text-muted'>(Tidak ada NIP)</small>";

                                elseif (!empty($pengguna['id_siswa'])):
                                  
                                  $nama_pengguna_html .= htmlspecialchars($pengguna['nama_siswa']);
                                  $nama_pengguna_html .= !empty($pengguna['nisn_siswa'])
                                    ? "<br><small class='text-muted'>({$pengguna['nisn_siswa']})</small>"
                                    : "<br><small class='text-muted'>(Tidak ada NISN)</small>";

                                endif;

                                echo $nama_pengguna_html;
                                ?>
                              </td>
                              <td>
                                
                                <?php if ($pengguna['hak_akses'] === 'admin') : ?>
                                  
                                  <div class="badge badge-outline-danger"><?= str_replace('_', ' ', $pengguna['hak_akses']) ?></div>
                                  
                                <?php elseif ($pengguna['hak_akses'] === 'guru') : ?>
                                  
                                  <div class="badge badge-outline-info"><?= str_replace('_', ' ', $pengguna['hak_akses']) ?></div>

                                <?php else : ?>
                                  
                                  <div class="badge badge-outline-primary"><?= str_replace('_', ' ', $pengguna['hak_akses']) ?></div>
                                  
                                <?php endif ?>
                                
                              </td>
                              <td class="ellipsis">

                                <?php if (!$pengguna['nama_jabatan']): ?>

                                  <small class="text-muted">Tidak Ada</small>

                                <?php else: ?>

                                  <span class="toggle_tooltip" title="<?= $pengguna['nama_jabatan'] ?>">
                                    <?= $pengguna['nama_jabatan'] ?>
                                  </span>
                                  
                                <?php endif ?>

                              </td>
                              <td>

                                <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah"
                                  data-id_pengguna="<?= $pengguna['id_pengguna'] ?>"
                                  data-id_siswa="<?= $pengguna['id_siswa'] ?>"
                                  data-id_guru="<?= $pengguna['id_guru'] ?>"
                                  data-username="<?= $pengguna['username'] ?>"
                                  data-hak_akses="<?= $pengguna['hak_akses'] ?>">
                                  <i class="ti-pencil-alt mr-0"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-inverse-danger btn-icon-text py-1 toggle_modal_hapus"
                                  data-id_pengguna="<?= $pengguna['id_pengguna'] ?>"
                                  data-username="<?= $pengguna['username'] ?>"
                                  data-nama_siswa="<?= $pengguna['nama_siswa'] ?>">
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


    <!--============================= MODAL INPUT USER =============================-->
    <div class="modal fade" id="ModalInputPengguna" tabindex="-1" role="dialog" aria-labelledby="ModalInputPengguna" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="ti-plus mr-2"></i> Tambah Pengguna</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form>
            <div class="modal-body">

              <input type="hidden" name="xid_pengguna" class="xid_pengguna" required>

              <div class="form-group">
                <label for="xhak_akses">Hak Akses</label>
                <select name="xhak_akses" class="form-control form-control-sm xhak_akses" id="xhak_akses" required style="width: 100%">
                  <option value="">-- Pilih --</option>
                  <option value="admin">admin</option>
                  <option value="siswa">Siswa</option>
                  <option value="guru">Guru</option>
                  <option value="kepala_sekolah">Kepala Sekolah</option>
                </select>
              </div>
              
              <div class="form-group xid_guru">
                <label for="xid_guru">Guru</label>
                <select name="xid_guru" class="form-control form-control-sm select2 xid_guru" id="xid_guru" required style="width: 100%"></select>
                <small class="text-muted xid_guru_help"></small>
              </div>
              
              <div class="form-group xid_siswa">
                <label for="xid_siswa">Siswa</label>
                <select name="xid_siswa" class="form-control form-control-sm select2 xid_siswa" id="xid_siswa" required style="width: 100%"></select>
                <small class="text-muted xid_siswa_help"></small>
              </div>
              
              <div class="form-group">
                <label for="xusername">Username</label>
                <input type="text" name="xusername" class="form-control form-control-sm xusername" id="xusername" placeholder="Username" aria-label="Username" autocomplete="username" required disabled>
                <small class="text-danger xusername_help">Pilih hak akses terlebih dahulu!</small>
              </div>

              <div class="form-group">
                <label for="xpassword">Password</label>
                <input type="password" name="xpassword" class="form-control form-control-sm xpassword" id="xpassword" placeholder="Password" aria-label="Password" autocomplete="new-password" required disabled>
                <small class="text-danger xpassword_help">Pilih hak akses terlebih dahulu!</small>
                <small class="text-muted xpassword_help2">Kosongkan jika tidak ingin mengubah password.</small>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        </form>
      </div>
    </div>
    <!--/.modal-input-user -->


    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert_notify.php' ?>

    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        $(".datatables").DataTable({});
        
        $('.select2').select2({
          width: '100%'
        });

        
        $('#ModalInputPengguna div.xid_guru').hide();
        $('#ModalInputPengguna div.xid_siswa').hide();

        
        // Define hak_akses function for change handler
        // so you can use this for `on` and `off` event
        const handleHakAksesChange = function(tipe_pengguna = 'with_no_user', id_siswa = null, id_guru = null) {
          return function(e) {
            const hak_akses = $('#xhak_akses').val();
          
            if (!hak_akses) {
              $('#ModalInputPengguna div.xid_siswa').hide();
              $('#ModalInputPengguna select.xid_siswa').prop('required', false);
              $('#ModalInputPengguna div.xid_guru').hide();
              $('#ModalInputPengguna select.xid_guru').prop('required', false);
              $('#ModalInputPengguna input.xusername').attr('disabled', true);
              $('#ModalInputPengguna input.xusername').val('')
              $('#ModalInputPengguna input.xpassword').attr('disabled', true);
              $('#ModalInputPengguna .xusername_help').show();
              $('#ModalInputPengguna .xpassword_help').show();
            }
          
            if (hak_akses.toLowerCase() === 'admin') {
              $('#ModalInputPengguna div.xid_siswa').hide();
              $('#ModalInputPengguna select.xid_siswa').prop('required', false);
              $('#ModalInputPengguna div.xid_guru').hide();
              $('#ModalInputPengguna select.xid_guru').prop('required', false);
              $('#ModalInputPengguna input.xusername').attr('disabled', false);
              $('#ModalInputPengguna input.xusername').val('')
              $('#ModalInputPengguna input.xpassword').attr('disabled', false);
              $('#ModalInputPengguna .xusername_help').hide();
              $('#ModalInputPengguna .xpassword_help').hide();
              return;
            }
          
          
            if (hak_akses.toLowerCase() === 'siswa') {
              let url_ajax = tipe_pengguna === 'with_no_user'
                ? 'get_siswa_with_no_user.php'
                : 'get_siswa.php';
            
              $.ajax({
                url: url_ajax,
                method: 'POST',
                dataType: 'JSON',
                data: {
                  'id_siswa': id_siswa
                },
                success: function(data) {
                  $('#ModalInputPengguna div.xid_siswa').show();
                  $('#ModalInputPengguna select.xid_siswa').prop('required', true);

                  $('#ModalInputPengguna div.xid_guru').hide();
                  $('#ModalInputPengguna select.xid_guru').prop('required', false);

                  $('#ModalInputPengguna input.xusername').attr('disabled', false);
                  $('#ModalInputPengguna input.xpassword').attr('disabled', false);
                  $('#ModalInputPengguna .xusername_help').hide();
                  $('#ModalInputPengguna .xpassword_help').hide();
            
                  // Transform the data to the format that Select2 expects
                  const transformedData = data.map(item => ({
                    id: item.id_siswa,
                    text: item.nama_siswa
                  }));
                  
                  const siswaSelect = $('select#xid_siswa');
                  
                  siswaSelect.html(null);
                  siswaSelect.select2({ data: transformedData });
          
                  // Set username to first siswa nik (default selected/displayed siswa in select2 is always the first)
                  if (data.length && tipe_pengguna === 'with_no_user') {
                    $('#ModalInputPengguna input.xusername').val(data[0].nisn);
                  }
                },
                error: function(request, status, error) {
                  // console.log("ajax call went wrong:" + request.responseText);
                  console.log("ajax call went wrong:" + error);
                }
              });
          
            }
          
          
            if (['guru', 'kepala_sekolah'].includes(hak_akses.toLowerCase())) {
              let url_ajax = tipe_pengguna === 'with_no_user'
                ? 'get_guru_with_no_user.php'
                : 'get_guru.php';
            
              $.ajax({
                url: url_ajax,
                method: 'POST',
                dataType: 'JSON',
                data: {
                  'id_guru': id_guru
                },
                success: function(data) {
                  $('#ModalInputPengguna div.xid_siswa').hide();
                  $('#ModalInputPengguna select.xid_siswa').prop('required', false);

                  $('#ModalInputPengguna div.xid_guru').show();
                  $('#ModalInputPengguna select.xid_guru').prop('required', true);

                  $('#ModalInputPengguna input.xusername').attr('disabled', false);
                  $('#ModalInputPengguna input.xpassword').attr('disabled', false);
                  $('#ModalInputPengguna .xusername_help').hide();
                  $('#ModalInputPengguna .xpassword_help').hide();
            
                  // Transform the data to the format that Select2 expects
                  const transformedData = data.map(item => ({
                    id: item.id_guru,
                    text: item.nama_guru
                  }));
                  
                  const guruSelect = $('select#xid_guru');
                  
                  guruSelect.html(null);
                  guruSelect.select2({ data: transformedData });
          
                  // Set username to first siswa nik (default selected/displayed siswa in select2 is always the first)
                  if (data.length && tipe_pengguna === 'with_no_user') {
                    $('#ModalInputPengguna input.xusername').val(data[0].nip);
                  }
                },
                error: function(request, status, error) {
                  // console.log("ajax call went wrong:" + request.responseText);
                  console.log("ajax call went wrong:" + error);
                }
              });
          
            }

          }
        };


        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputPengguna .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Pengguna`);
          $('#ModalInputPengguna form').attr({action: 'pengguna_tambah.php', method: 'post'});
          $('#ModalInputPengguna .xid_siswa_help').html('Nama siswa yang muncul yaitu yang tidak memiliki pengguna.');
          $('#ModalInputPengguna .xid_guru_help').html('Nama guru yang muncul yaitu yang tidak memiliki pengguna.');
          $('#ModalInputPengguna .xpassword').prop('required', true);
          $('#ModalInputPengguna .xpassword_help2').hide();
          $('#ModalInputPengguna select.xhak_akses').prop('disabled', false)

          // Detach (off) hak akses change event to avoid error and safely repopulate its select option
          const hakAksesSelect = $('#xhak_akses');
          hakAksesSelect.off('change');
          hakAksesSelect.empty();
          
          // Re-Initialize default select2 options (because in toggle_modal_ubah it's changed)
          const data = [
            {id: '', text: '-- Pilih --', selected: true},
            {id: 'admin', text: 'Admin'},
            {id: 'siswa', text: 'Siswa'},
            {id: 'guru', text: 'Guru'},
            {id: 'kepala_sekolah', text: 'Kepala Sekolah'},
          ];

          hakAksesSelect.select2({ data: data });

          // Detach (off) the change handler before firing (on)  a new one to avoid multiple calls
          $('#xhak_akses').off('change').on('change', handleHakAksesChange());
          
          // Select hak akses to default to change all input state back to default
          $('#ModalInputPengguna select.xhak_akses').val('').select2().trigger('change');

          $('#ModalInputPengguna').modal('show');
        });


        $('.datatables').on('click', '.toggle_modal_ubah', function() {
          const data = $(this).data();

          $('#ModalInputPengguna .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Pengguna`);
          $('#ModalInputPengguna form').attr({action: 'pengguna_ubah.php', method: 'post'});
          
          // Detach (off) the change handler for repopulating options
          $('#xhak_akses').off('change');

          const hakAksesSelect = $('#xhak_akses');
          hakAksesSelect.empty();
          

          if (data.hak_akses === 'admin') {
            const data_admin = [
              {id: 'admin', text: 'Admin', selected: true}
            ];

            hakAksesSelect.select2({ data: data_admin })
          }
          else if (data.hak_akses === 'siswa') {
            const data_siswa = [
              {id: 'siswa', text: 'Siswa', selected: true}
            ];

            hakAksesSelect.select2({ data: data_siswa })
          }
          else {
            const data_guru = [
              {id: 'guru', text: 'Guru'},
              {id: 'kepala_sekolah', text: 'Kepala Sekolah'},
            ];

            hakAksesSelect.select2({ data: data_guru });
          }

          // Detach (off) the change handler before firing (on) a new one to avoid multiple calls
          $('#xhak_akses').off('change').on('change', handleHakAksesChange('with_user', data.id_siswa, data.id_guru));

          $('#ModalInputPengguna select.xhak_akses').val(data.hak_akses).select2().trigger('change');
          $('#ModalInputPengguna .xid_siswa_help').html('Nama siswa hanya dapat diubah pada halaman Guru.');
          $('#ModalInputPengguna .xid_guru_help').html('Nama guru hanya dapat diubah pada halaman Guru.');
          $('#ModalInputPengguna .xid_pengguna').val(data.id_pengguna);
          $('#ModalInputPengguna .xusername').val(data.username);
          $('#ModalInputPengguna .xpassword').prop('required', false);
          $('#ModalInputPengguna .xpassword_help2').show();

          $('#ModalInputPengguna').modal('show');
        });
        

        $('.datatables').on('click', '.toggle_modal_hapus', function() {
          const id_pengguna = $(this).data('id_pengguna');
          const username    = $(this).data('username');
          let nama_siswa  = $(this).data('nama_siswa');
          nama_siswa      = nama_siswa ? `(${nama_siswa})` : '';
          
          swal({
            title: "Konfirmasi Tindakan?",
            text: `Hapus user: ${username} ${nama_siswa}?`,
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
                window.location = `pengguna_hapus.php?xid_pengguna=${id_pengguna}`;
              });
            }
          });
        });
        
        
        // Simpan penilaian confirmation sweetalert
        $('#ModalInputPengguna button[type="submit"]').on('click', function(e) {
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


        $('select.xid_siswa').on('change', function() {
          const id_siswa  = $(this).val();
          const hak_akses = $('#xhak_akes').val();

          $.ajax({
            url: 'get_guru.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
              'id_siswa': id_siswa
            },
            success: function(data) {
              $('#ModalInputPengguna input.xusername').val(data[0].nik);
            },
            error: function(request, status, error) {
              // console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          })
        });


        $('select.xid_guru').on('change', function() {
          const id_guru   = $(this).val();
          const hak_akses = $('#xhak_akes').val();

          $.ajax({
            url: 'get_guru.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
              'id_guru': id_guru
            },
            success: function(data) {
              $('#ModalInputPengguna input.xusername').val(data[0].nik);
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