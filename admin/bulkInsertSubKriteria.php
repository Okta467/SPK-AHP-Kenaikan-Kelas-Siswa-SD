<?php
include '../config/connection.php';

$kriteria = ['Kehadiran', 'Harian', 'Tugas', 'UAS'];

$query = "INSERT INTO tbl_sub_kriteria (id_kriteria, kode_sub_kriteria, nama_sub_kriteria, bobot) VALUES";
$query .= '
        ';

for ($i = 1; $i <= 4; $i++) {
    for ($j = 1; $j <= 4; $j++) {
        if ($i === 4 && $j === 4) {
            $query .= "({$i}, 'K{$i}S{$j}', '{$kriteria[$i-1]} {$j}', {$j})";
            continue;
        }

        $query .= "({$i}, 'K{$i}S{$j}', '{$kriteria[$i-1]} {$j}', {$j})";
        $query .= ',
        ';
    }
}

$query_exec = mysqli_query($connection, $query) or die(mysqli_error($connection));

var_dump($query_exec);
?>