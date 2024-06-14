<?php
    include '../helpers/user_login_checker.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_alternatif     = $_GET['xid_alternatif'];
    $id_tahun_akademik = $_GET['xid_tahun_akademik'];
    $id_kelas          = $_GET['xid_kelas'];

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "DELETE FROM tbl_penilaian_alternatif WHERE id_alternatif=? AND id_tahun_akademik=?");
    mysqli_stmt_bind_param($stmt, 'ii', $id_alternatif, $id_tahun_akademik);

    $delete = mysqli_stmt_execute($stmt);

    !$delete
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'delete_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    $redirect_address = "penilaian_alternatif.php?go=penilaian_alternatif";
    $redirect_address .= "&id_kelas_filter={$id_kelas}";
    $redirect_address .= "&id_tahun_akademik_filter={$id_tahun_akademik}";

    echo "<meta http-equiv='refresh' content='0;{$redirect_address}'>";
?>