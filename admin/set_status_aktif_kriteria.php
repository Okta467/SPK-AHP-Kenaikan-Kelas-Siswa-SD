<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_kriteria = $_POST['id_kriteria'];

    // Get status aktif from kriteria by id
    $stmt1 = mysqli_stmt_init($connection);
    $query = "SELECT status_aktif FROM tbl_kriteria WHERE id=?";

    mysqli_stmt_prepare($stmt1, $query);
    mysqli_stmt_bind_param($stmt1, 'i', $id_kriteria);
    mysqli_stmt_execute($stmt1);

	$result = mysqli_stmt_get_result($stmt1);
    $kriteria = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!$kriteria) {
        echo json_encode(false);
        return;
    }

    // Switch status kriteria from aktif to non-aktif, vice versa
    $stmt2 = mysqli_stmt_init($connection);

    $status_aktif = $kriteria[0]['status_aktif'];

    $query_update = !$status_aktif
        ? "UPDATE tbl_kriteria SET status_aktif='1' WHERE id=?"
        : "UPDATE tbl_kriteria SET status_aktif='0' WHERE id=?";

    mysqli_stmt_prepare($stmt2, $query_update);
    mysqli_stmt_bind_param($stmt2, 'i', $id_kriteria);

    $update = mysqli_stmt_execute($stmt2);

    echo json_encode($update);

?>