<?php
	session_start();
	include_once 'config/connection.php';

	// cek apakah tombol submit ditekan sebelum memproses verifikasi login
	if (!isset($_POST['xsubmit'])) {
		$_SESSION['msg'] = 'other_error';
		echo "<meta http-equiv='refresh' content='0;index.php'>";
		return;
	}

	$username = $_POST['xusername'];
	$password = $_POST['xpassword'];


	// jalankan mysql prepare statement untuk mencegah SQL Inject
	$stmt = mysqli_stmt_init($connection);

	mysqli_stmt_prepare($stmt, "SELECT * FROM tbl_pengguna WHERE username=?");
	mysqli_stmt_bind_param($stmt, 's', $username);
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	$user   = mysqli_fetch_assoc($result);

	mysqli_stmt_close($stmt);


	// redirect ke halaman login jika pengguna tidak ditemukan
	if (!$user) {
		$_SESSION['msg'] = 'user_not_found';
		echo "<meta http-equiv='refresh' content='0;index.php'>";
		return;
	}

	// cek apakah passwordnya benar?
	if (!password_verify($password, $user['password'])) {
		$_SESSION['msg'] = 'wrong_password';
		echo "<meta http-equiv='refresh' content='0;index.php'>";
		return;
	}

	// set sesi user sekarang
	$_SESSION['id_pengguna'] = $user['id'];
	$_SESSION['id_guru']     = $user['id_guru'];
	$_SESSION['id_siswa']    = $user['id_siswa'];
	$_SESSION['username']    = $user['username'];
	$_SESSION['hak_akses']   = $user['hak_akses'];
	

	// alihkan user ke halamannya masing-masing
	switch ($user['hak_akses']) {
		case 'admin':
			header("location:admin");
			break;

		case 'guru':
			header("location:guru/index.php?go=dashboard");
			break;
			
		case 'kepala_sekolah':
			header("location:kepala_sekolah/index.php?go=dashboard");
			break;
		
		default:
			header("location:index.php");
			break;
	}
?>