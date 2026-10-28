<?php

declare(strict_types=1);

require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/functions.php';

$ringkasan = hitungRingkasan($matkul);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Hasil Studi - Latihan Individu PHP</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <main class="card">
        <header class="card__header">
            <p class="eyebrow">Latihan Individu &middot; Pengantar PHP &amp; Konsep Backend</p>
            <h1>Kartu Hasil Studi</h1>
            <p class="subtitle">
                Perhitungan nilai huruf, status kelulusan, dan IPS menggunakan array multidimensi.
            </p>
        </header>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th>Mata Kuliah</th>
                        <th class="col-center">SKS</th>
                        <th class="col-center">Nilai Angka</th>
                        <th class="col-center">Nilai Huruf</th>
                        <th class="col-center">Bobot</th>
                        <th class="col-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matkul as $index => $mk) : ?>
                        <?php
                        $hasil = hitungBobot((float) $mk['nilai']);
                        $status = tentukanStatus($hasil['bobot']);
                        $barisMengulang = $status === 'MENGULANG';
                        ?>
                        <tr class="<?= $barisMengulang ? 'row-mengulang' : '' ?>">
                            <td class="col-no"><?= $index + 1 ?></td>
                            <td class="col-nama"><?= e($mk['nama']) ?></td>
                            <td class="col-center"><?= e($mk['sks']) ?></td>
                            <td class="col-center"><?= e($mk['nilai']) ?></td>
                            <td class="col-center"><?= e($hasil['huruf']) ?></td>
                            <td class="col-center"><?= number_format($hasil['bobot'], 1) ?></td>
                            <td class="col-center">
                                <span class="badge <?= $barisMengulang ? 'badge--danger' : 'badge--success' ?>">
                                    <?= e($status) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total</th>
                        <th class="col-center"><?= e($ringkasan['total_sks']) ?></th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <section class="ringkasan" aria-label="Ringkasan IPS">
            <div class="ringkasan__item">
                <span class="ringkasan__label">Total SKS</span>
                <span class="ringkasan__value"><?= e($ringkasan['total_sks']) ?></span>
            </div>
            <div class="ringkasan__item">
                <span class="ringkasan__label">Total Mutu</span>
                <span class="ringkasan__value"><?= number_format($ringkasan['total_mutu'], 2) ?></span>
            </div>
            <div class="ringkasan__item ringkasan__item--highlight">
                <span class="ringkasan__label">IPS</span>
                <span class="ringkasan__value"><?= number_format($ringkasan['ips'], 2) ?></span>
                <span class="ringkasan__note">
                    <?= number_format($ringkasan['total_mutu'], 2) ?> / <?= e($ringkasan['total_sks']) ?> SKS
                </span>
            </div>
            <div class="ringkasan__item">
                <span class="ringkasan__label">Batas SKS Semester Depan</span>
                <span class="ringkasan__value"><?= e($ringkasan['batas_sks']) ?> <small>SKS</small></span>
                <span class="ringkasan__note">
                    <?= $ringkasan['ips'] >= 3.00 ? 'IPS &ge; 3.00' : 'IPS &lt; 3.00' ?>
                </span>
            </div>
        </section>

        <footer class="card__footer">
            <p>
                <strong>Keterangan:</strong> LULUS jika bobot &ge; 2.0 (A, B, C);
                MENGULANG jika bobot di bawahnya (D, E).
            </p>
            <p>IPS &ge; 3.00 &rarr; maksimal 24 SKS &middot; IPS &lt; 3.00 &rarr; maksimal 20 SKS.</p>
        </footer>
    </main>
</body>

</html>
