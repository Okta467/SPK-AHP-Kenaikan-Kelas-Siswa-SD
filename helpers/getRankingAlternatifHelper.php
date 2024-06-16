<?php
    /**
     * Get alternative rank (alternative name is ordered
     * based on array number (before ranking action))
     * 
     * @param null|array<mixed> $kodeAlternatif
     * @param null|array<int, float> $nilaiAkhir
     * @param null|array<string> $namaSiswa (optional)
     * @param null|array<string> $nisnSiswa (optional)
     * @param null|array<string> $jkSiswa (optional)
     * @param null|array<string> $namaKelas (optional)
     * @param null|array<string> $namaWaliKelas (optional)
     * @param null|array<string> $nipWaliKelas (optional)
     * @return array contains alternative kode, nilai_akhir, rank
     */
    function getRankingAlternatif(
        $kodeAlternatif,
        $nilaiAkhir,
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
                'nama_siswa'      => $namaSiswa[$i] ?? null,
                'nisn_siswa'      => $nisnSiswa[$i] ?? null,
                'jk_siswa'        => $jkSiswa[$i] ?? null,
                'nama_kelas'      => $namaKelas[$i] ?? null,
                'nama_wali_kelas' => $namaWaliKelas[$i] ?? null,
                'nip_wali_kelas'  => $nipWaliKelas[$i] ?? null
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