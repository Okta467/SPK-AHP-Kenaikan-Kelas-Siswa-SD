<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_range_nilai = $_GET['xid_range_nilai'];

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "DELETE FROM tbl_range_nilai WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'i', $id_range_nilai);

    $delete = mysqli_stmt_execute($stmt);

    !$delete
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = '';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;range_nilai.php?go=range_nilai'>";
?>