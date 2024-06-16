<?php
    /**
     * Get alternative rank (alternative name is ordered
     * based on array number (before ranking action))
     * 
     * @param null|array<mixed> $kodeAlternatif
     * @param null|array<int, float> $nilaiAkhir
     * @param null|array<string> $namaSiswa
     * @param null|array<string> $nisnSiswa
     * @param null|array<string> $jkSiswa
     * @param null|array<string> $namaKelas
     * @param null|array<string> $namaWaliKelas
     * @param null|array<string> $nipWaliKelas
     * @return array contains alternative kode, nilai_akhir, rank
     */
    function getRankingAlternatif(
        $kodeAlternatif = null,
        $nilaiAkhir = null,
        $namaSiswa = null,
        $nisnSiswa = null,
        $jkSiswa = null,
        $namaKelas = null,
        $namaWaliKelas = null,
        $nipWaliKelas = null,
    ) {
        $jmlKodeAlternatif = count($kodeAlternatif);
        $jmlNilaiAkhir = count($nilaiAkhir);
        
        if (!$kodeAlternatif || !$nilaiAkhir) {
            return [
                'message' => 'Error: one of parameter is null!',
                'data' => null
            ];
        }

        if ($jmlKodeAlternatif !== $jmlNilaiAkhir) {
            return [
                'message' => 'Error: both kodeAlternatif and nilaiAkhir count is not same!',
                'data' => null
            ];
        }

        $data['message'] = 'success';

        // Assign each parameter variables into new array $data
        for ($i = 0; $i < $jmlNilaiAkhir; $i++) {
            $data['data'][$i] = [
                'kode_alternatif' => $kodeAlternatif[$i],
                'nilai_akhir'     => $nilaiAkhir[$i],
                'nama_siswa'      => $namaSiswa[$i],
                'nisn_siswa'      => $nisnSiswa[$i],
                'jk_siswa'        => $jkSiswa[$i],
                'nama_kelas'      => $namaKelas[$i],
                'nama_wali_kelas' => $namaWaliKelas[$i],
                'nip_wali_kelas'  => $nipWaliKelas[$i]
            ];
        }

        // Sort array by key nilai_akhir by descending order
        usort($data['data'], fn($a, $b) => $b['nilai_akhir'] <=> $a['nilai_akhir']);
        
        // Set rank for each alternatives after sorted
        for ($i = 0; $i < $jmlNilaiAkhir; $i++) {
            $data['data'][$i]['rank'] = $i + 1;
        }

        return $data;
    }
?>