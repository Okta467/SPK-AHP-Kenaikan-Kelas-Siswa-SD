<?php
include '../helpers/user_login_checker.php';

// cek apakah user yang mengakses adalah admin?
if (!isAccessAllowed('admin')):
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else:
  include_once '../config/connection.php';
  include_once '../helpers/getAllPenilaianAlternatifHelper.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '_partials/head.php' ?>

  <meta name="Description" content="Data Penilaian Alternatif">
  <title>Data Penilaian Alternatif - <?= SITE_NAME ?></title>
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
                  <h3 class="font-weight-bold">Halaman Penilaian Alternatif</h3>
                  <h6 class="font-weight-normal mb-0">Halaman untuk mengelola (lihat, ubah, dan hapus) data penilaian alternatif.</h6>
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


          <!-- Filter Data -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-filter mr-2"></i>Filter Data</h4>
                  </div>
                  <p class="card-description">
                    Harap input <span class="text-danger font-weight-bold">filter data</span> berikut untuk melakukan penilaian alternatif.
                  </p>
                  <form action="penilaian_alternatif.php" method="GET">

                    <?php
                    $id_kelas_filter = $_GET['id_kelas_filter'] ?? null;
                    $id_tahun_akademik_filter = $_GET['id_tahun_akademik_filter'] ?? null;
                    ?>

                    <input type="hidden" name="go" value="penilaian_alternatif">
                  
                    <div class="form-group row">

                      <div class="col-sm-2">
                        <label for="kelas_filter">Kelas</label>
                        <select name="id_kelas_filter" class="form-control form-control-sm select2 kelas_filter" id="kelas_filter" required style="width: 100%">
                          <option value="">-- Pilih --</option>
                          <?php
                          $query_kelas = mysqli_query($connection, "SELECT id, nama_kelas FROM tbl_kelas ORDER BY nama_kelas ASC");

                          while ($kelas = mysqli_fetch_assoc($query_kelas)):
                            $select_kelas_filter = ($id_kelas_filter === $kelas['id']) ? 'selected' : '';
                          ?>

                            <option value="<?= $kelas['id'] ?>" <?= $select_kelas_filter ?>><?= $kelas['nama_kelas'] ?></option>
                            
                          <?php endwhile ?>
                        </select>
                      </div>
                      
                      <div class="col-sm-2">
                        <label for="id_tahun_akademik_filter">Tahun Akademik</label>
                        <select name="id_tahun_akademik_filter" class="form-control form-control-sm select2 id_tahun_akademik_filter" id="id_tahun_akademik_filter" required style="width: 100%">
                          <option value="">-- Pilih --</option>
                          <?php
                          $query_tahun_akademik = mysqli_query($connection, "SELECT id, dari_tahun, sampai_tahun FROM tbl_tahun_akademik ORDER BY dari_tahun DESC");

                          while ($tahun_akademik = mysqli_fetch_assoc($query_tahun_akademik)):
                            $select_tahun_akademik = ($id_tahun_akademik_filter === $tahun_akademik['id'])? 'selected' : '';
                          ?>

                            <option value="<?= $tahun_akademik['id'] ?>" <?= $select_tahun_akademik ?>><?= "{$tahun_akademik['dari_tahun']} / {$tahun_akademik['sampai_tahun']}" ?></option>
                            
                          <?php endwhile ?>
                        </select>
                      </div>
                      
                      <div class="col-sm-2 d-flex align-items-end mt-3">
                        <button type="submit" class="btn btn-md btn-dark btn-icon-text toggle_modal_tambah">Filter Data</button>
                      </div>

                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!--/.filter-data -->


          <!-- DataTables -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title"><i class="ti-write mr-2"></i>Data Penilaian Alternatif</h4>
                  </div>
                  <p class="card-description">
                    Data yang ditampilkan merupakan <span class="text-danger font-weight-bold">siswa</span> yang data <span class="text-danger font-weight-bold">alternatifnya</span> sudah diinput.
                  </p>
                  <div class="table-responsive">
                    <table class="table table-striped datatables">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Kode Alternatif</th>
                          <th>Nama/NISN</th>
                          <th class="text-center">JK</th>
                          <th>Kelas</th>
                          <th>Wali Kelas</th>
                          <th>Status Penilaian</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!$id_kelas_filter || !$id_tahun_akademik_filter): ?>

                          <!-- Show empty data -->

                        <?php else: ?>
                        
                          <?php
                          $no = 1;
                          $alternatifs = getAllPenilaianAlternatif($id_kelas_filter, $id_tahun_akademik_filter, $connection);

                          foreach ($alternatifs as $alternatif):
                            $id_penilaian_alternatif = $alternatif['id_penilaian_alternatif'] ?? null; ?>

                            <tr>
                              <td><?= $no++ ?></td>
                              <td><?= $alternatif['kode_alternatif'] ?? "<small class='text-muted'>Tidak Ada</small>" ?></td>
                              <td><?= htmlspecialchars($alternatif['nama_siswa']) . "<br><small class='text-muted'>({$alternatif['nisn']})</small>" ?></td>
                              <td class="text-center"><?= ucfirst($alternatif['jk']) ?></td>
                              <td><?= $alternatif['nama_kelas'] ?></td>
                              <td><?= htmlspecialchars($alternatif['nama_wali_kelas']) . "<br><small class='text-muted'>({$alternatif['nip']})</small>" ?></td>
                              <td>
                                <?=
                                !$id_penilaian_alternatif
                                  ? '<span class="font-weight-bold text-danger">Belum Dinilai</span>'
                                  : '<span class="font-weight-bold text-success">Sudah Dinilai</span>'
                                ?>
                              </td>
                              <td>
                                
                                <!-- Toggle Modal Penilaian -->
                                <?php if ($id_penilaian_alternatif): ?>

                                  <button type="button" class="btn btn-sm btn-outline-secondary btn-icon-text py-1 disabled" data-toggle="tooltip" data-placement="top" title="Sudah Dinilai"><i class="ti-write -alt mr-0"></i></button>
                                  
                                <?php else: ?>

                                  <button type="button" class="btn btn-sm btn-inverse-info btn-icon-text py-1 toggle_modal_penilaian" data-toggle="tooltip" data-placement="top" title="Nilai"
                                    data-id_alternatif="<?= $alternatif['id_alternatif'] ?>"
                                    data-kode_alternatif="<?= $alternatif['kode_alternatif'] ?>"
                                    data-nama_siswa="<?= $alternatif['nama_siswa'] ?>"
                                    data-nama_kelas="<?= $alternatif['nama_kelas'] ?>">
                                    <i class="ti-write -alt mr-0"></i>
                                  </button>
                                
                                <?php endif ?>
                                

                                <!-- Toggle Modal Ubah Penilaian -->
                                <?php if (!$id_penilaian_alternatif): ?>

                                  <button type="button" class="btn btn-sm btn-outline-secondary btn-icon-text py-1 disabled" data-toggle="tooltip" data-placement="top" title="Ubah Penilaian"><i class="ti-pencil-alt -alt mr-0"></i></button>

                                <?php else: ?>

                                  <button type="button" class="btn btn-sm btn-inverse-dark btn-icon-text py-1 toggle_modal_ubah" data-toggle="tooltip" data-placement="top" title="Ubah Penilaian"
                                    data-id_alternatif="<?= $alternatif['id_alternatif'] ?>"
                                    data-id_tahun_akademik="<?= $id_tahun_akademik_filter ?>">
                                    <i class="ti-pencil-alt mr-0"></i>
                                  </button>

                                <?php endif ?>
                              

                                <!-- Toggle Modal Reset Penilaian -->
                                <?php if (!$id_penilaian_alternatif): ?>
                                  <button type="button" class="btn btn-sm btn-outline-secondary btn-icon-text py-1 disabled" data-toggle="tooltip" data-placement="top" title="Reset Penilaian"><i class="ti-trash -alt mr-0"></i></button>

                                <?php else: ?>
                                  
                                  <button type="button" class="btn btn-sm btn-inverse-danger btn-icon-text py-1 toggle_modal_hapus" data-toggle="tooltip" data-placement="top" title="Reset Penilaian"
                                    data-id_alternatif="<?= $alternatif['id_alternatif'] ?>"
                                    data-id_kelas="<?= $id_kelas_filter ?>"
                                    data-id_tahun_akademik="<?= $id_tahun_akademik_filter ?>"
                                    data-kode_alternatif="<?= $alternatif['kode_alternatif'] ?>"
                                    data-nama_siswa="<?= $alternatif['nama_siswa'] ?>"
                                    data-nama_kelas="<?= $alternatif['nama_kelas'] ?>">
                                    <i class="ti-trash mr-0"></i>
                                  </button>

                                <?php endif ?>
                                
                              </td>
                            </tr>

                          <?php endforeach ?>

                        <?php endif ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/.datatables -->

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


  <!--============================= MODAL PENILAIAN ALTERNATIF =============================-->
  <div class="modal fade" id="ModalInputPenilaianAlternatif" tabindex="-1" role="dialog" aria-labelledby="ModalInputPenilaianAlternatif" aria-hidden="true">
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
          
          <div class="card">
            <div class="card-body p-0 pb-3">
              <h4 class="card-title"><i class="ti-medall mr-2"></i>Alternatif</h4>
              <p><b>Kode Alternatif</b>: <span class="xkode_alternatif"></span></p>
              <p><b>Nama</b>: <span class="xnama_siswa"></span></p>
              <p><b>Kelas</b>: <span class="xnama_kelas"></span></p>
            </div>
          </div>
          
          <div class="badge badge-outline-dark mb-4 w-100">
            <p class="m-0">
              <i class="ti-info-alt mr-2"></i>Pastikan kolom input <span class="text-danger">Range Nilai</span> terisi sebelum menyimpan.
            </p>
          </div>

          <?php
          $query_existing_kriteria_by_tahun_akademik = mysqli_query($connection, 
            "SELECT
              b.id AS id_kriteria, b.kode_kriteria, b.nama_kriteria,
              c.id AS id_tingkat_kepentingan, c.nilai_kepentingan
            FROM tbl_penilaian_alternatif AS a
            INNER JOIN tbl_kriteria AS b
              ON b.id = a.id_kriteria
            INNER JOIN tbl_tingkat_kepentingan AS c
              ON c.id = b.id_tingkat_kepentingan
            WHERE a.id_tahun_akademik = {$id_tahun_akademik_filter}
            GROUP BY a.id_kriteria");
            
          $query_all_kriteria = mysqli_query($connection, "SELECT *, id AS id_kriteria FROM tbl_kriteria WHERE status_aktif='1'");

          $query_kriteria = !$query_existing_kriteria_by_tahun_akademik->num_rows
            ? $query_all_kriteria
            : $query_existing_kriteria_by_tahun_akademik;

          $kriterias = mysqli_fetch_all($query_kriteria, MYSQLI_ASSOC);
          ?>

          <input type="hidden" name="xid_alternatif" class="xid_alternatif">
          <input type="hidden" name="xid_kelas" class="xid_kelas">
          <input type="hidden" name="xid_tahun_akademik" class="xid_tahun_akademik">
          <?php foreach($kriterias as $kriteria): ?>
            <input type="hidden" name="xid_kriterias[]" value="<?= $kriteria['id_kriteria'] ?>">
          <?php endforeach ?>
          
          <div class="row">

            <?php foreach($kriterias as $kriteria): ?>

              <div class="col-sm-8">
                <div class="form-group">
                  <label><?= "{$kriteria['kode_kriteria']} - {$kriteria['nama_kriteria']}" ?></label>
                  <input type="number" min="0" max="" name="xnilai_siswas[]" min="0" class="form-control form-control-sm xnilai_siswa" placeholder="Min. 0, Max. 100" required>
                </div>
              </div>
            
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Range Nilai</label>
                  <input type="number" min="0" name="xrange_nilai[]" class="form-control form-control-sm xrange_nilai" placeholder="Range Nilai" readonly required>
                  <input type="hidden" name="xid_sub_kriterias[]" class="xid_sub_kriteria">
                </div>
              </div>
            
            <?php endforeach ?>

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
  <!--/.modal-penilaian-alternatif -->


  <?php include '_partials/script.php' ?>
  <?php include '../helpers/sweetalert_notify.php' ?>

  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      $(".datatables").DataTable({});
      
      $('.select2').select2({
        width: '100%'
      });

      $('.toggle_tooltip').tooltip({
        placement: 'top',
        delay: {
          show: 100,
          hide: 100
        }
      })
      

      $('.toggle_modal_penilaian').on('click', function() {
        const data              = $(this).data();
        const id_tahun_akademik = "<?= $id_tahun_akademik_filter ?>";
        const id_kelas          = "<?= $id_kelas_filter ?>";
        
        $('#ModalInputPenilaianAlternatif .modal-title').html(`<i class="ti-write mr-2"></i>Penilaian Baru`);
        $('#ModalInputPenilaianAlternatif form').attr({action: 'penilaian_alternatif_tambah.php', method: 'post'});

        $('#ModalInputPenilaianAlternatif input.xid_alternatif').val(data.id_alternatif);
        $('#ModalInputPenilaianAlternatif input.xid_tahun_akademik').val(id_tahun_akademik);
        $('#ModalInputPenilaianAlternatif input.xid_kelas').val(id_kelas);
        $('#ModalInputPenilaianAlternatif span.xkode_alternatif').html(data.kode_alternatif);
        $('#ModalInputPenilaianAlternatif span.xnama_siswa').html(data.nama_siswa);
        $('#ModalInputPenilaianAlternatif span.xnama_kelas').html(data.nama_kelas);

        $('#ModalInputPenilaianAlternatif').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_ubah', function() {
        const id_alternatif     = $(this).data('id_alternatif');
        const id_tahun_akademik = $(this).data('id_tahun_akademik');

        $('#ModalInputPenilaianAlternatif .modal-title').html(`<i class="ti-pencil-alt mr-2"></i>Ubah Penilaian Alternatif`);
        $('#ModalInputPenilaianAlternatif form').attr({action: 'penilaian_alternatif_ubah.php', method: 'post'});

        $.ajax({
          url: 'get_penilaian_alternatif.php',
          method: 'POST',
          data: {
            'id_alternatif': id_alternatif,
            'id_tahun_akademik': id_tahun_akademik,
          },
          dataType: 'JSON',
          success: function(data) {
            console.log(data)
            $('#ModalInputPenilaianAlternatif input.xid_alternatif').val(data[0].id_alternatif);
            $('#ModalInputPenilaianAlternatif input.xid_kelas').val(data[0].id_kelas);
            $('#ModalInputPenilaianAlternatif input.xid_tahun_akademik').val(data[0].id_tahun_akademik);
            
            $('#ModalInputPenilaianAlternatif span.xkode_alternatif').html(data[0].kode_alternatif);
            $('#ModalInputPenilaianAlternatif span.xnama_siswa').html(data[0].nama_siswa);
            $('#ModalInputPenilaianAlternatif span.xnama_kelas').html(data[0].nama_kelas);

            let index = 0;

            data.forEach(data => {
              $('#ModalInputPenilaianAlternatif .xnilai_siswa').eq(index).val(data.nilai_siswa);
              $('#ModalInputPenilaianAlternatif .xid_sub_kriteria').eq(index).val(data.id_sub_kriteria);
              $('#ModalInputPenilaianAlternatif .xrange_nilai').eq(index).val(data.range_nilai);
              
              index++;
            });
            
            $('#ModalInputPenilaianAlternatif').modal('show');
          },
          error: function(request, status, error) {
            // console.log("ajax call went wrong:" + request.responseText);
            console.log("ajax call went wrong:" + error);
          }
        })
      });


      $('.xnilai_siswa').on('keyup', delay(function(e) {
        const nilai_siswa = $(this).val();
        const index = $('.xnilai_siswa').index(this);

        if (!nilai_siswa) {
          $('#ModalInputPenilaianAlternatif .xid_range_nilai').eq(index).val(null);
          $('#ModalInputPenilaianAlternatif .xrange_nilai').eq(index).val(null);
          return;
        }

        $.ajax({
          url: 'get_range_nilai.php',
          type: 'POST',
          dataType: 'JSON',
          data: {
            'nilai_siswa': nilai_siswa
          },
          success: function(data) {
            $('#ModalInputPenilaianAlternatif .xid_sub_kriteria').eq(index).val(data.id_sub_kriteria);
            $('#ModalInputPenilaianAlternatif .xrange_nilai').eq(index).val(data.range_nilai);
          },
          error: function(request, status, error) {
            // console.log("ajax call went wrong:" + request.responseText);
            console.log("ajax call went wrong:" + error);
          }
        })
      }, 300));


      $('.datatables').on('click', '.toggle_modal_hapus', function() {
        const data = $(this).data();
        
        swal({
          title: "Konfirmasi Tindakan?",
          text: `Reset penilaian: (${data.kode_alternatif}) ${data.nama_siswa} -- Kelas ${data.nama_kelas}?`,
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
              window.location = `penilaian_alternatif_hapus.php?xid_alternatif=${data.id_alternatif}&xid_kelas=${data.id_kelas}&xid_tahun_akademik=${data.id_tahun_akademik}`;
            });
          }
        });
      });

      
      // Simpan penilaian confirmation sweetalert
      $('#ModalInputPenilaianAlternatif button[type="submit"]').on('click', function(e) {
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

    });
  </script>

</body>

</html>

<?php endif ?>