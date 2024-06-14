<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendors/MY_vendors/htmlpurifier/HTMLPurifier.auto.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_sub_kriteria   = $_POST['xid_sub_kriteria'];
    $id_kriteria       = $_POST['xid_kriteria'];
    $kode_sub_kriteria = $_POST['xkode_sub_kriteria'];
    $nama_sub_kriteria = htmlspecialchars($purifier->purify($_POST['xnama_sub_kriteria']));
    $bobot             = $_POST['xbobot'];

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "UPDATE tbl_sub_kriteria SET id_kriteria=?, kode_sub_kriteria=?, nama_sub_kriteria=?, bobot=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'issdi', $id_kriteria, $kode_sub_kriteria, $nama_sub_kriteria, $bobot, $id_sub_kriteria);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;sub_kriteria.php?go=sub_kriteria'>";
?>