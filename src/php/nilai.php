<?php

const BOBOT_MINIMAL_LULUS = 2.0;
const IPS_MINIMAL_SKS_PENUH = 3.00;

function hitungBobot(float $nilai): array
{
    $skala = [
        80 => ['huruf' => 'A', 'bobot' => 4.0],
        70 => ['huruf' => 'B', 'bobot' => 3.0],
        60 => ['huruf' => 'C', 'bobot' => 2.0],
        50 => ['huruf' => 'D', 'bobot' => 1.0],
    ];

    foreach ($skala as $batasBawah => $hasil) {
        if ($nilai >= $batasBawah) {
            return $hasil;
        }
    }

    return ['huruf' => 'E', 'bobot' => 0.0];
}

function statusKelulusan(float $bobot): string
{
    return $bobot >= BOBOT_MINIMAL_LULUS ? 'LULUS' : 'MENGULANG';
}

function olahNilai(array $matkul): array
{
    return array_map(function (array $mk): array {
        $hasil = hitungBobot($mk['nilai']);

        return $mk + $hasil + ['status' => statusKelulusan($hasil['bobot'])];
    }, $matkul);
}

function ringkasanIps(array $nilaiMatkul): array
{
    $totalSks  = array_sum(array_column($nilaiMatkul, 'sks'));
    $totalMutu = array_sum(array_map(
        fn(array $mk): float => $mk['sks'] * $mk['bobot'],
        $nilaiMatkul
    ));
    $ips = $totalSks > 0 ? $totalMutu / $totalSks : 0.0;

    return [
        'totalSks'  => $totalSks,
        'totalMutu' => $totalMutu,
        'ips'       => $ips,
        'maksSks'   => $ips >= IPS_MINIMAL_SKS_PENUH ? 24 : 20,
    ];
}

function e(string|int|float $teks): string
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}
