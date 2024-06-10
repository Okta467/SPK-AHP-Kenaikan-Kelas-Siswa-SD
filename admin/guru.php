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

  <meta name="Description" content="Data Guru">
  <title>Data Guru - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Guru</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data Guru.</h6>
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
                  <h4 class="card-title"><i class="icon-head mr-2"></i>Data Guru</h4>
                  <button type="button" class="btn btn-sm btn-info btn-icon-text toggle_modal_tambah">Tambah Data<i class="icon-plus btn-icon-append"></i></button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Ubah/<br>Hapus/<br>Detail</th>
                        <th>Nama/NIP</th>
                        <th class="text-center">JK</th>
                        <th>Pangkat/Golongan</th>
                        <th class="text-center">Status</th>
                        <th>Ijazah/Mapel/Tahun</th>
                        <th>Jabatan</th>
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
                          f.id AS id_pengguna, f.username, f.hak_akses
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
                        ORDER BY a.id DESC");

                      while ($guru = mysqli_fetch_assoc($query_guru)): ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-outline-dark dropdown-toggle py-1" type="button" id="dropdown_aksi" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                              <div class="dropdown-menu" aria-labelledby="dropdown_aksi">

                                <button type="button" class="dropdown-item btn-link toggle_modal_ubah"
                                  data-id_guru="<?= $guru['id_guru'] ?>">
                                  <i class="ti-pencil-alt mr-2"></i>Ubah
                                </button>
                                
                                <button type="button" class="dropdown-item btn-link text-danger toggle_modal_hapus"
                                  data-id_guru="<?= $guru['id_guru'] ?>"
                                  data-nama_guru='<?= "{$guru['nama_guru']} ({$guru['nama_jabatan']})" ?>'>
                                  <i class="ti-trash mr-2"></i>Hapus
                                </button>
                                
                                <div class="dropdown-divider"></div>
                                
                                <button type="button" class="dropdown-item btn-link toggle_modal_detail_guru"
                                  data-id_guru="<?= $guru['id_guru'] ?>"
                                  data-nama_guru="<?= $guru['nama_guru'] ?>"
                                  data-username="<?= $guru['username'] ?>"
                                  data-hak_akses="<?= $guru['hak_akses'] ?>"
                                  data-alamat="<?= $guru['alamat'] ?>"
                                  data-tmp_lahir="<?= $guru['tmp_lahir'] ?>"
                                  data-tgl_lahir="<?= $guru['tgl_lahir'] ?>">
                                  <i class="ti-list mr-2"></i>Detail
                                </button>

                              </div>
                            </div>
                          </td>
                          <td><?= htmlspecialchars($guru['nama_guru']) . "<br><small class='text-muted'>({$guru['nip']})</small>" ?></td>
                          <td class="text-center"><?= ucfirst($guru['jk']) ?></td>
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
  <div class="modal fade" id="ModalDetailGuru" tabindex="-1" role="dialog" aria-labelledby="ModalDetailGuru" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="ti-info-alt mr-2"></i>Detail Guru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"><i class="ti-medall mr-2"></i>Guru</h4>
              <p class="xnama_guru"></p>
            </div>
            <div class="card-body">
              <h4 class="card-title"><i class="ti-key mr-2"></i>Username (NIP)</h4>
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
  <!--/.modal-detail-guru -->


  <!--============================= MODAL INPUT NON ASN =============================-->
  <div class="modal fade" id="ModalInputGuru" tabindex="-1" role="dialog" aria-labelledby="ModalInputGuru" aria-hidden="true">
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

            <input type="hidden" name="xid_guru" class="xid_guru" required>
            <input type="hidden" name="xid_pengguna" class="xid_pengguna" required>

            <div class="form-group">
              <label for="xnip">NIP (16 Digit)</label>
              <input type="text" name="xnip" minlength="16" maxlength="16" class="form-control form-control-sm xnip" id="xnip" placeholder="NIP (16 Digit)" aria-label="NIP (16 Digit)" required>
              <small class="text-danger">Tidak boleh sama dengan guru lain!</small>
            </div>
            
            <div class="form-group">
              <label for="xnama_guru">Nama Guru</label>
              <input type="text" name="xnama_guru" class="form-control form-control-sm xnama_guru" id="xnama_guru" placeholder="Nama Guru" aria-label="Nama Guru" required>
            </div>
            
            <div class="form-group">
              <label for="xpassword">Password Akun</label>
              <input type="password" name="xpassword" class="form-control form-control-sm xpassword" id="xpassword" placeholder="Password Akun" aria-label="Password Akun" autocomplete="new-password" required>
              <small class="text-muted xpassword_help"></small>
            </div>

            <div class="form-group">
              <label for="xhak_akses">Hak Akses Akun</label>
              <select name="xhak_akses" class="form-control form-control-sm xhak_akses" id="xhak_akses" required style="width: 100%">
                <option value="">-- Pilih --</option>
                <option value="guru">Guru</option>
                <option value="kepala_sekolah">Kepala Sekolah</option>
              </select>
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
              <label for="xid_jabatan">Jabatan</label>
              <select name="xid_jabatan" class="form-control form-control-sm select2 xid_jabatan" id="xid_jabatan" required style="width: 100%">
                <option value="">-- Pilih --</option>
                
                <?php
                $query_jabatan = mysqli_query($connection, "SELECT * FROM tbl_jabatan ORDER BY id DESC");
                while ($jabatan = mysqli_fetch_assoc($query_jabatan)): 
                ?>

                  <option value="<?= $jabatan['id'] ?>"><?= $jabatan['nama_jabatan'] ?></option>

                <?php endwhile ?>

              </select>
            </div>
              
            <div class="form-group">
              <label for="xid_pangkat_golongan">Pangkat/Golongan</label>
              <select name="xid_pangkat_golongan" class="form-control form-control-sm select2 xid_pangkat_golongan" id="xid_pangkat_golongan" required style="width: 100%">
                <option value="">-- Pilih --</option>
                
                <?php
                $query_pangkat_golongan = mysqli_query($connection, "SELECT * FROM tbl_pangkat_golongan ORDER BY id DESC");
                while ($pangkat_golongan = mysqli_fetch_assoc($query_pangkat_golongan)): 
                ?>

                  <option value="<?= $pangkat_golongan['id'] ?>"><?= $pangkat_golongan['nama_pangkat_golongan'] ?></option>

                <?php endwhile ?>

              </select>
            </div>
            
            
            <div class="row">
            
              <div class="col-md-4">
                <div class="form-group">
                  <label for="xid_pendidikan">Pendidikan</label>
                  <select name="xid_pendidikan" class="form-control form-control-sm select2 xid_pendidikan" id="xid_pendidikan" required style="width: 100%">
                    <option value="">-- Pilih --</option>
                    
                    <?php
                    $query_pendidikan = mysqli_query($connection, "SELECT * FROM tbl_pendidikan ORDER BY id DESC");
                    while ($pendidikan = mysqli_fetch_assoc($query_pendidikan)): 
                    ?>
    
                      <option value="<?= $pendidikan['id'] ?>"><?= $pendidikan['nama_pendidikan'] ?></option>
    
                    <?php endwhile ?>
    
                  </select>
                </div>
              </div>
            
              <div class="col-md-8">
                <div class="form-group">
                  <label for="xid_jurusan">Jurusan</label>
                  <span class="form-control text-danger xid_jurusan">Pilih pendidikan terlebih dahulu!</span>
                </div>
              </div>
            
            </div>
            
            <div class="form-group">
              <label for="xtahun_ijazah">Tahun Ijazah</label>
              <input type="text" name="xtahun_ijazah" class="form-control form-control-sm xtahun_ijazah" id="xtahun_ijazah" placeholder="Tahun Ijazah" aria-label="Tahun Ijazah" required>
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
        title: 'Alamat, Hak Akses Akun, dan Tempat, Tanggal Lahir',
        delay: {
          show: 1000,
          hide: 100
        }
      });
      

      $('.toggle_modal_tambah').on('click', function() {
        $('#ModalInputGuru .modal-title').html(`<i class="ti-plus mr-2"></i>Tambah Guru`);
        $('#ModalInputGuru form').attr({action: 'guru_tambah.php', method: 'post'});
        $('#ModalInputGuru .xpassword').attr('required', true);
        $('#ModalInputGuru .xpassword_help').html('')

        $('#ModalInputGuru').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const id_guru = $(this).data('id_guru');
        
        $('#ModalInputGuru .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Guru`);
        $('#ModalInputGuru form').attr({action: 'guru_ubah.php', method: 'post'});
        $('#ModalInputGuru .xpassword').attr('required', false);
        $('#ModalInputGuru .xpassword_help').html('Kosongkan jika tidak ingin ubah password.')

        $.ajax({
          url: 'get_guru.php',
          method: 'POST',
          dataType: 'JSON',
          data: {
            'id_guru': id_guru
          },
          success: function(data) {
            console.log(data)
            $('#ModalInputGuru .xid_guru').val(data[0].id_guru);
            $('#ModalInputGuru .xid_pengguna').val(data[0].id_pengguna);
            $('#ModalInputGuru .xnip').val(data[0].nip);
            $('#ModalInputGuru .xnama_guru').val(data[0].nama_guru);
            $('#ModalInputGuru .xhak_akses').val(data[0].hak_akses).prop('change');
            $(`#ModalInputGuru .xjk[value="${data[0].jk}"]`).prop('checked', true);
            $('#ModalInputGuru .xalamat').val(data[0].alamat);
            $('#ModalInputGuru .xtmp_lahir').val(data[0].tmp_lahir);
            $('#ModalInputGuru .xtgl_lahir').val(data[0].tgl_lahir);
            $('#ModalInputGuru .select2.xid_jabatan').val(data[0].id_jabatan).select2().trigger('change');
            $('#ModalInputGuru .select2.xid_pangkat_golongan').val(data[0].id_pangkat_golongan).select2().trigger('change');
            $('#ModalInputGuru .select2.xid_pendidikan').val(data[0].id_pendidikan).select2().trigger('change');
            // input jurusan already filled in xid_pendidikan on click event below
            $('#ModalInputGuru .xtahun_ijazah').val(data[0].tahun_ijazah);
            
            $('#ModalInputGuru').modal('show');
          },
          error: function(request, status, error) {
            // console.log("ajax call went wrong:" + request.responseText);
            console.log("ajax call went wrong:" + error);
          }
        })
      });


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const id_guru   = $(this).data('id_guru');
        const nama_guru = $(this).data('nama_guru');
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Hapus data guru: ${nama_guru}?`,
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
              window.location = `guru_hapus.php?xid_guru=${id_guru}`;
            });
          }
        });
      });


      // Simpan penilaian confirmation sweetalert
      $('#ModalInputGuru button[type="submit"]').on('click', function(e) {
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
      
      
      $('#xid_pendidikan').on('change', function() {
        const id_pendidikan = $(this).val();
        const nama_pendidikan = $(this).find('option:selected').text();
      
        $.ajax({
          url: 'get_jurusan_pendidikan.php',
          method: 'POST',
          dataType: 'JSON',
          data: {
            'id_pendidikan' : id_pendidikan,
          },
          success: function(data) {
            if (!id_pendidikan) {
              $('#ModalInputGuru span.xid_jurusan').html('Pilih pendidikan terlebih dahulu!');
              $('#ModalInputGuru span.xid_jurusan').removeClass('form-control'); // to make sure there's no form-control before adding new one
              $('#ModalInputGuru span.xid_jurusan').addClass('form-control');
              $('#ModalDaftarJurusan').modal('show');
              return;
            }
      
            if (['tidak_sekolah', 'sd', 'smp', 'sltp'].includes(nama_pendidikan.toLowerCase())) {
              $('#ModalInputGuru span.xid_jurusan').html('Tidak perlu diisi.');
              $('#ModalInputGuru span.xid_jurusan').removeClass('form-control'); // to make sure there's no form-control before adding new one
              $('#ModalInputGuru span.xid_jurusan').addClass('form-control');
              $('#ModalDaftarJurusan').modal('show');
              return;
            }
      
            // set select html for select2 initialization
            const jurusan_select2_html = `<select name="xid_jurusan" class="form-control form-control-sm select2 xid_jurusan" id="xid_jurusan" required style="width: 100%"></select>`;
            
            // Clear text and specific style for span id jurusan
            $('#ModalInputGuru span.xid_jurusan').html(jurusan_select2_html);
            $('#ModalInputGuru span.xid_jurusan').removeClass('form-control');
      
            // Transform the data to the format that Select2 expects
            var transformedData = data.map(item => ({
                id: item.id_jurusan,
                text: item.nama_jurusan
            }));
            
            const jurusanSelect = $('select#xid_jurusan');
            jurusanSelect.select2({ 'width': '100%' });
            
            // Clear the select element
            jurusanSelect.html(null);
            
            // Set the transformed data to the select element using select2 method
            jurusanSelect.select2({
              data: transformedData
            });
            
            $('#ModalDaftarJurusan').modal('show');
          },
          error: function(request, status, error) {
            // console.log("ajax call went wrong:" + request.responseText);
            console.log("ajax call went wrong:" + error);
          }
        })
      });


      $('.datatables').on('click', '.toggle_modal_detail_guru', function() {
        const data = $(this).data();
        
        $('#ModalDetailGuru .xnama_guru').html(data.nama_guru);
        $('#ModalDetailGuru .xusername').html(data.username || 'Tidak ada (akun belum dibuat)');
        $('#ModalDetailGuru .xhak_akses').html(data.hak_akses || 'Tidak ada (akun belum dibuat)');
        $('#ModalDetailGuru .xalamat').html(data.alamat);
        $('#ModalDetailGuru .xtmp_tgl_lahir').html(`${data.tmp_lahir}, ${moment(data.tgl_lahir).format("DD MMMM YYYY")}`);

        $('#ModalDetailGuru').modal('show');
      });
      
    });
  </script>

</body>

</html>

<?php endif ?>