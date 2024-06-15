<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_range_nilai = $_POST['xid_range_nilai'];
    $batas_bawah    = $_POST['xbatas_bawah'];
    $batas_atas     = $_POST['xbatas_atas'];
    $range_nilai    = $_POST['xrange_nilai'];

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "UPDATE tbl_range_nilai SET batas_bawah=?, batas_atas=?, range_nilai=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'dddi', $batas_bawah, $batas_atas, $range_nilai, $id_range_nilai);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;range_nilai.php?go=range_nilai'>";
?>