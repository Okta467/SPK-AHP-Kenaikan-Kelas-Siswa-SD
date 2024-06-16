<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah guru?
    if (!isAccessAllowed('guru')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';

    $id_alternatif     = $_POST['xid_alternatif'];
    $id_kelas          = $_POST['xid_kelas'];
    $id_tahun_akademik = $_POST['xid_tahun_akademik'];
    $id_kriterias      = $_POST['xid_kriterias'];
    $id_sub_kriterias  = $_POST['xid_sub_kriterias'];
    $nilai_siswas      = $_POST['xnilai_siswas'];
    $jml_kriteria      = count($id_kriterias);

    // Turn off autocommit mode
    mysqli_autocommit($connection, false);

    // Initialize the success flag
    $success = true;

    /**
     * Delete statement
     */
    $stmt_delete = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_delete, "DELETE FROM tbl_penilaian_alternatif WHERE id_alternatif=?");
    mysqli_stmt_bind_param($stmt_delete, 'i', $id_alternatif);
    
    if (!mysqli_stmt_execute($stmt_delete)) {
        $success = false;
    }
    
    /**
     * Insert Statement
     */
    $placeholders = implode(', ', array_fill(0, $jml_kriteria, '(?, ?, ?, ?, ?)'));
    $sql = "INSERT INTO tbl_penilaian_alternatif (id_alternatif, id_kriteria, id_sub_kriteria, id_tahun_akademik, nilai_siswa) VALUES $placeholders";

    $stmt_insert = mysqli_prepare($connection, $sql);

    // Flatten the data arrays to a single array for binding
    $data = [];
    for ($i = 0; $i < $jml_kriteria; $i++) {
        $id_kriteria     = $id_kriterias[$i];
        $id_sub_kriteria = $id_sub_kriterias[$i];
        $nilai_siswa     = $nilai_siswas[$i];

        $data[] = $id_alternatif;
        $data[] = $id_kriteria;
        $data[] = $id_sub_kriteria;
        $data[] = $id_tahun_akademik;
        $data[] = $nilai_siswa;
    }

    // Create the types string (e.g., 'ii' for two integers, 'iiiiii' for six integers, etc.)
    $types = str_repeat('iiiid', $jml_kriteria);
    
    // Use call_user_func_array to bind the parameters dynamically
    $bindNames = [];
    $bindNames[] = &$types;
    for ($i = 0; $i < count($data); $i++) {
        $bindNames[] = &$data[$i];
    }
    call_user_func_array('mysqli_stmt_bind_param', array_merge([$stmt_insert], $bindNames));
    
    if (!mysqli_stmt_execute($stmt_insert)) {
        $success = false;
    }

    !$success
        ? mysqli_rollback($connection)
        : mysqli_autocommit($connection, true);;

    !$success
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt_insert);
    mysqli_close($connection);

    $redirect_address = "penilaian_alternatif.php?go=penilaian_alternatif";
    $redirect_address .= "&id_kelas_filter={$id_kelas}";
    $redirect_address .= "&id_tahun_akademik_filter={$id_tahun_akademik}";

    echo "<meta http-equiv='refresh' content='0;{$redirect_address}'>";
?>