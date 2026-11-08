<div class="card mb-3">
    <div class="card-header">
        <div>
            <h3>📥 Pencatatan Stok Masuk</h3>
            <p class="fs-sm text-muted" style="margin-top: 4px;">
                Catat penerimaan dan pembelian bahan makanan dari supplier ke persediaan warung
            </p>
        </div>
        <div class="d-flex align-center gap-1">
            <button class="btn btn-primary" onclick="openModal('modalStokMasuk')">
                + Catat Stok Masuk
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="filter-bar">
            <input type="text" id="searchStokMasuk" class="form-control" placeholder="Cari transaksi, bahan, atau supplier..." onkeyup="filterStokMasuk()">
        </div>

        <div class="table-responsive">
            <table class="table" id="tableStokMasuk">
                <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Bahan Makanan</th>
                        <th>Jumlah Masuk</th>
                        <th>Total Biaya</th>
                        <th>Supplier / Sumber</th>
                        <th>Dicatat Oleh</th>
                        <th>Keterangan</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($stok_masuk)): ?>
                        <?php foreach ($stok_masuk as $sm): ?>
                            <tr>
                                <td>
                                    <span class="badge badge-info" style="font-family: monospace;">
                                        <?= htmlspecialchars($sm->kode_transaksi) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($sm->tanggal)) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($sm->nama_bahan ?? 'Bahan Dihapus') ?></strong>
                                    <?php if (!empty($sm->kode_bahan)): ?>
                                        <div class="fs-sm text-muted"><?= htmlspecialchars($sm->kode_bahan) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-success fw-bold" style="font-size: 13px;">
                                        + <?= rtrim(rtrim(number_format($sm->jumlah, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($sm->satuan ?? '') ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $sm->harga_beli > 0 ? 'Rp ' . number_format($sm->harga_beli, 0, ',', '.') : '-' ?>
                                </td>
                                <td><?= !empty($sm->supplier) ? htmlspecialchars($sm->supplier) : '<span class="text-muted">-</span>' ?></td>
                                <td><?= htmlspecialchars($sm->nama_user ?? 'Admin') ?></td>
                                <td><?= !empty($sm->keterangan) ? htmlspecialchars($sm->keterangan) : '<span class="text-muted">-</span>' ?></td>
                                <td style="text-align: right;">
                                    <button type="button" class="btn btn-danger btn-sm" 
                                        onclick="confirmDelete('<?= base_url('stok_masuk/hapus/' . $sm->id) ?>', 'transaksi <?= htmlspecialchars($sm->kode_transaksi) ?>')">
                                        🗑️ Batalkan
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted" style="padding: 40px;">
                                Belum ada riwayat stok masuk. Klik tombol <strong>+ Catat Stok Masuk</strong> untuk mencatat.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Catat Stok Masuk -->
<div class="modal-overlay" id="modalStokMasuk">
    <div class="modal">
        <div class="modal-header">
            <h3>📥 Form Pencatatan Stok Masuk</h3>
            <button class="modal-close" onclick="closeModal('modalStokMasuk')">&times;</button>
        </div>
        <form action="<?= base_url('stok_masuk/tambah') ?>" method="POST">
            <div class="modal-body">
                <div class="grid-2 mb-2">
                    <div class="form-group">
                        <label class="form-label">No. Transaksi</label>
                        <input type="text" name="kode_transaksi" class="form-control" value="<?= $kode_transaksi ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Pilih Bahan Makanan <span class="text-danger">*</span></label>
                    <select name="bahan_id" id="selectBahanMasuk" class="form-control" onchange="updateSatuanMasuk()" required>
                        <option value="">-- Pilih Bahan --</option>
                        <?php if (!empty($bahan_list)): ?>
                            <?php foreach ($bahan_list as $b): ?>
                                <option value="<?= $b->id ?>" data-satuan="<?= htmlspecialchars($b->satuan) ?>" data-harga="<?= $b->harga_satuan ?>">
                                    <?= htmlspecialchars($b->kode_bahan) ?> - <?= htmlspecialchars($b->nama_bahan) ?> (Stok: <?= rtrim(rtrim(number_format($b->stok_saat_ini, 2, '.', ''), '0'), '.') ?> <?= $b->satuan ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="grid-2 mb-2">
                    <div class="form-group">
                        <label class="form-label">Jumlah Masuk <span class="text-danger">*</span></label>
                        <div class="d-flex align-center gap-1">
                            <input type="number" step="0.01" name="jumlah" id="inputJumlahMasuk" class="form-control" placeholder="0.00" min="0.01" required>
                            <span id="labelSatuanMasuk" class="text-muted" style="min-width: 45px; font-weight: 500;">-</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total Biaya Pembelian (Rp)</label>
                        <input type="number" name="harga_beli" id="inputHargaBeli" class="form-control" placeholder="0" min="0">
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Pemasok / Supplier / Toko</label>
                    <input type="text" name="supplier" class="form-control" placeholder="Contoh: Pasar Langsa, Toko Berkah, Agen Ayam">
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan opsional mengenai pembelian ini..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalStokMasuk')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Stok Masuk</button>
            </div>
        </form>
    </div>
</div>

<script>
function updateSatuanMasuk() {
    const sel = document.getElementById('selectBahanMasuk');
    const opt = sel.options[sel.selectedIndex];
    const satuan = opt.getAttribute('data-satuan') || '-';
    document.getElementById('labelSatuanMasuk').textContent = satuan;
}

function filterStokMasuk() {
    const search = document.getElementById('searchStokMasuk').value.toLowerCase();
    const rows = document.querySelectorAll('#tableStokMasuk tbody tr');
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
}
</script>
