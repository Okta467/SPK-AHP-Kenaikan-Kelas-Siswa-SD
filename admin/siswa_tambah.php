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
    
    $id_kelas   = $_POST['xid_kelas'];
    $nisn       = $_POST['xnisn'];
    $nama_siswa = htmlspecialchars($purifier->purify($_POST['xnama_siswa']));
    $username   = $nisn;
    $password   = password_hash($_POST['xpassword'], PASSWORD_DEFAULT);
    $hak_akses  = 'siswa';
    $jk         = $_POST['xjk'];
    $alamat     = htmlspecialchars($purifier->purify($_POST['xalamat']));
    $tmp_lahir  = htmlspecialchars($purifier->purify($_POST['xtmp_lahir']));
    $tgl_lahir  = $_POST['xtgl_lahir'];
    $no_telp    = $_POST['xno_telp'];
    $email      = $_POST['xemail'];


    // Turn off autocommit mode
    mysqli_autocommit($connection, false);

    // Initialize the success flag
    $success = true;

    // Begin the transaction
    try {
        // Siswa statement preparation and execution
        $stmt_siswa  = mysqli_stmt_init($connection);
        $query_siswa = "INSERT INTO tbl_siswa 
        (
            id_kelas
            , nisn
            , nama_siswa
            , jk
            , alamat
            , tmp_lahir
            , tgl_lahir
            , no_telp
            , email
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if (!mysqli_stmt_prepare($stmt_siswa, $query_siswa)) {
            $_SESSION['msg'] = 'Statement Siswa preparation failed: ' . mysqli_stmt_error($stmt_siswa);
            echo "<meta http-equiv='refresh' content='0;siswa.php?go=siswa'>";
            return;
        }
        
        mysqli_stmt_bind_param($stmt_siswa, 'issssssss', $id_kelas, $nisn, $nama_siswa, $jk, $alamat, $tmp_lahir, $tgl_lahir, $no_telp, $email);
        
        if (!mysqli_stmt_execute($stmt_siswa)) {
            $_SESSION['msg'] = 'Statement Siswa preparation failed: ' . mysqli_stmt_error($stmt_siswa);
            echo "<meta http-equiv='refresh' content='0;siswa.php?go=siswa'>";
            return;
        }

        // Get last inserted id
        $id_siswa        = mysqli_insert_id($connection);
        $kode_alternatif = "A{$id_siswa}";

        // Alterantif statement preparation and execution
        $stmt_alternatif  = mysqli_stmt_init($connection);
        $query_alternatif = "INSERT INTO tbl_alternatif (id_siswa, kode_alternatif) VALUES (?, ?)";
        
        if (!mysqli_stmt_prepare($stmt_alternatif, $query_alternatif)) {
            $_SESSION['msg'] = 'Statement Alternatif preparation failed: ' . mysqli_stmt_error($stmt_alternatif);
            echo "<meta http-equiv='refresh' content='0;siswa.php?go=siswa'>";
            return;
        }
        
        mysqli_stmt_bind_param($stmt_alternatif, 'is', $id_siswa, $kode_alternatif);
        
        if (!mysqli_stmt_execute($stmt_alternatif)) {
            $_SESSION['msg'] = 'Statement Alternatif preparation failed: ' . mysqli_stmt_error($stmt_alternatif);
            echo "<meta http-equiv='refresh' content='0;siswa.php?go=siswa'>";
            return;
        }

        // Pengguna statement preparation and execution
        $stmt_pengguna  = mysqli_stmt_init($connection);
        $query_pengguna = "INSERT INTO tbl_pengguna (id_siswa, username, password, hak_akses) VALUES (?, ?, ?, ?)";
        
        if (!mysqli_stmt_prepare($stmt_pengguna, $query_pengguna)) {
            $_SESSION['msg'] = 'Statement Pengguna preparation failed: ' . mysqli_stmt_error($stmt_siswa);
            echo "<meta http-equiv='refresh' content='0;siswa.php?go=siswa'>";
            return;
        }
        
        mysqli_stmt_bind_param($stmt_pengguna, 'isss', $id_siswa, $username, $password, $hak_akses);
        
        if (!mysqli_stmt_execute($stmt_pengguna)) {
            $_SESSION['msg'] = 'Statement Pengguna preparation failed: ' . mysqli_stmt_error($stmt_siswa);
            echo "<meta http-equiv='refresh' content='0;siswa.php?go=siswa'>";
            return;
        }

        // Commit the transaction if all statements succeed
        if (!mysqli_commit($connection)) {
            $_SESSION['msg'] = 'Transaction commit failed: ' . mysqli_stmt_error($stmt_siswa);
            echo "<meta http-equiv='refresh' content='0;siswa.php?go=siswa'>";
            return;
        }

    } catch (Exception $e) {
        // Roll back the transaction if any statement fails
        $success = false;
        mysqli_rollback($connection);
        echo 'Transaction failed: ' . $e->getMessage();
    }

    // Close the statements
    mysqli_stmt_close($stmt_siswa);
    mysqli_stmt_close($stmt_alternatif);
    mysqli_stmt_close($stmt_pengguna);

    // Turn autocommit mode back on
    mysqli_autocommit($connection, true);

    // Close the connection
    mysqli_close($connection);

    !$success
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    echo "<meta http-equiv='refresh' content='0;siswa.php?go=siswa'>";
?>
