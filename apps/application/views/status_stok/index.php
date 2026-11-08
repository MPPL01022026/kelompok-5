<?php
$count_empty = count($empty_stock);
$count_low = count($low_stock) - $count_empty; // menipis tapi belum 0
$count_safe = count($bahan) - count($low_stock);
?>

<!-- Status Summary Cards -->
<div class="stats-grid mb-3">
    <div class="stat-card primary" onclick="filterByStatus('all')" style="cursor: pointer;">
        <div class="stat-icon">📦</div>
        <div class="stat-value"><?= count($bahan) ?></div>
        <div class="stat-label">Semua Bahan Makanan</div>
    </div>
    <div class="stat-card success" onclick="filterByStatus('safe')" style="cursor: pointer;">
        <div class="stat-icon">✅</div>
        <div class="stat-value"><?= $count_safe ?></div>
        <div class="stat-label">Stok Aman (Di Atas Batas Min)</div>
    </div>
    <div class="stat-card warning" onclick="filterByStatus('warning')" style="cursor: pointer;">
        <div class="stat-icon">⚠️</div>
        <div class="stat-value"><?= max(0, $count_low) ?></div>
        <div class="stat-label">Stok Menipis (Perlu Restock)</div>
    </div>
    <div class="stat-card danger" onclick="filterByStatus('danger')" style="cursor: pointer;">
        <div class="stat-icon">🚨</div>
        <div class="stat-value"><?= $count_empty ?></div>
        <div class="stat-label">Stok Habis / Kritis (0)</div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <div>
            <h3>🔍 Monitoring Status Stok & Level Persediaan</h3>
            <p class="fs-sm text-muted" style="margin-top: 4px;">
                Representasi aktual tingkat ketersediaan stok fisik terhadap ambang batas minimum
            </p>
        </div>
        <div class="d-flex align-center gap-1">
            <a href="<?= base_url('stok-masuk') ?>" class="btn btn-primary btn-sm">
                + Restock Bahan
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Controls -->
        <div class="filter-bar">
            <input type="text" id="searchStatus" class="form-control" placeholder="Cari nama atau kode bahan..." onkeyup="filterStatusTable()">
            <select id="selectStatusFilter" class="form-control" onchange="filterStatusTable()">
                <option value="">Semua Status</option>
                <option value="safe">Hanya Stok Aman</option>
                <option value="warning">Hanya Stok Menipis</option>
                <option value="danger">Hanya Stok Habis / Kritis</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table" id="tableStatusStok">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Bahan</th>
                        <th>Kategori</th>
                        <th>Stok Fisik Saat Ini</th>
                        <th>Batas Minimum</th>
                        <th style="min-width: 200px;">Kapasitas & Persentase Buffer</th>
                        <th>Status Indikator</th>
                        <th style="text-align: right;">Rekomendasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bahan)): ?>
                        <?php foreach ($bahan as $b): 
                            $is_empty = ($b->stok_saat_ini <= 0);
                            $is_low = (!$is_empty && $b->stok_saat_ini <= $b->batas_minimum);
                            $status_code = $is_empty ? 'danger' : ($is_low ? 'warning' : 'safe');
                            
                            $max_ref = max($b->batas_minimum * 3, ($b->stok_saat_ini > 0 ? $b->stok_saat_ini * 1.2 : 10));
                            $pct = min(100, max(2, round(($b->stok_saat_ini / $max_ref) * 100)));
                        ?>
                            <tr data-status="<?= $status_code ?>" data-nama="<?= strtolower(htmlspecialchars($b->nama_bahan)) ?>" data-kode="<?= strtolower(htmlspecialchars($b->kode_bahan)) ?>">
                                <td>
                                    <span class="badge badge-info" style="font-family: monospace;">
                                        <?= htmlspecialchars($b->kode_bahan) ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($b->nama_bahan) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($b->nama_kategori ?? '-') ?></td>
                                <td>
                                    <span class="fw-bold <?= $is_empty ? 'text-danger' : ($is_low ? 'text-warning' : 'text-success') ?>" style="font-size: 14px;">
                                        <?= rtrim(rtrim(number_format($b->stok_saat_ini, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($b->satuan) ?>
                                    </span>
                                </td>
                                <td><?= rtrim(rtrim(number_format($b->batas_minimum, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($b->satuan) ?></td>
                                <td>
                                    <div class="d-flex align-center gap-1 mb-1">
                                        <div class="stock-bar" style="flex: 1; height: 8px; margin-top: 0; background: var(--bg-input);">
                                            <div class="stock-fill" style="width: <?= $pct ?>%; background: <?= $is_empty ? 'var(--danger)' : ($is_low ? 'var(--warning)' : 'var(--success)') ?>;"></div>
                                        </div>
                                        <span class="fs-sm fw-bold" style="min-width: 40px; text-align: right;"><?= $pct ?>%</span>
                                    </div>
                                    <div class="fs-sm text-muted">
                                        Buffer: <?= $b->stok_saat_ini > $b->batas_minimum ? '+' . rtrim(rtrim(number_format($b->stok_saat_ini - $b->batas_minimum, 2, '.', ''), '0'), '.') : '-' . rtrim(rtrim(number_format($b->batas_minimum - $b->stok_saat_ini, 2, '.', ''), '0'), '.') ?> <?= $b->satuan ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($is_empty): ?>
                                        <span class="badge badge-danger">🚨 Habis / Kosong</span>
                                    <?php elseif ($is_low): ?>
                                        <span class="badge badge-warning">⚠️ Menipis</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">✅ Stok Aman</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php if ($is_empty || $is_low): ?>
                                        <a href="<?= base_url('stok-masuk') ?>" class="btn btn-primary btn-sm">
                                            📥 Restock Segera
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted fs-sm">Cukup Tersedia</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted" style="padding: 40px;">
                                Belum ada data bahan yang dapat dipantau.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterByStatus(status) {
    const sel = document.getElementById('selectStatusFilter');
    sel.value = (status === 'all') ? '' : status;
    filterStatusTable();
}

function filterStatusTable() {
    const search = document.getElementById('searchStatus').value.toLowerCase();
    const status = document.getElementById('selectStatusFilter').value;
    const rows = document.querySelectorAll('#tableStatusStok tbody tr');

    rows.forEach(row => {
        const name = row.getAttribute('data-nama') || '';
        const code = row.getAttribute('data-kode') || '';
        const st = row.getAttribute('data-status') || '';

        const matchSearch = name.includes(search) || code.includes(search);
        const matchStatus = !status || st === status;

        if (matchSearch && matchStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>

