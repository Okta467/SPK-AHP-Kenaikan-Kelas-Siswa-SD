<?php
    /**
     * All data structure presented for hasil perhitungan is based on file:
     * 'base algoritma/index (base algoritma).php'
     */
    $query_alternatif = mysqli_query($connection, 
      "SELECT
        a.nilai_siswa,
        b.kode_alternatif,
        c.nisn, c.nama_siswa, c.jk,
        d.nama_kelas, 
        e.nama_kriteria,
        g.range_nilai,
        h.nip, h.nama_guru,
        i.dari_tahun, i.sampai_tahun
      FROM tbl_penilaian_alternatif AS a
      LEFT JOIN tbl_alternatif AS b
        ON b.id = a.id_alternatif
      LEFT JOIN tbl_siswa AS c
        ON c.id = b.id_siswa
      LEFT JOIN tbl_kelas AS d
        ON d.id = c.id_kelas
      LEFT JOIN tbl_kriteria AS e
        ON e.id = a.id_kriteria
      LEFT JOIN tbl_sub_kriteria AS f
        ON f.id = a.id_sub_kriteria
      LEFT JOIN tbl_range_nilai AS g
        ON g.id = f.id_range_nilai
      LEFT JOIN tbl_guru AS h
        ON h.id = d.id_wali_kelas
      LEFT JOIN tbl_tahun_akademik AS i
        ON i.id = a.id_tahun_akademik
      WHERE
        c.id_kelas = {$id_kelas_filter}
        AND a.id_tahun_akademik = {$id_tahun_akademik_filter}
      ORDER BY b.kode_alternatif ASC");

    $alternatifs = mysqli_fetch_all($query_alternatif, MYSQLI_ASSOC);

    /**
     * Data alternatif (with range nilai)
     * 
     * - Format alternatif data to ['kode_alternatif' => x, 'kriteria_1' => y, 'kriteria_2' => z', 'kriteria_n' => n]
     * - nama kriteria value is range nilai (1,2,3,4,5,...,n)
     */
    $result = [];
    foreach ($alternatifs as $alternatif) {
      $kode_alternatif = $alternatif['kode_alternatif'];
      $nama_kriteria   = $alternatif['nama_kriteria'];
      $range_nilai     = $alternatif['range_nilai'];

      if (!isset($result[$kode_alternatif])) {
        $result[$kode_alternatif] = ['kode_alternatif' => $kode_alternatif];
      }

      $result[$kode_alternatif][$nama_kriteria] = $range_nilai;
      
      // Siswa
      $result[$kode_alternatif]['nama_siswa'] = $alternatif['nama_siswa'];
      $result[$kode_alternatif]['nisn']       = $alternatif['nisn'];
      $result[$kode_alternatif]['jk']         = $alternatif['jk'];

      // Guru atau Wali Kelas
      $result[$kode_alternatif]['nama_kelas'] = $alternatif['nama_kelas'];
      $result[$kode_alternatif]['nama_guru']  = $alternatif['nama_guru'];
      $result[$kode_alternatif]['nip']        = $alternatif['nip'];

      // Tahun akademik
      $result[$kode_alternatif]['dari_tahun']   = $alternatif['dari_tahun'];
      $result[$kode_alternatif]['sampai_tahun'] = $alternatif['sampai_tahun'];
    }

    $alternatif = array_values($result);

    /**
     * Data alternatif (with nilai siswa)
     * 
     * - Format alternatif data to ['kode_alternatif' => x, 'kriteria_1' => y, 'kriteria_2' => z', 'kriteria_n' => n]
     * - nama kriteria value is nilai siswa (60, 70, 80, ...)
     */
    $result2 = [];
    foreach ($alternatifs as $alternatif_nilai_siswa) {
      $kode_alternatif = $alternatif_nilai_siswa['kode_alternatif'];
      $nama_kriteria   = $alternatif_nilai_siswa['nama_kriteria'];
      $nilai_siswa     = $alternatif_nilai_siswa['nilai_siswa'];

      if (!isset($result2[$kode_alternatif])) {
        $result2[$kode_alternatif] = ['kode_alternatif' => $kode_alternatif];
      }

      $result2[$kode_alternatif][$nama_kriteria] = $nilai_siswa;
    }

    $alternatif_nilai_siswa = array_values($result2);

    /**
     * Get data kriteria and its tingkat kepentingan
     */
    $query_existing_kriteria_by_tahun_akademik = mysqli_query($connection, 
      "SELECT
        b.id AS id_kriteria, b.kode_kriteria, b.nama_kriteria,
        c.id AS id_tingkat_kepentingan, c.nilai_kepentingan
      FROM tbl_penilaian_alternatif AS a
      INNER JOIN tbl_kriteria AS b
        ON b.id = a.id_kriteria
      INNER JOIN tbl_tingkat_kepentingan AS c
        ON c.id = b.id_tingkat_kepentingan
      WHERE a.id_tahun_akademik = {$id_tahun_akademik_filter}
      GROUP BY a.id_kriteria");
      
    $query_all_kriteria = mysqli_query($connection, "SELECT *, id AS id_kriteria FROM tbl_kriteria WHERE status_aktif='1'");

    $query_kriteria = !$query_existing_kriteria_by_tahun_akademik->num_rows
      ? $query_all_kriteria
      : $query_existing_kriteria_by_tahun_akademik;

    $kriteria = mysqli_fetch_all($query_kriteria, MYSQLI_ASSOC);

    $kriteria = array_map(fn($arr) => [
      'nama_kriteria'     => $arr['nama_kriteria'], 
      'nilai_kepentingan' => $arr['nilai_kepentingan']
    ], $kriteria);


    $jmlAlternatif = count($alternatif);

    $jmlKriteria = count($kriteria);
?>