<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendors/MY_vendors/htmlpurifier/HTMLPurifier.auto.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_pengguna          = $_POST['xid_pengguna'];
    $username             = htmlspecialchars($purifier->purify($_POST['xusername']));
    $password             = !empty($_POST['xpassword']) ? password_hash($_POST['xpassword'], PASSWORD_DEFAULT) : null;
    $is_allowed_hak_akses = in_array($_POST['xhak_akses'], ['guru', 'kepala_sekolah', 'siswa', 'admin']); 
    $hak_akses_yg_diinput = $is_allowed_hak_akses ? $_POST['xhak_akses'] : NULL;

    if (!$is_allowed_hak_akses) {
        $_SESSION['msg'] = 'Hak akses yang diinput tidak diperbolehkan!';
        echo "<meta http-equiv='refresh' content='0;pengguna.php?go=pengguna'>";
        return;
    }

    $query_pengguna     = mysqli_query($connection, "SELECT hak_akses FROM tbl_pengguna WHERE id = {$id_pengguna}");
    $pengguna_saat_ini  = mysqli_fetch_assoc($query_pengguna);
    $hak_akses_saat_ini = $pengguna_saat_ini['hak_akses'];

    /**
     * Cek apakah hak akses yg diinput diperbolehkan:
     *   admin          --> harus 'admin'
     *   siswa        --> harus 'siswa'
     *   guru           --> harus 'guru' / 'kepala_sekolah'
     *   kepala_sekolah --> harus 'guru' / 'kepala_sekolah'
    */
    if (
        $hak_akses_saat_ini === 'admin'
        && $hak_akses_yg_diinput !== 'admin'
        || $hak_akses_saat_ini === 'siswa'
        && $hak_akses_yg_diinput !== 'siswa'
        || in_array($hak_akses_saat_ini, ['guru', 'kepala_sekolah']) 
        && !in_array($hak_akses_yg_diinput, ['guru', 'kepala_sekolah'])
    ) {
        $_SESSION['msg'] = 'Hak akses yang diinput tidak diperbolehkan!';
        echo "<meta http-equiv='refresh' content='0;pengguna.php?go=pengguna'>";
        return;
    }

    $stmt = mysqli_stmt_init($connection);
    
    if (!$password) {
        mysqli_stmt_prepare($stmt, "UPDATE tbl_pengguna SET username=?, hak_akses=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssi', $username, $hak_akses_yg_diinput, $id_pengguna);
    } else {
        mysqli_stmt_prepare($stmt, "UPDATE tbl_pengguna SET username=?, password=?, hak_akses=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sssi', $username, $password, $hak_akses_yg_diinput, $id_pengguna);
    }

    $update = mysqli_stmt_execute($stmt);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;pengguna.php?go=pengguna'>";
?>