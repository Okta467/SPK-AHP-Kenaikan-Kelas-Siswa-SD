<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';

    $kriteria_ids                = $_POST['xkriteria_ids'];
    $sub_kriteria_id_input_names = $_POST['xsub_kriteria_id_input_names'];
    $id_alternatif               = $_POST['xid_alternatif'];
    $id_tahun_akademik           = $_POST['xid_tahun_akademik'];
    $id_kelas                    = $_POST['xid_kelas'];
    $jml_kriteria                = count($kriteria_ids);

    // Turn off autocommit mode
    mysqli_autocommit($connection, false);

    // Initialize the success flag
    $success = true;

    // Array to hold statement objects
    $stmts = array();

    for ($i = 0; $i < $jml_kriteria; $i++) {
        $stmt    = mysqli_stmt_init($connection);
        $stmts[] = $stmt;

        $id_kriteria = $kriteria_ids[$i];
        $id_sub_kriteria = $_POST["{$sub_kriteria_id_input_names[$i]}"];

        mysqli_stmt_prepare($stmt, "INSERT INTO tbl_penilaian_alternatif (id_alternatif, id_kriteria, id_sub_kriteria, id_tahun_akademik) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'iiii', $id_alternatif, $id_kriteria, $id_sub_kriteria, $id_tahun_akademik);
        
        if (!mysqli_stmt_execute($stmt)) {
            $success = false;
        }
    }

    // Close all statements
    foreach ($stmts as $stmt) {
        mysqli_stmt_close($stmt);
    }

    // Turn on autocommit mode
    mysqli_autocommit($connection, true);

    !$success
        ? mysqli_rollback($connection)
        : '';

    !$success
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_close($connection);

    $redirect_address = "penilaian_alternatif.php?go=penilaian_alternatif";
    $redirect_address .= "&id_kelas_filter={$id_kelas}";
    $redirect_address .= "&id_tahun_akademik_filter={$id_tahun_akademik}";

    echo "<meta http-equiv='refresh' content='0;{$redirect_address}'>";
?>