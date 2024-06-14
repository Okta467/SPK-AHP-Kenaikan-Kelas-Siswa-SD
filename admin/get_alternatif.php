<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_alternatif = $_POST['id_alternatif'];

    $stmt1 = mysqli_stmt_init($connection);
    $query = 
        "SELECT
            a.id AS id_alternatif, a.kode_alternatif,
            b.id AS id_siswa, b.nisn, b.nama_siswa, b.jk, b.alamat, b.tmp_lahir, b.tgl_lahir, b.no_telp, b.email,
            c.id AS id_kelas, c.nama_kelas,
            d.id AS id_wali_kelas, d.nama_guru AS nama_wali_kelas,
            e.id AS id_pengguna, e.username, e.hak_akses
        FROM tbl_alternatif AS a
        JOIN tbl_siswa AS b
            ON b.id = a.id_siswa
        LEFT JOIN tbl_kelas AS c
            ON c.id = b.id_kelas
        LEFT JOIN tbl_guru AS d
            ON d.id = c.id_wali_kelas
        LEFT JOIN tbl_pengguna AS e
            ON b.id = e.id_siswa
        WHERE a.id=?
        LIMIT 1";

    mysqli_stmt_prepare($stmt1, $query);
    mysqli_stmt_bind_param($stmt1, 'i', $id_alternatif);
    mysqli_stmt_execute($stmt1);

	$result = mysqli_stmt_get_result($stmt1);

    $alternatifs = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt1);
    mysqli_close($connection);

    echo json_encode($alternatifs);

?>