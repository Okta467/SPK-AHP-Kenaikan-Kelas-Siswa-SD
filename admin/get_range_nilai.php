<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $nilai_siswa = $_POST['nilai_siswa'];

    $stmt1 = mysqli_stmt_init($connection);
    $query = 
        "SELECT
            a.id AS id_range_nilai, a.batas_bawah, a.batas_atas, a.range_nilai,
            b.id AS id_sub_kriteria, b.nama_sub_kriteria
        FROM tbl_range_nilai AS a
        LEFT JOIN tbl_sub_kriteria AS b
            ON a.id = b.id_range_nilai
        WHERE a.batas_bawah <= ? AND a.batas_atas >= ? LIMIT 1";

    mysqli_stmt_prepare($stmt1, $query);
    mysqli_stmt_bind_param($stmt1, 'dd', $nilai_siswa, $nilai_siswa);
    mysqli_stmt_execute($stmt1);

	$result = mysqli_stmt_get_result($stmt1);

    $range_nilai = !$result
        ? array()
        : mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt1);
    mysqli_close($connection);

    echo json_encode($range_nilai);

?>