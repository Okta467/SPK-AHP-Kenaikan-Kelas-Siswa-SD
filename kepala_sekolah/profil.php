<?php
include '../helpers/user_login_checker.php';

// cek apakah user yang mengakses adalah kepala_sekolah?
if (!isAccessAllowed('kepala_sekolah')):
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else:
  include_once '../config/connection.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '_partials/head.php' ?>

  <meta name="Description" content="Data Profil">
  <title>Data Profil - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Profil</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk melihat dan mengubah data diri kepala sekolah.</h6>
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
                  <h4 class="card-title"><i class="icon-head mr-2"></i>Data Profil</h4>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>Nama/NIP</th>
                        <th>Pangkat/Golongan</th>
                        <th class="text-center">Status</th>
                        <th>Ijazah/Mapel/Tahun</th>
                        <th>Jabatan</th>
                        <th>Detail dan Wali Kelas Dari</th>
                        <th>Ubah Data Diri</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $query_guru = mysqli_query($connection, 
                        "SELECT
                          a.id AS id_guru, a.nip, a.nama_guru, a.jk, a.alamat, a.tmp_lahir, a.tgl_lahir, a.tahun_ijazah,
                          b.id AS id_jabatan, b.nama_jabatan, 
                          c.id AS id_pangkat_golongan, c.nama_pangkat_golongan, c.tipe AS tipe_pangkat_golongan,
                          d.id AS id_pendidikan, d.nama_pendidikan,
                          e.id AS id_jurusan_pendidikan, e.nama_jurusan AS nama_jurusan_pendidikan,
                          f.id AS id_pengguna, f.username, f.hak_akses,
                          g.wali_kelas_dari
                        FROM tbl_guru AS a
                        LEFT JOIN tbl_jabatan AS b
                          ON a.id_jabatan = b.id
                        LEFT JOIN tbl_pangkat_golongan AS c
                          ON a.id_pangkat_golongan = c.id
                        LEFT JOIN tbl_pendidikan AS d
                          ON a.id_pendidikan = d.id
                        LEFT JOIN tbl_jurusan_pendidikan AS e
                          ON a.id_jurusan_pendidikan = e.id
                        LEFT JOIN tbl_pengguna AS f
                          ON a.id = f.id_guru
                        LEFT JOIN
                        (
                          SELECT a.id_wali_kelas, GROUP_CONCAT(DISTINCT a.nama_kelas SEPARATOR ', ') AS wali_kelas_dari
                          FROM tbl_kelas AS a
                          JOIN tbl_guru AS b
                            ON b.id = a.id_wali_kelas
                          WHERE a.id_wali_kelas = {$_SESSION['id_guru']}
                        ) AS g
                          ON a.id = g.id_wali_kelas
                        WHERE a.id = {$_SESSION['id_guru']}");

                      while ($guru = mysqli_fetch_assoc($query_guru)): ?>

                        <tr>
                          <td><?= htmlspecialchars($guru['nama_guru']) . "<br><small class='text-muted'>({$guru['nip']})</small>" ?></td>
                          <td class="ellipsis">
                            <span class="toggle_tooltip" title="<?= $guru['nama_pangkat_golongan'] ?>">
                              <?= $guru['nama_pangkat_golongan'] ?>
                            </span>
                          </td>
                          <td class="text-center"><?= strtoupper($guru['tipe_pangkat_golongan']) ?></td>
                          <td><?= "{$guru['nama_pendidikan']}/{$guru['nama_jurusan_pendidikan']}/{$guru['tahun_ijazah']}" ?></td>
                          <td class="ellipsis">
                            <span class="toggle_tooltip" title="<?= $guru['nama_jabatan'] ?>">
                              <?= $guru['nama_jabatan'] ?>
                            </span>
                          </td>
                          <td>
                            <button type="button" class="btn btn-outline-dark btn-icon-text py-1 toggle_modal_detail_guru"
                              data-id_guru="<?= $guru['id_guru'] ?>"
                              data-nama_guru="<?= $guru['nama_guru'] ?>"
                              data-wali_kelas_dari="<?= $guru['wali_kelas_dari'] ?>"
                              data-username="<?= $guru['username'] ?>"
                              data-alamat="<?= $guru['alamat'] ?>"
                              data-tmp_lahir="<?= $guru['tmp_lahir'] ?>"
                              data-tgl_lahir="<?= $guru['tgl_lahir'] ?>">
                              Lihat Detail
                              <i class="ti-list-ol btn-icon-append ml-1"></i>
                            </button>
                          </td>
                          <td>
                            <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah" data-id_guru="<?= $guru['id_guru'] ?>">
                              <i class="ti-pencil-alt mr-0"></i>
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


  <!--============================= MODAL DETAIL GURU =============================-->
  <div class="modal fade" id="ModalDetailProfil" tabindex="-1" role="dialog" aria-labelledby="ModalDetailProfil" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="ti-info-alt mr-2"></i>Detail Profil</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"><i class="ti-medall mr-2"></i>Profil</h4>
              <p class="xnama_guru"></p>
            </div>
            <div class="card-body">
              <h4 class="card-title"><i class="ti-blackboard mr-2"></i>Wali Kelas</h4>
              <span class="xwali_kelas_dari"></span>
            </div>
            <div class="card-body">
              <h4 class="card-title"><i class="ti-key mr-2"></i>Username (NIP)</h4>
              <p class="xusername"></p>
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
  <!--/.modal-detail-guru -->


  <!--============================= MODAL INPUT NON ASN =============================-->
  <div class="modal fade" id="ModalInputProfil" tabindex="-1" role="dialog" aria-labelledby="ModalInputProfil" aria-hidden="true">
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
            
            <div class="form-group">
              <label for="xpassword">Password Akun</label>
              <input type="password" name="xpassword" class="form-control form-control-sm xpassword" id="xpassword" placeholder="Password Akun" aria-label="Password Akun" autocomplete="new-password" required>
              <small class="text-muted xpassword_help"></small>
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
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--/.modal-input-guru -->


  <?php include '_partials/script.php' ?>
  <?php include '../helpers/sweetalert_notify.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      $(".datatables").DataTable({});
      
      $('.select2').select2({
        width: '100%'
      });

      
      $('.toggle_modal_detail_guru').tooltip({
        title: 'Alamat, Wali Kelas, Tempat dan Tanggal Lahir',
        delay: {
          show: 1000,
          hide: 100
        }
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const id_guru = $(this).data('id_guru');
        
        $('#ModalInputProfil .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Profil`);
        $('#ModalInputProfil form').attr({action: 'profil_ubah.php', method: 'post'});
        $('#ModalInputProfil .xpassword').attr('required', false);
        $('#ModalInputProfil .xpassword_help').html('Kosongkan jika tidak ingin ubah password.')

        $.ajax({
          url: 'get_guru.php',
          method: 'POST',
          dataType: 'JSON',
          data: {
            'id_guru': id_guru
          },
          success: function(data) {
            $('#ModalInputProfil .xid_guru').val(data[0].id_guru);
            $('#ModalInputProfil .xid_pengguna').val(data[0].id_pengguna);
            $('#ModalInputProfil .xalamat').val(data[0].alamat);
            $('#ModalInputProfil .xtmp_lahir').val(data[0].tmp_lahir);
            $('#ModalInputProfil .xtgl_lahir').val(data[0].tgl_lahir);
            
            $('#ModalInputProfil').modal('show');
          },
          error: function(request, status, error) {
            // console.log("ajax call went wrong:" + request.responseText);
            console.log("ajax call went wrong:" + error);
          }
        })
      });


      // Simpan penilaian confirmation sweetalert
      $('#ModalInputProfil button[type="submit"]').on('click', function(e) {
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


      $('.datatables').on('click', '.toggle_modal_detail_guru', function() {
        const data = $(this).data();
        
        $('#ModalDetailProfil .xnama_guru').html(data.nama_guru);
        $('#ModalDetailProfil .xusername').html(data.username || 'Tidak ada (akun belum dibuat)');
        $('#ModalDetailProfil .xhak_akses').html(data.hak_akses || 'Tidak ada (akun belum dibuat)');
        $('#ModalDetailProfil .xalamat').html(data.alamat);
        $('#ModalDetailProfil .xtmp_tgl_lahir').html(`${data.tmp_lahir}, ${moment(data.tgl_lahir).format("DD MMMM YYYY")}`);

        let waliKelasDariListHtml  = '<ul>';
        let waliKelasDariListArray = data.wali_kelas_dari.split(',');
        
        waliKelasDariListArray.forEach(function(waliKelasDariList) {
          waliKelasDariList     =  waliKelasDariList.trim();
          waliKelasDariListHtml += `<li>${waliKelasDariList}</li>`;
        });

        waliKelasDariListHtml += '</ul>';
        
        $('#ModalDetailProfil .xwali_kelas_dari').html(waliKelasDariListHtml);

        $('#ModalDetailProfil').modal('show');
      });
      
    });
  </script>

</body>

</html>

<?php endif ?>