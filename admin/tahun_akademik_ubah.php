<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_tahun_akademik = $_POST['xid_tahun_akademik'];
    $dari_tahun        = $_POST['xdari_tahun'];
    $sampai_tahun      = $_POST['xsampai_tahun'];

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "UPDATE tbl_tahun_akademik SET dari_tahun=?, sampai_tahun=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'iii', $dari_tahun, $sampai_tahun, $id_tahun_akademik);

    $update = mysqli_stmt_execute($stmt);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;tahun_akademik.php?go=tahun_akademik'>";
?>