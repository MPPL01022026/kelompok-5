<div class="card mb-3">
    <div class="card-header">
        <div>
            <h3>📋 Log Riwayat Aktivitas & Mutasi Stok</h3>
            <p class="fs-sm text-muted" style="margin-top: 4px;">
                Catatan kronologis seluruh interaksi dan mutasi persediaan pada sistem
            </p>
        </div>
    </div>
    <div class="card-body">
        <!-- Date & Type Filter Form -->
        <form action="<?= base_url('riwayat') ?>" method="GET" class="filter-bar mb-3">
            <div class="d-flex align-center gap-1">
                <label class="fs-sm text-muted">Dari:</label>
                <input type="date" name="start" class="form-control" value="<?= htmlspecialchars($start) ?>">
            </div>
            <div class="d-flex align-center gap-1">
                <label class="fs-sm text-muted">Sampai:</label>
                <input type="date" name="end" class="form-control" value="<?= htmlspecialchars($end) ?>">
            </div>
            <div>
                <select name="tipe" class="form-control">
                    <option value="">-- Semua Tipe Aktivitas --</option>
                    <option value="masuk" <?= ($tipe_filter === 'masuk') ? 'selected' : '' ?>>📥 Stok Masuk</option>
                    <option value="keluar" <?= ($tipe_filter === 'keluar') ? 'selected' : '' ?>>📤 Stok Keluar</option>
                    <option value="edit" <?= ($tipe_filter === 'edit') ? 'selected' : '' ?>>✏️ Perubahan Data</option>
                    <option value="hapus" <?= ($tipe_filter === 'hapus') ? 'selected' : '' ?>>🗑️ Penghapusan Data</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">🔍 Terapkan Filter</button>
            <a href="<?= base_url('riwayat') ?>" class="btn btn-outline">Reset</a>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Waktu Kejadian</th>
                        <th>Tipe Aktivitas</th>
                        <th>Bahan Terkait</th>
                        <th>Jumlah Mutasi</th>
                        <th>Keterangan Aktivitas</th>
                        <th>Pelaksana</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat)): ?>
                        <?php $no = 1; foreach ($riwayat as $r): 
                            $badge_class = 'badge-info';
                            $label = 'Aktivitas';
                            $icon = '📋';
                            if ($r->tipe === 'masuk') {
                                $badge_class = 'badge-success';
                                $label = 'Stok Masuk';
                                $icon = '📥';
                            } elseif ($r->tipe === 'keluar') {
                                $badge_class = 'badge-danger';
                                $label = 'Stok Keluar';
                                $icon = '📤';
                            } elseif ($r->tipe === 'edit') {
                                $badge_class = 'badge-info';
                                $label = 'Perubahan';
                                $icon = '✏️';
                            } elseif ($r->tipe === 'hapus') {
                                $badge_class = 'badge-warning';
                                $label = 'Penghapusan';
                                $icon = '🗑️';
                            }
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <div class="fw-bold"><?= date('d/m/Y', strtotime($r->created_at)) ?></div>
                                    <div class="fs-sm text-muted"><?= date('H:i:s', strtotime($r->created_at)) ?> WIB</div>
                                </td>
                                <td>
                                    <span class="badge <?= $badge_class ?>">
                                        <?= $icon ?> <?= $label ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($r->nama_bahan)): ?>
                                        <strong><?= htmlspecialchars($r->nama_bahan) ?></strong>
                                        <div class="fs-sm text-muted"><?= htmlspecialchars($r->kode_bahan) ?></div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($r->jumlah !== null && $r->jumlah > 0): ?>
                                        <span class="fw-bold <?= ($r->tipe === 'masuk') ? 'text-success' : 'text-danger' ?>">
                                            <?= ($r->tipe === 'masuk') ? '+' : (($r->tipe === 'keluar') ? '-' : '') ?><?= rtrim(rtrim(number_format($r->jumlah, 2, '.', ''), '0'), '.') ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($r->keterangan) ?></td>
                                <td>
                                    <div class="d-flex align-center gap-1">
                                        <span>👤</span>
                                        <span><?= htmlspecialchars($r->nama_user ?? 'Sistem') ?></span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: 40px;">
                                Tidak ada catatan riwayat pada periode tanggal ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
