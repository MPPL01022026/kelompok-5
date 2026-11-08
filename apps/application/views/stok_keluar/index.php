<div class="card mb-3">
    <div class="card-header">
        <div>
            <h3>📤 Pencatatan Stok Keluar (Pemakaian)</h3>
            <p class="fs-sm text-muted" style="margin-top: 4px;">
                Catat pemakaian bahan baku untuk operasional memasak harian atau bahan afkir/rusak
            </p>
        </div>
        <div class="d-flex align-center gap-1">
            <button class="btn btn-primary" onclick="openModal('modalStokKeluar')">
                + Catat Stok Keluar
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="filter-bar">
            <input type="text" id="searchStokKeluar" class="form-control" placeholder="Cari transaksi, bahan, atau keperluan..." onkeyup="filterStokKeluar()">
        </div>

        <div class="table-responsive">
            <table class="table" id="tableStokKeluar">
                <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Bahan Makanan</th>
                        <th>Jumlah Keluar</th>
                        <th>Keperluan / Tujuan</th>
                        <th>Dicatat Oleh</th>
                        <th>Keterangan</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($stok_keluar)): ?>
                        <?php foreach ($stok_keluar as $sk): ?>
                            <tr>
                                <td>
                                    <span class="badge badge-info" style="font-family: monospace;">
                                        <?= htmlspecialchars($sk->kode_transaksi) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($sk->tanggal)) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($sk->nama_bahan ?? 'Bahan Dihapus') ?></strong>
                                    <?php if (!empty($sk->kode_bahan)): ?>
                                        <div class="fs-sm text-muted"><?= htmlspecialchars($sk->kode_bahan) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-danger fw-bold" style="font-size: 13px;">
                                        - <?= rtrim(rtrim(number_format($sk->jumlah, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($sk->satuan ?? '') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-warning">
                                        <?= htmlspecialchars($sk->keperluan ?: 'Pemakaian Harian') ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($sk->nama_user ?? 'Admin') ?></td>
                                <td><?= !empty($sk->keterangan) ? htmlspecialchars($sk->keterangan) : '<span class="text-muted">-</span>' ?></td>
                                <td style="text-align: right;">
                                    <button type="button" class="btn btn-danger btn-sm" 
                                        onclick="confirmDelete('<?= base_url('stok_keluar/hapus/' . $sk->id) ?>', 'transaksi <?= htmlspecialchars($sk->kode_transaksi) ?>')">
                                        🗑️ Batalkan
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted" style="padding: 40px;">
                                Belum ada riwayat stok keluar. Klik tombol <strong>+ Catat Stok Keluar</strong> untuk mencatat pemakaian.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Catat Stok Keluar -->
<div class="modal-overlay" id="modalStokKeluar">
    <div class="modal">
        <div class="modal-header">
            <h3>📤 Form Pencatatan Stok Keluar</h3>
            <button class="modal-close" onclick="closeModal('modalStokKeluar')">&times;</button>
        </div>
        <form action="<?= base_url('stok_keluar/tambah') ?>" method="POST" onsubmit="return validateStokKeluar()">
            <div class="modal-body">
                <div class="grid-2 mb-2">
                    <div class="form-group">
                        <label class="form-label">No. Transaksi</label>
                        <input type="text" name="kode_transaksi" class="form-control" value="<?= $kode_transaksi ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Pemakaian <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Pilih Bahan Makanan <span class="text-danger">*</span></label>
                    <select name="bahan_id" id="selectBahanKeluar" class="form-control" onchange="updateSatuanKeluar()" required>
                        <option value="">-- Pilih Bahan --</option>
                        <?php if (!empty($bahan_list)): ?>
                            <?php foreach ($bahan_list as $b): ?>
                                <option value="<?= $b->id ?>" data-satuan="<?= htmlspecialchars($b->satuan) ?>" data-stok="<?= $b->stok_saat_ini ?>">
                                    <?= htmlspecialchars($b->kode_bahan) ?> - <?= htmlspecialchars($b->nama_bahan) ?> (Tersedia: <?= rtrim(rtrim(number_format($b->stok_saat_ini, 2, '.', ''), '0'), '.') ?> <?= $b->satuan ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="grid-2 mb-2">
                    <div class="form-group">
                        <label class="form-label">Jumlah Pemakaian <span class="text-danger">*</span></label>
                        <div class="d-flex align-center gap-1">
                            <input type="number" step="0.01" name="jumlah" id="inputJumlahKeluar" class="form-control" placeholder="0.00" min="0.01" required>
                            <span id="labelSatuanKeluar" class="text-muted" style="min-width: 45px; font-weight: 500;">-</span>
                        </div>
                        <div id="stokWarning" class="fs-sm text-danger mt-2" style="display: none;">
                            ⚠️ Jumlah melebihi stok yang tersedia!
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keperluan / Kategori Pengeluaran</label>
                        <select name="keperluan" class="form-control">
                            <option value="Pemakaian Harian">Pemakaian Harian (Masak)</option>
                            <option value="Persiapan Porsi Tambahan">Persiapan Porsi Tambahan</option>
                            <option value="Bahan Rusak / Basi">Bahan Rusak / Basi</option>
                            <option value="Sampel / Uji Rasa">Sampel / Uji Rasa</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan opsional mengenai pemakaian bahan ini..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalStokKeluar')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btnSubmitKeluar">Simpan Stok Keluar</button>
            </div>
        </form>
    </div>
</div>

<script>
let currentAvailableStock = 0;

function updateSatuanKeluar() {
    const sel = document.getElementById('selectBahanKeluar');
    const opt = sel.options[sel.selectedIndex];
    const satuan = opt.getAttribute('data-satuan') || '-';
    currentAvailableStock = parseFloat(opt.getAttribute('data-stok') || 0);
    document.getElementById('labelSatuanKeluar').textContent = satuan;
    checkStockLimit();
}

document.getElementById('inputJumlahKeluar').addEventListener('input', checkStockLimit);

function checkStockLimit() {
    const val = parseFloat(document.getElementById('inputJumlahKeluar').value) || 0;
    const warning = document.getElementById('stokWarning');
    const btn = document.getElementById('btnSubmitKeluar');

    if (val > currentAvailableStock && currentAvailableStock > 0) {
        warning.style.display = 'block';
        warning.textContent = '⚠️ Jumlah (' + val + ') melebihi stok tersedia (' + currentAvailableStock + ')!';
        btn.disabled = true;
    } else {
        warning.style.display = 'none';
        btn.disabled = false;
    }
}

function validateStokKeluar() {
    const val = parseFloat(document.getElementById('inputJumlahKeluar').value) || 0;
    if (val > currentAvailableStock) {
        alert('Stok tidak mencukupi! Stok saat ini: ' + currentAvailableStock);
        return false;
    }
    return true;
}

function filterStokKeluar() {
    const search = document.getElementById('searchStokKeluar').value.toLowerCase();
    const rows = document.querySelectorAll('#tableStokKeluar tbody tr');
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
}
</script>
