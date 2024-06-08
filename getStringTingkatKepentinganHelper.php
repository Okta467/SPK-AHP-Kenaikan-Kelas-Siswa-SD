<?php
    /**
     * Get string (first/second) from first and second kepentingan, ex. '1/3'
     * 
     * @param int $firstKepentingan - first kepentingan. Allowed numbers are 1, 3, 5, 7, 9
     * @param int $secondKepentingan - second kepentingan. Allowed numbers are 1, 3, 5, 7, 9
     * @return array<$data - includes message and data (string)
     */
    function getStringTingkatKepentingan($firstKepentingan, $secondKepentingan) {
        $allowedTingkat = [1, 3, 5, 7, 9];

        if (!in_array($firstKepentingan, $allowedTingkat) || !in_array($secondKepentingan, $allowedTingkat)) {
            return [
                'message' => 'Nilai tingkat tidak diperbolehkan!',
                'data' => null
            ];
        }

        if ($firstKepentingan == $secondKepentingan) {
            return [
                'message' => 'success',
                'data' => 1
            ];
        }

        $data = [
            'message' => 'success',
            'data' => null
        ];

        if ($secondKepentingan > $firstKepentingan) {

            switch($secondKepentingan - $firstKepentingan) {
                case 2: $data['data'] = '1/3'; break;
                case 4: $data['data'] = '1/5'; break;
                case 6: $data['data'] = '1/7'; break;
                case 8: $data['data'] = '1/9'; break;
                default: $data['message'] = 'error'; break;
            }

        } else {

            switch($firstKepentingan - $secondKepentingan) {
                case 2: $data['data'] = '3/1'; break;
                case 4: $data['data'] = '5/1'; break;
                case 6: $data['data'] = '7/1'; break;
                case 8: $data['data'] = '9/1'; break;
                default: $data['message'] = 'error'; break;
            }

        }

        return $data;
    }
?>