<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah kepala_sekolah?
    if (!isAccessAllowed('kepala_sekolah')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_alternatif     = $_POST['id_alternatif'];
    $id_tahun_akademik = $_POST['id_tahun_akademik'];

    $stmt1 = mysqli_stmt_init($connection);
    $query = 
        "SELECT
            a.id AS id_penilaian_alternatif, a.nilai_siswa,
            b.id AS id_alternatif, b.kode_alternatif,
            c.id AS id_siswa, c.nisn, c.nama_siswa, c.jk, c.alamat, c.tmp_lahir, c.tgl_lahir, c.no_telp, c.email,
            d.id AS id_kelas, d.nama_kelas,
            e.id AS id_kriteria, e.kode_kriteria, e.nama_kriteria, e.status_aktif,
            f.id AS id_tingkat_kepentingan, f.nilai_kepentingan, f.keterangan,
            g.id AS id_sub_kriteria, g.kode_sub_kriteria, g.nama_sub_kriteria,
            h.id AS id_range_nilai, h.batas_bawah, h.batas_atas, h.range_nilai,
            i.id AS id_tahun_akademik, i.dari_tahun, i.sampai_tahun
        FROM tbl_penilaian_alternatif AS a
        LEFT JOIN tbl_alternatif AS b
            ON b.id = a.id_alternatif
        LEFT JOIN tbl_siswa AS c
            ON c.id = b.id_siswa
        LEFT JOIN tbl_kelas AS d
            ON d.id = c.id_kelas
        LEFT JOIN tbl_kriteria AS e
            ON e.id = a.id_kriteria
        LEFT JOIN tbl_tingkat_kepentingan AS f
            ON f.id = e.id_tingkat_kepentingan
        LEFT JOIN tbl_sub_kriteria AS g
            ON g.id = a.id_sub_kriteria
        LEFT JOIN tbl_range_nilai AS h
            ON h.id = g.id_range_nilai
        LEFT JOIN tbl_tahun_akademik AS i
            ON i.id = a.id_tahun_akademik
        WHERE a.id_alternatif=? AND a.id_tahun_akademik=?
        ORDER BY a.id ASC";

    mysqli_stmt_prepare($stmt1, $query);
    mysqli_stmt_bind_param($stmt1, 'ii', $id_alternatif, $id_tahun_akademik);
    mysqli_stmt_execute($stmt1);

	$result = mysqli_stmt_get_result($stmt1);

    $penilaian_alternatifs = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt1);
    mysqli_close($connection);

    echo json_encode($penilaian_alternatifs);

?>