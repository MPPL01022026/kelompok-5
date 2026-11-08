<!-- Stat Cards Grid -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-icon">📦</div>
        <div class="stat-value"><?= number_format($total_bahan, 0, ',', '.') ?></div>
        <div class="stat-label">Total Bahan Terdaftar</div>
    </div>
    <div class="stat-card <?= $low_stock_count > 0 ? 'danger' : 'success' ?>">
        <div class="stat-icon"><?= $low_stock_count > 0 ? '⚠️' : '✅' ?></div>
        <div class="stat-value"><?= $low_stock_count ?></div>
        <div class="stat-label">Bahan Stok Menipis / Kritis</div>
    </div>
    <div class="stat-card success">
        <div class="stat-icon">📥</div>
        <div class="stat-value"><?= number_format($stok_masuk_today, 0, ',', '.') ?></div>
        <div class="stat-label">Transaksi Masuk Hari Ini</div>
    </div>
    <div class="stat-card info">
        <div class="stat-icon">📤</div>
        <div class="stat-value"><?= number_format($stok_keluar_today, 0, ',', '.') ?></div>
        <div class="stat-label">Transaksi Keluar Hari Ini</div>
    </div>
</div>

<!-- Digital Twin Visualization Section -->
<div class="card mb-3">
    <div class="card-header">
        <div>
            <h3 style="display: flex; align-items: center; gap: 8px;">
                <span>🌐</span> Digital Twin - Representasi Fisik Stok Aktual
            </h3>
            <p class="fs-sm text-muted" style="margin-top: 4px;">
                Visualisasi status fisik bahan makanan di Warung Mie Ayam Mastono secara real-time
            </p>
        </div>
        <div class="d-flex align-center gap-1">
            <span class="badge badge-success"><span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#10b981; margin-right:4px;"></span> Aman</span>
            <span class="badge badge-warning"><span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#f59e0b; margin-right:4px;"></span> Menipis</span>
            <span class="badge badge-danger"><span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#ef4444; margin-right:4px;"></span> Kritis/Habis</span>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($all_bahan)): ?>
            <div class="digital-twin-grid">
                <?php 
                $icon_map = [
                    'Mie Basah'     => '🍜',
                    'Daging Ayam'   => '🍗',
                    'Kecap Manis'   => '🍶',
                    'Minyak Goreng' => '🫗',
                    'Bawang Merah'  => '🧅',
                    'Bawang Putih'  => '🧄',
                    'Sawi Hijau'    => '🥬',
                    'Daun Bawang'   => '🌱',
                    'Pangsit'       => '🥟',
                    'Bakso'         => '🧆',
                    'Garam'         => '🧂',
                    'Gula'          => '🍬',
                    'Merica'        => '🌶️',
                    'Cabai'         => '🌶️',
                    'Telur'         => '🥚'
                ];
                
                foreach ($all_bahan as $b): 
                    $icon = '📦';
                    foreach ($icon_map as $key => $ico) {
                        if (stripos($b->nama_bahan, $key) !== false) {
                            $icon = $ico;
                            break;
                        }
                    }
                    
                    // Stock status calculation
                    $is_danger = ($b->stok_saat_ini <= 0);
                    $is_warning = (!$is_danger && $b->stok_saat_ini <= $b->batas_minimum);
                    $status_class = $is_danger ? 'stock-danger' : ($is_warning ? 'stock-warning' : 'stock-safe');
                    
                    // Max reference for percentage bar
                    $max_ref = max($b->batas_minimum * 3, ($b->stok_saat_ini > 0 ? $b->stok_saat_ini * 1.2 : 10));
                    $pct = min(100, max(4, round(($b->stok_saat_ini / $max_ref) * 100)));
                ?>
                    <div class="twin-item <?= $status_class ?>">
                        <div class="twin-icon"><?= $icon ?></div>
                        <div class="twin-name" title="<?= htmlspecialchars($b->nama_bahan) ?>">
                            <?= htmlspecialchars($b->nama_bahan) ?>
                        </div>
                        <div class="twin-stock">
                            <?= rtrim(rtrim(number_format($b->stok_saat_ini, 2, '.', ''), '0'), '.') ?>
                        </div>
                        <div class="twin-unit"><?= htmlspecialchars($b->satuan) ?> (Min: <?= rtrim(rtrim(number_format($b->batas_minimum, 2, '.', ''), '0'), '.') ?>)</div>
                        <div class="stock-bar" title="Stok: <?= $b->stok_saat_ini ?> / Target: <?= $max_ref ?>">
                            <div class="stock-fill" style="width: <?= $pct ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h4>Belum Ada Bahan Terdaftar</h4>
                <p>Silakan daftarkan bahan makanan pada menu Data Bahan.</p>
                <a href="<?= base_url('bahan') ?>" class="btn btn-primary mt-2">+ Tambah Bahan</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Row 2 Columns: Peringatan Stok Menipis & Aktivitas Terkini -->
<div class="row-2-col">
    <!-- Peringatan Stok Menipis -->
    <div class="card">
        <div class="card-header">
            <h3>⚠️ Perhatian Stok Menipis (<?= count($low_stock) ?>)</h3>
            <a href="<?= base_url('status-stok') ?>" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if (!empty($low_stock)): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Bahan</th>
                                <th>Stok Saat Ini</th>
                                <th>Batas Min</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($low_stock as $ls): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($ls->nama_bahan) ?></strong>
                                        <div class="fs-sm text-muted"><?= htmlspecialchars($ls->kode_bahan) ?></div>
                                    </td>
                                    <td>
                                        <span class="fw-bold <?= $ls->stok_saat_ini <= 0 ? 'text-danger' : 'text-warning' ?>">
                                            <?= rtrim(rtrim(number_format($ls->stok_saat_ini, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($ls->satuan) ?>
                                        </span>
                                    </td>
                                    <td><?= rtrim(rtrim(number_format($ls->batas_minimum, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($ls->satuan) ?></td>
                                    <td>
                                        <?php if ($ls->stok_saat_ini <= 0): ?>
                                            <span class="badge badge-danger">Habis</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Menipis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('stok-masuk') ?>" class="btn btn-primary btn-sm" title="Tambah Stok">
                                            + Beli
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">✅</div>
                    <h4>Semua Stok Aman!</h4>
                    <p>Tidak ada bahan makanan yang berada di bawah batas minimum.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Aktivitas Terkini (Timeline) -->
    <div class="card">
        <div class="card-header">
            <h3>📋 Aktivitas Terkini</h3>
            <a href="<?= base_url('riwayat') ?>" class="btn btn-outline btn-sm">Semua Riwayat</a>
        </div>
        <div class="card-body">
            <?php if (!empty($recent_activities)): ?>
                <div class="timeline">
                    <?php foreach ($recent_activities as $act): 
                        $icon = '📋';
                        $class = 'masuk';
                        if ($act->tipe === 'masuk') { $icon = '📥'; $class = 'masuk'; }
                        elseif ($act->tipe === 'keluar') { $icon = '📤'; $class = 'keluar'; }
                        elseif ($act->tipe === 'edit') { $icon = '✏️'; $class = 'edit'; }
                        elseif ($act->tipe === 'hapus') { $icon = '🗑️'; $class = 'hapus'; }
                    ?>
                        <div class="timeline-item">
                            <div class="timeline-icon <?= $class ?>"><?= $icon ?></div>
                            <div class="timeline-content">
                                <div class="timeline-text"><?= htmlspecialchars($act->keterangan) ?></div>
                                <div class="timeline-time">
                                    <?= date('d M Y, H:i', strtotime($act->created_at)) ?> 
                                    <?= !empty($act->nama_user) ? '• oleh ' . htmlspecialchars($act->nama_user) : '' ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">📜</div>
                    <h4>Belum Ada Aktivitas</h4>
                    <p>Aktivitas stok masuk dan keluar akan tampil di sini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
