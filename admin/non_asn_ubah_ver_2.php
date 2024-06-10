<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendors/htmlpurifier/HTMLPurifier.auto.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_pegawai          = $_POST['xid_pegawai'];
    $nik                 = $_POST['xnik'];
    $nama_pegawai        = htmlspecialchars($purifier->purify($_POST['xnama_pegawai']));
    $username            = $nik;
    $password            = $_POST['password'] ?? null;
    $hak_akses           = $_POST['xhak_akses'] === 'non_asn' ?? 'pimpinan';
    $jk                  = $_POST['xjk'];
    $alamat              = $_POST['xalamat'];
    $tmp_lahir           = htmlspecialchars($purifier->purify($_POST['xtmp_lahir']));
    $tgl_lahir           = $_POST['xtgl_lahir'];
    $id_jabatan          = $_POST['xid_jabatan'];
    $tmt                 = $_POST['xtmt'];
    $id_pangkat_golongan = $_POST['xid_pangkat_golongan'];
    $id_pendidikan       = $_POST['xid_pendidikan'];
    $id_jurusan          = $_POST['xid_jurusan'] ?? null;

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "UPDATE tbl_pegawai SET
            id_jabatan = ?
            , id_pangkat_golongan = ?
            , id_pendidikan = ?
            , id_jurusan_pendidikan = ?
            , nik = ?
            , nama_pegawai = ?
            , jk = ?
            , alamat = ?
            , tmp_lahir = ?
            , tgl_lahir = ?
            , tmt = ?
        WHERE id = ?
        ");

    mysqli_stmt_bind_param($stmt, 'iiiiissssssi', $id_jabatan, $id_pangkat_golongan, $id_pendidikan, $id_jurusan, $nik, $nama_pegawai, $jk, $alamat, $tmp_lahir, $tgl_lahir, $tmt, $id_pegawai);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;non_asn.php?go=non_asn'>";
?>