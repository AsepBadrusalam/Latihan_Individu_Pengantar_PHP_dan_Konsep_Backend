<?php
require __DIR__ . '/src/php/data.php';
require __DIR__ . '/src/php/nilai.php';

$nilaiMatkul = olahNilai($matkul);
$ringkasan   = ringkasanIps($nilaiMatkul);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Hasil Studi</title>
    <link rel="stylesheet" href="src/style.css">
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
            <table class="khs">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th>Mata Kuliah</th>
                        <th class="tengah">SKS</th>
                        <th class="tengah">Nilai Angka</th>
                        <th class="tengah">Nilai Huruf</th>
                        <th class="tengah">Bobot</th>
                        <th class="tengah">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nilaiMatkul as $i => $mk): ?>
                    <tr class="<?= $mk['status'] === 'MENGULANG' ? 'mengulang' : '' ?>">
                        <td class="col-no"><?= $i + 1 ?></td>
                        <td class="col-nama"><?= e($mk['nama']) ?></td>
                        <td class="tengah"><?= e($mk['sks']) ?></td>
                        <td class="tengah"><?= e($mk['nilai']) ?></td>
                        <td class="tengah"><?= e($mk['huruf']) ?></td>
                        <td class="tengah"><?= number_format($mk['bobot'], 1) ?></td>
                        <td class="tengah">
                            <span class="badge <?= $mk['status'] === 'MENGULANG' ? 'badge--danger' : 'badge--success' ?>">
                                <?= e($mk['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total</th>
                        <th class="tengah"><?= $ringkasan['totalSks'] ?></th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <section class="ringkasan" aria-label="Ringkasan IPS">
            <div class="ringkasan__item">
                <span class="ringkasan__label">Total SKS</span>
                <span class="ringkasan__value"><?= $ringkasan['totalSks'] ?></span>
            </div>
            <div class="ringkasan__item">
                <span class="ringkasan__label">Total Mutu</span>
                <span class="ringkasan__value"><?= number_format($ringkasan['totalMutu'], 2) ?></span>
            </div>
            <div class="ringkasan__item ringkasan__item--highlight">
                <span class="ringkasan__label">IPS</span>
                <span class="ringkasan__value"><?= number_format($ringkasan['ips'], 2) ?></span>
                <span class="ringkasan__note">
                    <?= number_format($ringkasan['totalMutu'], 2) ?> / <?= $ringkasan['totalSks'] ?> SKS
                </span>
            </div>
            <div class="ringkasan__item">
                <span class="ringkasan__label">Batas SKS Semester Depan</span>
                <span class="ringkasan__value"><?= $ringkasan['maksSks'] ?> <small>SKS</small></span>
                <span class="ringkasan__note">
                    <?= $ringkasan['ips'] >= IPS_MINIMAL_SKS_PENUH ? 'IPS &ge; 3.00' : 'IPS &lt; 3.00' ?>
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
