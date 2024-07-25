<?php
    /**
     * Get kelulusan siswa
     * - if (siswa[kriteriaNilai] < 70) more than 4 times,
     *   then 'Tidak Lulus', else 'Lulus
     * 
     * @param null|array<mixed> $siswa contains nilai per category (kriteriaNilai), e.g. 'kehadiran' => 89, 'uas' => 90
     * @param null|array<string> $kriteriaNilai e.g. ['kehadiran', 'uas', ...]
     * @param int $kkm range from 0-100 `Kriteria Ketuntasan Minimal` or minimum criteria score need to able to `Lulus`,
     * @param null|int
     * $jmlMaksDiBawahKKM maximum count for criteria score less than $kkm, if more than maximum, then `keterangan_kelulusan` is `Tidak Lulus`.
     * If not defined, this parameter use count($kriteriaNilai) instead
     * @return array contains message (success/error), data (kode alternatif, keterangan kelulusan)
     */
    function getKelulusanSiswa($siswa = null, $kriteriaNilai = null, $jmlMaksDiBawahKKM = null, $kkm = 70) {
        $jmlSiswa = count($siswa);
        $jmlKriteriaNilai = count($kriteriaNilai);
        $jmlMaksDiBawahKKM = $jmlMaksDiBawahKKM ?? $jmlKriteriaNilai;
        
        if (!$siswa || !$kriteriaNilai) {
            return [
                'message' => 'Error: one of parameter is null!',
                'data' => null
            ];
        }

        $data['message'] = 'success';

        // Assign each parameter variables into new array $data
        for ($i = 0; $i < $jmlSiswa; $i++) {
            $jmlDiBawahKKM = 0;

            $data['data'][$i] = [
                'kode_alternatif'  => $siswa[$i]['kode_alternatif'],
                'keterangan_kelulusan' => 'Lulus'
            ];
            
            // Count how many siswa score that is below KKM
            for ($j = 0; $j < $jmlKriteriaNilai; $j++) {
                $currentNilai = $siswa[$i][$kriteriaNilai[$j]];                

                if ($currentNilai < $kkm) {
                    $jmlDiBawahKKM++;
                }
            }

            if ($jmlDiBawahKKM >= $jmlMaksDiBawahKKM) {
                $data['data'][$i]['keterangan_kelulusan'] = 'Tidak Lulus';
            }
        }

        return $data;
    }
?>