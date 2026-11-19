<?php
/**
 * Variabel dari Dashboard::index():
 * @var string $tanggal
 * @var array  $stat
 * @var array  $kondisi        ['Baik' => int, 'Rusak Ringan' => int, 'Rusak Berat' => int]
 * @var array  $perKategori    [['nama' => string, 'total' => int], ...]
 * @var array  $peminjamanBaru
 * @var array  $barangTerbaru
 */

$angka = static fn (int $n): string => number_format($n, 0, ',', '.');
$tgl   = static fn (string $d): string => date('d/m/Y', strtotime($d));
$hariIni = date('Y-m-d');

// Tampilan tiap kondisi barang: ikon + label selalu menyertai warna (warna saja tidak cukup).
$metaKondisi = [
    'Baik'         => ['ikon' => 'mdi-check-circle-outline', 'warna' => '#0ca30c', 'badge' => 'bg-success'],
    'Rusak Ringan' => ['ikon' => 'mdi-alert-outline',        'warna' => '#fab219', 'badge' => 'bg-warning text-dark'],
    'Rusak Berat'  => ['ikon' => 'mdi-close-circle-outline', 'warna' => '#d03b3b', 'badge' => 'bg-danger'],
];

$totalUnit   = array_sum($kondisi);
$maksKategori = max(array_column($perKategori, 'total') ?: [0]);
?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    /* Batang tipis untuk daftar meter & peringkat. */
    .viz-track { height: 8px; background: #eef1f6; border-radius: 999px; overflow: hidden; }
    .viz-fill  { height: 100%; border-radius: 999px; }
    .viz-rank-track { height: 8px; }
    .viz-rank-fill  { height: 100%; background: #525ce5; border-radius: 0 4px 4px 0; min-width: 0; }
    .viz-row + .viz-row { margin-top: 1.25rem; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Judul halaman -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Sambutan -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-sm-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-1">Selamat datang, <?= esc(session()->get('nama_pengguna')) ?></h5>
                    <p class="text-muted mb-0">Berikut ringkasan inventaris sekolah hari ini.</p>
                </div>
                <div class="mt-3 mt-sm-0 text-sm-end">
                    <span class="text-muted"><i class="mdi mdi-calendar-today me-1"></i><?= esc($tanggal) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kartu ringkasan -->
<div class="row">

    <div class="col-md-6 col-xl-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium mb-2">Jenis Barang</p>
                        <h4 class="mb-0"><?= $angka($stat['barang_jenis']) ?></h4>
                        <p class="text-muted font-size-13 mb-0 mt-1"><?= $angka($stat['barang_unit']) ?> unit seluruhnya</p>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title"><i class="mdi mdi-package-variant font-size-24"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium mb-2">Kategori Barang</p>
                        <h4 class="mb-0"><?= $angka($stat['kategori']) ?></h4>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title"><i class="mdi mdi-tag-multiple font-size-24"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium mb-2">Ruangan</p>
                        <h4 class="mb-0"><?= $angka($stat['ruangan']) ?></h4>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title"><i class="mdi mdi-door font-size-24"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium mb-2">Pengguna</p>
                        <h4 class="mb-0"><?= $angka($stat['pengguna']) ?></h4>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title"><i class="mdi mdi-account-group font-size-24"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium mb-2">Sedang Dipinjam</p>
                        <h4 class="mb-0"><?= $angka($stat['dipinjam_transaksi']) ?></h4>
                        <p class="text-muted font-size-13 mb-0 mt-1"><?= $angka($stat['dipinjam_unit']) ?> unit di luar</p>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title"><i class="mdi mdi-swap-horizontal font-size-24"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium mb-2">Terlambat Kembali</p>
                        <h4 class="mb-0"><?= $angka($stat['terlambat']) ?></h4>
                        <?php if ($stat['terlambat'] > 0): ?>
                            <p class="text-danger font-size-13 mb-0 mt-1">
                                <i class="mdi mdi-alert-outline me-1"></i>Perlu ditindaklanjuti
                            </p>
                        <?php else: ?>
                            <p class="text-muted font-size-13 mb-0 mt-1">
                                <i class="mdi mdi-check-circle-outline me-1"></i>Tidak ada keterlambatan
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle <?= $stat['terlambat'] > 0 ? 'bg-danger' : 'bg-primary' ?>">
                            <span class="avatar-title"><i class="mdi mdi-clock-alert font-size-24"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Kondisi barang & stok per kategori -->
<div class="row">

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-1">Kondisi Barang</h4>
                <p class="text-muted font-size-13 mb-4">Jumlah unit menurut kondisinya (total <?= $angka($totalUnit) ?> unit)</p>

                <?php foreach ($metaKondisi as $nama => $meta): ?>
                    <?php
                    $jumlah = $kondisi[$nama] ?? 0;
                    $persen = $totalUnit > 0 ? (int) round($jumlah / $totalUnit * 100) : 0;
                    $lebar  = $jumlah > 0 ? max($persen, 2) : 0;
                    $ket    = $nama . ': ' . $angka($jumlah) . ' unit (' . $persen . '%)';
                    ?>
                    <div class="viz-row" title="<?= esc($ket) ?>">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>
                                <i class="mdi <?= $meta['ikon'] ?> me-1" style="color: <?= $meta['warna'] ?>;"></i><?= esc($nama) ?>
                            </span>
                            <span><strong><?= $angka($jumlah) ?></strong> unit <span class="text-muted">· <?= $persen ?>%</span></span>
                        </div>
                        <div class="viz-track" role="img" aria-label="<?= esc($ket) ?>">
                            <div class="viz-fill" style="width: <?= $lebar ?>%; background: <?= $meta['warna'] ?>;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($totalUnit === 0): ?>
                    <p class="text-muted mb-0 mt-3">Belum ada data barang.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-1">Stok per Kategori</h4>
                <p class="text-muted font-size-13 mb-4">Total unit barang di tiap kategori, dari yang terbanyak</p>

                <?php foreach ($perKategori as $kat): ?>
                    <?php
                    $lebar = $maksKategori > 0 ? round($kat['total'] / $maksKategori * 100) : 0;
                    $ket   = $kat['nama'] . ': ' . $angka($kat['total']) . ' unit';
                    ?>
                    <div class="viz-row" title="<?= esc($ket) ?>">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span><?= esc($kat['nama']) ?></span>
                            <span><strong><?= $angka($kat['total']) ?></strong> unit</span>
                        </div>
                        <div class="viz-track viz-rank-track" role="img" aria-label="<?= esc($ket) ?>">
                            <div class="viz-rank-fill" style="width: <?= $lebar ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($perKategori === []): ?>
                    <p class="text-muted mb-0">Belum ada kategori.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- Tabel -->
<div class="row">

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Peminjaman Terbaru</h4>
                <div class="table-responsive">
                    <table class="table table-centered align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Peminjam</th>
                                <th>Barang</th>
                                <th>Pinjam</th>
                                <th>Rencana Kembali</th>
                                <th class="text-end">Jml</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($peminjamanBaru as $p): ?>
                                <?php $terlambat = $p['status'] === 'Dipinjam' && $p['tanggal_rencana_kembali'] < $hariIni; ?>
                                <tr>
                                    <td><?= esc($p['nama_pengguna']) ?></td>
                                    <td><?= esc($p['nama_barang']) ?></td>
                                    <td><?= $tgl($p['tanggal_pinjam']) ?></td>
                                    <td><?= $tgl($p['tanggal_rencana_kembali']) ?></td>
                                    <td class="text-end"><?= $angka((int) $p['jumlah']) ?></td>
                                    <td>
                                        <?php if ($p['status'] === 'Kembali'): ?>
                                            <span class="badge bg-success"><i class="mdi mdi-check-circle-outline me-1"></i>Kembali</span>
                                        <?php elseif ($terlambat): ?>
                                            <span class="badge bg-danger"><i class="mdi mdi-clock-alert me-1"></i>Terlambat</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark"><i class="mdi mdi-swap-horizontal me-1"></i>Dipinjam</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if ($peminjamanBaru === []): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data peminjaman.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Barang Terbaru</h4>
                <div class="table-responsive">
                    <table class="table table-centered align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Ruangan</th>
                                <th class="text-end">Jml</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barangTerbaru as $b): ?>
                                <?php $meta = $metaKondisi[$b['kondisi']] ?? $metaKondisi['Baik']; ?>
                                <tr>
                                    <td><?= esc($b['kode_barang']) ?></td>
                                    <td><?= esc($b['nama_barang']) ?></td>
                                    <td><?= esc($b['nama_kategori']) ?></td>
                                    <td><?= esc($b['nama_ruangan']) ?></td>
                                    <td class="text-end"><?= $angka((int) $b['jumlah']) ?></td>
                                    <td>
                                        <span class="badge <?= $meta['badge'] ?>">
                                            <i class="mdi <?= $meta['ikon'] ?> me-1"></i><?= esc($b['kondisi']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if ($barangTerbaru === []): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data barang.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>