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
    
    $id_tingkat_kepentingan = $_POST['xid_tingkat_kepentingan'];
    $kode_kriteria          = $_POST['xkode_kriteria'];
    $nama_kriteria          = htmlspecialchars($purifier->purify($_POST['xnama_kriteria']));

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "INSERT INTO tbl_kriteria (id_tingkat_kepentingan, kode_kriteria, nama_kriteria) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'iss', $id_tingkat_kepentingan, $kode_kriteria, $nama_kriteria);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;kriteria.php?go=kriteria'>";
?>