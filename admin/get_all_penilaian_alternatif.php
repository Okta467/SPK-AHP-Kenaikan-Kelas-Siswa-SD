<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    // Get all penilaian alternatif even data searched is not exists

    // $id_kelas          = $_POST['id_kelas'];
    // $id_tahun_akademik = $_POST['id_tahun_akademik'];
    $id_kelas = 11;
    $id_tahun_akademik = 3;


    /**
     * Get data penilaian alternatif filtered by id_kelas and id_tahun_akademik
     */
    $stmt1 = mysqli_stmt_init($connection);
    $query = 
        "SELECT
            a.id AS id_siswa, a.nisn, a.nama_siswa, a.jk, a.alamat, a.tmp_lahir, a.tgl_lahir, a.no_telp, a.email,
            b.id AS id_alternatif, b.kode_alternatif,
            c.id AS id_kelas, c.nama_kelas,
            d.id AS id_wali_kelas, d.nama_guru AS nama_wali_kelas, d.nip,
            e.id AS id_penilaian_alternatif,
            f.id AS id_tahun_akademik, f.dari_tahun, f.sampai_tahun
        FROM tbl_siswa AS a
        LEFT JOIN tbl_alternatif AS b
            ON a.id = b.id_siswa
        LEFT JOIN tbl_kelas AS c
            ON c.id = a.id_kelas
        LEFT JOIN tbl_guru AS d
            ON d.id = c.id_wali_kelas
        LEFT JOIN tbl_penilaian_alternatif AS e
            ON b.id = e.id_alternatif
        LEFT JOIN tbl_tahun_akademik AS f
            ON f.id = e.id_tahun_akademik
        WHERE
            c.id = ?
            AND f.id = ?
        GROUP BY a.id
        ORDER BY a.id DESC";

    mysqli_stmt_prepare($stmt1, $query);
    mysqli_stmt_bind_param($stmt1, 'ii', $id_kelas, $id_tahun_akademik);
    mysqli_stmt_execute($stmt1);

	$result = mysqli_stmt_get_result($stmt1);

    $penilaian_alternatifs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    

    /**
     * Get all alternatif to compare/get alternatif that is not assessed
     */
    $stmt2 = mysqli_stmt_init($connection);
    $query = 
        "SELECT
            a.id AS id_siswa, a.nisn, a.nama_siswa, a.jk, a.alamat, a.tmp_lahir, a.tgl_lahir, a.no_telp, a.email,
            b.id AS id_alternatif, b.kode_alternatif,
            c.id AS id_kelas, c.nama_kelas,
            d.id AS id_wali_kelas, d.nama_guru AS nama_wali_kelas, d.nip
        FROM tbl_siswa AS a
        LEFT JOIN tbl_alternatif AS b
            ON a.id = b.id_siswa
        LEFT JOIN tbl_kelas AS c
            ON c.id = a.id_kelas
        LEFT JOIN tbl_guru AS d
            ON d.id = c.id_wali_kelas
        GROUP BY a.id
        ORDER BY a.id DESC";

    mysqli_stmt_prepare($stmt1, $query);
    mysqli_stmt_execute($stmt1);

	$result = mysqli_stmt_get_result($stmt1);

    $alternatifs = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Create an associative array with 'id_alternatif' as the key
    $mergedArray = [];

    foreach ($penilaian_alternatifs as $item) {
        $id_alternatif = $item['id_alternatif'];
        $mergedArray[$id_alternatif] = $item;
    }

    foreach ($alternatifs as $item) {
        $id_alternatif = $item['id_alternatif'];
        
        if (isset($mergedArray[$id_alternatif])) {
            // Merge the data from $alternatifs into the existing entry in $mergedArray
            $mergedArray[$id_alternatif] = array_merge($mergedArray[$id_alternatif], $item);
        } else {
            // If 'id_alternatif' does not exist in $penilaian_alternatifs, add the entry from $alternatifs
            $mergedArray[$id_alternatif] = $item;
        }
    }

    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
    mysqli_close($connection);
    
    return $mergedArray;
?>