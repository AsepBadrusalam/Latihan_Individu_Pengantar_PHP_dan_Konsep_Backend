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
    <title>Kartu Hasil Studi</title>
    <link rel="stylesheet" href="src/style.css">
</head>
<body>
    <h2>Kartu Hasil Studi</h2>

    <table class="khs">
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Nilai Angka</th>
                <th>Nilai Huruf</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nilaiMatkul as $i => $mk): ?>
            <tr class="<?= $mk['status'] === 'MENGULANG' ? 'mengulang' : '' ?>">
                <td class="tengah"><?= $i + 1 ?></td>
                <td><?= e($mk['nama']) ?></td>
                <td class="tengah"><?= e($mk['sks']) ?></td>
                <td class="tengah"><?= e($mk['nilai']) ?></td>
                <td class="tengah"><?= e($mk['huruf']) ?></td>
                <td class="tengah"><?= e($mk['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Ringkasan IPS</h3>
    <table class="ringkasan">
        <tr><td>Total SKS</td><td>: <?= $ringkasan['totalSks'] ?></td></tr>
        <tr><td>Total Mutu (SKS x Bobot)</td><td>: <?= number_format($ringkasan['totalMutu'], 1) ?></td></tr>
        <tr><td>IPS</td><td>: <?= number_format($ringkasan['ips'], 2) ?></td></tr>
        <tr><td>Maks. SKS semester depan</td><td>: <?= $ringkasan['maksSks'] ?> SKS</td></tr>
    </table>
</body>
</html>
