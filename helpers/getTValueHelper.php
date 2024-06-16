<?php
    /**
     * Get Consistency Ratio (RIn) by n Criteria from Consistency Index (CI)
     * of AHP decision support system method
     * 
     * @param int $nCriteria total numbers of criteria
     * @param array $nilaiBobotKriteria Nilai Bobot Kriteria (Wj)
     * @param array $hasilPerkalianMatriks result of Normalisasi Matriks Perbandingan Berpasangan * Nilai Bobot Kriteria (Wj)
     * @return float $t t value
     */
    function getTValue($nCriteria, $nilaiBobotKriteria, $hasilPerkalianMatriks): float {
        $jmlNilaiBobotKriteria = count($nilaiBobotKriteria);
        $jmlHasilPerkalianMatriks = count($hasilPerkalianMatriks);
        $totalBobotDibagiHasilPerkalian = 0;

        if ($jmlNilaiBobotKriteria == 0 || $jmlHasilPerkalianMatriks == 0) {
            throw new Exception("Nilai Bobot Kriteria or Hasil Perkalian Matrix is empty!");   
        }

        if ($jmlNilaiBobotKriteria !== $jmlHasilPerkalianMatriks) {
            throw new Exception("Nilai Bobot Kriteria and Hasil Perkalian Matriks array rows is not the same!");
        }

        for ($i = 0; $i < $nCriteria; $i++) {
            $totalBobotDibagiHasilPerkalian += ($hasilPerkalianMatriks[$i] / $nilaiBobotKriteria[$i]);
        }

        $t = (1 / $nCriteria) * $totalBobotDibagiHasilPerkalian;

        return $t;
    }
?>