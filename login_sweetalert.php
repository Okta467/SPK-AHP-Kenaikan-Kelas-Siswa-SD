<?php if (!isset($_SESSION['msg'])): ?>

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

<?php endif ?>

<?php unset($_SESSION['msg']) ?>