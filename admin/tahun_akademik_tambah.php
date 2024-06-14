<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $dari_tahun   = $_POST['xdari_tahun'];
    $sampai_tahun = $_POST['xsampai_tahun'];

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "INSERT INTO tbl_tahun_akademik (dari_tahun, sampai_tahun) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, 'ii', $dari_tahun, $sampai_tahun);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;tahun_akademik.php?go=tahun_akademik'>";
?>