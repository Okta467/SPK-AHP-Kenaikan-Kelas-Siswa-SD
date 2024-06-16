<?php
    /**
     * Get integer number for each tingkat kepentingan (first and second kepentingan)
     * 
     * @param int $firstKepentingan - first kepentingan. Allowed numbers are 1, 3, 5, 7, 9
     * @param int $secondKepentingan - second kepentingan. Allowed numbers are 1, 3, 5, 7, 9
     * @return array<$data - includes message and data (first, second)
     */
    function getIntTingkatKepentingan($firstKepentingan, $secondKepentingan): array {
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
                'data' => [
                    'first' => 1,
                    'second' => 1
                ]
            ];
        }

        $data = [
            'message' => 'success',
            'data' => [
                'first' => null,
                'second' => null
            ]
        ];

        if ($secondKepentingan > $firstKepentingan) {

            switch($secondKepentingan - $firstKepentingan) {
                case 2:
                    $data['data']['first'] = 1;
                    $data['data']['second'] = 3;
                    break;

                case 4:
                    $data['data']['first'] = 1;
                    $data['data']['second'] = 5;
                    break;

                case 6:
                    $data['data']['first'] = 1;
                    $data['data']['second'] = 7;
                    break;

                case 8:
                    $data['data']['first'] = 1;
                    $data['data']['second'] = 9;
                    break;

                default:
                    $data['message'] = 'error';
                    break;

            }

        } else {

            switch($firstKepentingan - $secondKepentingan) {
                case 2:
                    $data['data']['first'] = 3;
                    $data['data']['second'] = 1;
                    break;

                case 4:
                    $data['data']['first'] = 5;
                    $data['data']['second'] = 1;
                    break;

                case 6:
                    $data['data']['first'] = 7;
                    $data['data']['second'] = 1;
                    break;

                case 8:
                    $data['data']['first'] = 9;
                    $data['data']['second'] = 1;
                    break;

                default:
                    $data['message'] = 'error';
                    break;

            }

        }

        return $data;
    }
?>