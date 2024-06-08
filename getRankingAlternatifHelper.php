<?php
    /**
     * Get alternative rank (alternative name is ordered
     * based on array number (before ranking action))
     * 
     * @param null|array<mixed> $kodeAlternatif
     * @param null|array<int, float> $nilaiAkhir
     * @return array contains alternative name, nilai_akhir, rank
     */
    function getRankingAlternatif($kodeAlternatif = null, $nilaiAkhir = null) {
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
                'nilai_akhir' => $nilaiAkhir[$i]
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