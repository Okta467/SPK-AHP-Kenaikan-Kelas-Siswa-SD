<?php
    /**
     * Get hasil nilai dari normalisasi matriks perbandingan berpasangan * nilai bobot kriteria (Wj)
     * - Both array rows must be equal
     * 
     * @param array $normalisasiPerbandingan 2D array of normalisasi matriks perbandingan berpasangan
     * @param array $nilaiBobotKriteria 1D array of nilai bobot kriteria (Wj)
     * @return array<message,data message success/error, data is 1D array that contains the matrix multiplication results
     */
    function getNormalisasiDikaliBobotKriteria($normalisasiMatriksPerbandingan, $nilaiBobotKriteria): array {
        $jmlNormalisasiMatriksPerbandingan = count($normalisasiMatriksPerbandingan);
        $jmlNilaiBobotKriteria = count($nilaiBobotKriteria);
        $data = [
            'message' => 'success',
            'data'=> null
        ];
        
        if ($jmlNormalisasiMatriksPerbandingan === 0 || $jmlNilaiBobotKriteria == 0) {
            return [
                'message' => 'Normalisasi or Bobot Kriteria is empty!',
                'data' => null
            ];
        }

        for ($i = 0; $i < $jmlNormalisasiMatriksPerbandingan; $i++) {

            $data['data'][$i] = 0;
            
            for ($j = 0; $j < $jmlNormalisasiMatriksPerbandingan; $j++) {
                $data['data'][$i] += $normalisasiMatriksPerbandingan[$i][$j] * $nilaiBobotKriteria[$j];
            }
        }
        
        return $data;
    }
?>