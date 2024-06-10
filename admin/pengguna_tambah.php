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
    
    $id_guru              = $_POST['xid_guru'] ?? NULL;
    $id_siswa             = $_POST['xid_siswa'] ?? NULL;
    $username             = htmlspecialchars($purifier->purify($_POST['xusername']));
    $password             = password_hash($_POST['xpassword'], PASSWORD_DEFAULT);
    $is_allowed_hak_akses = in_array($_POST['xhak_akses'], ['guru', 'kepala_sekolah', 'siswa', 'admin']); 
    $hak_akses            = $is_allowed_hak_akses ? $_POST['xhak_akses'] : NULL;

    if (!$is_allowed_hak_akses) {
        $_SESSION['msg'] = 'Hak akses yang diinput tidak diperbolehkan!';
        echo "<meta http-equiv='refresh' content='0;pengguna.php?go=pengguna'>";
        return;
    }

    $stmt = mysqli_stmt_init($connection);

    if ($hak_akses === 'admin'):
        
        mysqli_stmt_prepare($stmt, "INSERT INTO tbl_pengguna (username, password, hak_akses) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sss', $username, $password, $hak_akses);

    elseif ($hak_akses === 'siswa'):
        
        mysqli_stmt_prepare($stmt, "INSERT INTO tbl_pengguna (id_siswa, username, password, hak_akses) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'isss', $id_siswa, $username, $password, $hak_akses);

    elseif (in_array($hak_akses, ['guru', 'kepala_sekolah'])):
        
        mysqli_stmt_prepare($stmt, "INSERT INTO tbl_pengguna (id_guru, username, password, hak_akses) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'isss', $id_guru, $username, $password, $hak_akses);

    endif;

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;pengguna.php?go=pengguna'>";
?>