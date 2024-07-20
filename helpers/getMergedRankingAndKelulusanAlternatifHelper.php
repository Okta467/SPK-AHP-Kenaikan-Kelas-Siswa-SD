<?php

    /**
     * Get alternatif with rank and kelulusan merged
     * 
     * @param null|string $arrKey array key reference for merging (both $alternatifWithRankings and $alternatifWithKelulusans) must have this array key
     * @param null|array<mixed> $alternatifWithRankings data generated from helper `helpers/getRankingAlternatifHelper.php`
     * @param null|array<mixed> $alternatifWithKelulusans data generated from helper `helpers/getKelulusanSiswaHelper.php`
     * @return array contains message (success/error), data (alternatif data along with kelulusan and ranking)
     */
    function getMergedRankingAndKelulusanAlternatif($arrKey, $alternatifWithRankings = null, $alternatifWithKelulusans = null) {

        if (!$arrKey ||!$alternatifWithRankings || !$alternatifWithKelulusans) {
            return [
                'message' => 'Error: one of parameter is null!',
                'data' => null
            ];
        }

        $data['message'] = 'success';

        $alternatifWithKelulusansMapped = array_column($alternatifWithKelulusans, null, $arrKey);

        $alternatifRankingAndKelulusan = array_map(function ($item) use ($alternatifWithKelulusansMapped, $arrKey) {
            $kode_alternatif = $item[$arrKey];

            if (isset($alternatifWithKelulusansMapped[$kode_alternatif])) {
                $item['keterangan_kelulusan'] = $alternatifWithKelulusansMapped[$kode_alternatif]['keterangan_kelulusan'];
            }

            return $item;
        }, $alternatifWithRankings);

        $data['data'] = $alternatifRankingAndKelulusan;

        return $data;
    }

?>