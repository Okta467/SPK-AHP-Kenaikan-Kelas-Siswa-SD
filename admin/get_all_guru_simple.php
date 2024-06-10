<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';

    $stmt1 = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt1, "SELECT id AS id_guru, nama_guru FROM tbl_guru");
    mysqli_stmt_execute($stmt1);

	$result = mysqli_stmt_get_result($stmt1);

    $gurus = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt1);
    mysqli_close($connection);

    echo json_encode($gurus);

?>