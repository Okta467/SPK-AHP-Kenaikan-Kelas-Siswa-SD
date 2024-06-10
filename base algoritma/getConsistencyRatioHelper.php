<?php
    /**
     * Get Consistency Ratio (RIn) by n Criteria from Consistency Index (CI)
     * of AHP decision support system method
     * 
     * @param int $nCriteria numbers of criteria
     */
    function getConsistencyRatio($nCriteria) {
        $allowedCriteria = [2, 3, 4, 5, 6, 7, 8, 9, 10];

        if (!in_array($nCriteria, $allowedCriteria)) {
            return array();
        }
        
        // n kriteria => RIn
        $consistencyIndex = [
            2 => 0,
            3 => 0.58,
            4 => 0.90,
            5 => 1.12,
            6 => 1.24,
            7 => 1.32,
            8 => 1.41,
            9 => 1.45,
            10 => 1.49,
        ];

        return $consistencyIndex[$nCriteria];
    }
?>