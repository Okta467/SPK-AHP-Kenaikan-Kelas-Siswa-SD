<?php if (!isset($_SESSION['msg'])): ?>

<?php elseif ($_SESSION['msg'] === 'save_success'): ?>

  <script>
    swal({
      title: "Berhasil!",
      text: "Data berhasil disimpan!",
      icon: "success",
      timer: 3000,
      button: {
        text: "OK",
        className: "bg-success",
      },
    });
  </script>

<?php elseif ($_SESSION['msg'] === 'update_success'): ?>

  <script>
    swal({
      title: "Berhasil!",
      text: "Data berhasil diubah!",
      icon: "success",
      timer: 3000,
      button: {
        text: "OK",
        className: "bg-success",
      },
    });
  </script>

<?php elseif ($_SESSION['msg'] === 'delete_success'): ?>

  <script>
    swal({
      title: "Berhasil!",
      text: "Data berhasil dihapus!",
      icon: "success",
      timer: 3000,
      button: {
        text: "OK",
        className: "bg-success",
      },
    });
  </script>

<?php elseif ($_SESSION['msg'] === 'user_not_found'): ?>

  <script>
    swal({
      title: "Gagal!",
      text: "Pengguna tidak ditemukan!",
      icon: "error",
      timer: 3000,
      button: {
        text: "OK",
        className: "bg-danger",
      },
    });
  </script>
  
<?php elseif ($_SESSION['msg'] === 'wrong_password'): ?>

  <script>
    swal({
      title: "Gagal!",
      text: "Password yang di-input salah!",
      icon: "error",
      timer: 3000,
      button: {
        text: "OK",
        className: "bg-danger",
      },
    });
  </script>

<?php elseif ($_SESSION['msg'] === 'other_error'): ?>

  <script>
    swal({
      title: "Error!",
      text: "Terjadi kesalahan!",
      icon: "error",
      timer: 3000,
      button: {
        text: "OK",
        className: "bg-danger",
      },
    });
  </script>

<?php elseif ($_SESSION['msg'] !== ''): ?>

  <script>
    swal({
      title: "Error!",
      text: "<?= $_SESSION['msg'] ?>",
      icon: "error",
      button: {
        text: "OK",
        className: "bg-danger",
      },
    });
  </script>

<?php endif ?>

<?php unset($_SESSION['msg']) ?>