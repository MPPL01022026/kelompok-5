<!-- Filter and Action Bar -->
<div class="card mb-3">
    <div class="card-body">
        <form action="<?= base_url('laporan') ?>" method="GET" class="d-flex align-center justify-between" style="flex-wrap: wrap; gap: 16px;">
            <div class="d-flex align-center gap-2" style="flex-wrap: wrap;">
                <div class="d-flex align-center gap-1">
                    <label class="fs-sm text-muted">Periode:</label>
                    <input type="date" name="start" class="form-control" value="<?= htmlspecialchars($start) ?>">
                </div>
                <div class="d-flex align-center gap-1">
                    <label class="fs-sm text-muted">s/d</label>
                    <input type="date" name="end" class="form-control" value="<?= htmlspecialchars($end) ?>">
                </div>
                <button type="submit" class="btn btn-primary">🔍 Filter Laporan</button>
            </div>
            <div>
                <a href="<?= base_url('laporan/cetak?start=' . $start . '&end=' . $end) ?>" target="_blank" class="btn btn-outline" style="border-color: var(--primary); color: var(--primary);">
                    🖨️ Cetak / Unduh Laporan
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Laporan KPI Summary -->
<div class="stats-grid mb-3">
    <div class="stat-card primary">
        <div class="stat-icon">💰</div>
        <div class="stat-value">Rp <?= number_format($total_nilai_stok, 0, ',', '.') ?></div>
        <div class="stat-label">Total Estimasi Nilai Stok Fisik</div>
    </div>
    <div class="stat-card success">
        <div class="stat-icon">💳</div>
        <div class="stat-value">Rp <?= number_format($total_pembelian, 0, ',', '.') ?></div>
        <div class="stat-label">Total Pembelian Bahan (Periode)</div>
    </div>
    <div class="stat-card info">
        <div class="stat-icon">📥</div>
        <div class="stat-value"><?= count($stok_masuk) ?> Transaksi</div>
        <div class="stat-label">Penerimaan Stok Masuk</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-icon">📤</div>
        <div class="stat-value"><?= count($stok_keluar) ?> Transaksi</div>
        <div class="stat-label">Pengeluaran Stok Pemakaian</div>
    </div>
</div>

<!-- Section 1: Ringkasan Nilai Stok Saat Ini -->
<div class="card mb-3">
    <div class="card-header">
        <div>
            <h3>📦 Nilai & Kondisi Persediaan Bahan Terkini</h3>
            <p class="fs-sm text-muted" style="margin-top: 4px;">
                Daftar ketersediaan fisik seluruh bahan makanan beserta valuasi aset
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Bahan</th>
                        <th>Kategori</th>
                        <th>Stok Saat Ini</th>
                        <th>Harga Satuan</th>
                        <th>Total Nilai Aset</th>
                        <th>Batas Min</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    if (!empty($bahan)): 
                        foreach ($bahan as $b): 
                            $subtotal = $b->stok_saat_ini * $b->harga_satuan;
                            $grand_total += $subtotal;
                            $is_empty = ($b->stok_saat_ini <= 0);
                            $is_low = (!$is_empty && $b->stok_saat_ini <= $b->batas_minimum);
                    ?>
                        <tr>
                            <td><code><?= htmlspecialchars($b->kode_bahan) ?></code></td>
                            <td><strong><?= htmlspecialchars($b->nama_bahan) ?></strong></td>
                            <td><?= htmlspecialchars($b->nama_kategori ?? '-') ?></td>
                            <td><?= rtrim(rtrim(number_format($b->stok_saat_ini, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($b->satuan) ?></td>
                            <td>Rp <?= number_format($b->harga_satuan, 0, ',', '.') ?></td>
                            <td class="fw-bold">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                            <td><?= rtrim(rtrim(number_format($b->batas_minimum, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($b->satuan) ?></td>
                            <td>
                                <?php if ($is_empty): ?>
                                    <span class="badge badge-danger">Habis</span>
                                <?php elseif ($is_low): ?>
                                    <span class="badge badge-warning">Menipis</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Aman</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                        <tr style="background: rgba(245, 158, 11, 0.05); font-weight: bold;">
                            <td colspan="5" style="text-align: right;">Total Nilai Persediaan:</td>
                            <td colspan="3" class="text-primary" style="font-size: 15px;">
                                Rp <?= number_format($grand_total, 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data bahan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Section 2: Rekapitulasi Mutasi Stok Masuk & Keluar Pada Periode -->
<div class="row-2-col">
    <!-- Stok Masuk -->
    <div class="card">
        <div class="card-header">
            <h3>📥 Rekap Stok Masuk (<?= count($stok_masuk) ?>)</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Bahan</th>
                            <th>Jumlah</th>
                            <th>Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($stok_masuk)): ?>
                            <?php foreach ($stok_masuk as $sm): ?>
                                <tr>
                                    <td><?= date('d/m/y', strtotime($sm->tanggal)) ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($sm->nama_bahan) ?></strong>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">
                                            +<?= rtrim(rtrim(number_format($sm->jumlah, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($sm->satuan) ?>
                                        </span>
                                    </td>
                                    <td><?= $sm->harga_beli > 0 ? 'Rp ' . number_format($sm->harga_beli, 0, ',', '.') : '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted" style="padding: 30px;">
                                    Tidak ada stok masuk pada periode ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Stok Keluar -->
    <div class="card">
        <div class="card-header">
            <h3>📤 Rekap Stok Keluar (<?= count($stok_keluar) ?>)</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Bahan</th>
                            <th>Jumlah</th>
                            <th>Keperluan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($stok_keluar)): ?>
                            <?php foreach ($stok_keluar as $sk): ?>
                                <tr>
                                    <td><?= date('d/m/y', strtotime($sk->tanggal)) ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($sk->nama_bahan) ?></strong>
                                    </td>
                                    <td>
                                        <span class="text-danger fw-bold">
                                            -<?= rtrim(rtrim(number_format($sk->jumlah, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($sk->satuan) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fs-sm"><?= htmlspecialchars($sk->keperluan ?: 'Harian') ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted" style="padding: 30px;">
                                    Tidak ada stok keluar pada periode ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
