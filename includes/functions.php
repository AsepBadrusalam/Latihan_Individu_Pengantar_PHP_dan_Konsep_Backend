<?php

declare(strict_types=1);

/**
 * Mengubah nilai angka (0-100) menjadi huruf mutu beserta bobotnya.
 *
 * Rentang nilai:
 *   80 - 100 = A (4.0)
 *   70 - 79  = B (3.0)
 *   60 - 69  = C (2.0)
 *   50 - 59  = D (1.0)
 *   0  - 49  = E (0.0)
 *
 * @return array{huruf: string, bobot: float}
 */
function hitungBobot(int|float $nilai): array
{
    if ($nilai >= 80) {
        return ['huruf' => 'A', 'bobot' => 4.0];
    }

    if ($nilai >= 70) {
        return ['huruf' => 'B', 'bobot' => 3.0];
    }

    if ($nilai >= 60) {
        return ['huruf' => 'C', 'bobot' => 2.0];
    }

    if ($nilai >= 50) {
        return ['huruf' => 'D', 'bobot' => 1.0];
    }

    return ['huruf' => 'E', 'bobot' => 0.0];
}

/**
 * Menentukan status kelulusan berdasarkan bobot huruf mutu.
 * LULUS jika bobot >= 2.0 (A, B, C), MENGULANG jika di bawahnya (D, E).
 */
function tentukanStatus(float $bobot): string
{
    return $bobot >= 2.0 ? 'LULUS' : 'MENGULANG';
}

/**
 * Menghitung ringkasan hasil studi: total SKS, total mutu, IPS, dan batas SKS.
 *
 * IPS = total (bobot x SKS) / total SKS.
 *
 * @param array<int, array{nama: string, sks: int, nilai: int|float}> $matkul
 * @return array{total_sks: int, total_mutu: float, ips: float, batas_sks: int}
 */
function hitungRingkasan(array $matkul): array
{
    $totalSks = 0;
    $totalMutu = 0.0;

    foreach ($matkul as $mk) {
        $bobot = hitungBobot((float) $mk['nilai'])['bobot'];
        $totalSks += (int) $mk['sks'];
        $totalMutu += $bobot * (int) $mk['sks'];
    }

    $ips = $totalSks > 0 ? $totalMutu / $totalSks : 0.0;

    // IPS >= 3.00 boleh mengambil 24 SKS, selain itu maksimal 20 SKS.
    $batasSks = $ips >= 3.00 ? 24 : 20;

    return [
        'total_sks' => $totalSks,
        'total_mutu' => $totalMutu,
        'ips' => $ips,
        'batas_sks' => $batasSks,
    ];
}

/** Membungkus htmlspecialchars agar aman dipakai berulang. */
function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
