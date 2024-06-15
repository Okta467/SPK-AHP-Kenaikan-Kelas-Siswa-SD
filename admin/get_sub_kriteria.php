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

    $stmt = mysqli_stmt_init($connection);
    $query = 
        "SELECT
            a.id AS id_sub_kriteria, a.kode_sub_kriteria, a.nama_sub_kriteria,
            b.id AS id_kriteria, b.kode_kriteria, b.nama_kriteria, b.status_aktif,
            c.id AS id_tingkat_kepentingan, c.nilai_kepentingan, c.keterangan,
            d.id AS id_range_nilai, d.batas_bawah, d.batas_atas, d.range_nilai
        FROM tbl_sub_kriteria AS a
        LEFT JOIN tbl_kriteria AS b
            ON a.id_kriteria = b.id
        LEFT JOIN tbl_tingkat_kepentingan AS c
            ON b.id_tingkat_kepentingan = c.id
        LEFT JOIN tbl_range_nilai AS d
            ON a.id_range_nilai = d.id
        WHERE id_kriteria=?";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_kriteria);
    mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

    $sub_kriterias = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo json_encode($sub_kriterias);

?>