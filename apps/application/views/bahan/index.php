<div class="card mb-3">
    <div class="card-header">
        <div>
            <h3>📦 Kelola Data Bahan Makanan</h3>
            <p class="fs-sm text-muted" style="margin-top: 4px;">
                Daftar seluruh bahan baku untuk operasional Warung Mie Ayam Mastono
            </p>
        </div>
        <div class="d-flex align-center gap-1">
            <button class="btn btn-primary" onclick="openModal('modalTambah')">
                + Tambah Bahan Baru
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Search and Quick Filter -->
        <div class="filter-bar">
            <input type="text" id="searchBahan" class="form-control" placeholder="Cari nama atau kode bahan..." onkeyup="filterBahanTable()">
            <select id="filterKategori" class="form-control" onchange="filterBahanTable()">
                <option value="">Semua Kategori</option>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat->nama_kategori) ?>"><?= htmlspecialchars($cat->nama_kategori) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table" id="tableBahan">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Bahan</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Stok Saat Ini</th>
                        <th>Batas Min</th>
                        <th>Harga Satuan</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bahan)): ?>
                        <?php foreach ($bahan as $b): 
                            $is_empty = ($b->stok_saat_ini <= 0);
                            $is_low = (!$is_empty && $b->stok_saat_ini <= $b->batas_minimum);
                        ?>
                            <tr data-nama="<?= strtolower(htmlspecialchars($b->nama_bahan)) ?>" 
                                data-kode="<?= strtolower(htmlspecialchars($b->kode_bahan)) ?>"
                                data-kategori="<?= htmlspecialchars($b->nama_kategori ?? '') ?>">
                                <td>
                                    <span class="badge badge-info" style="font-family: monospace;">
                                        <?= htmlspecialchars($b->kode_bahan) ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($b->nama_bahan) ?></strong>
                                    <?php if (!empty($b->keterangan)): ?>
                                        <div class="fs-sm text-muted"><?= htmlspecialchars($b->keterangan) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($b->nama_kategori ?? '-') ?></td>
                                <td><?= htmlspecialchars($b->satuan) ?></td>
                                <td>
                                    <span class="fw-bold <?= $is_empty ? 'text-danger' : ($is_low ? 'text-warning' : 'text-success') ?>">
                                        <?= rtrim(rtrim(number_format($b->stok_saat_ini, 2, '.', ''), '0'), '.') ?>
                                    </span>
                                </td>
                                <td><?= rtrim(rtrim(number_format($b->batas_minimum, 2, '.', ''), '0'), '.') ?></td>
                                <td>Rp <?= number_format($b->harga_satuan, 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($is_empty): ?>
                                        <span class="badge badge-danger">Habis</span>
                                    <?php elseif ($is_low): ?>
                                        <span class="badge badge-warning">Menipis</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Aman</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: right;">
                                    <div class="d-flex justify-content-end gap-1" style="justify-content: flex-end;">
                                        <button type="button" class="btn btn-outline btn-sm" 
                                            onclick="editBahan(<?= htmlspecialchars(json_encode($b)) ?>)">
                                            ✏️ Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="confirmDelete('<?= base_url('bahan/hapus/' . $b->id) ?>', '<?= htmlspecialchars($b->nama_bahan) ?>')">
                                            🗑️ Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted" style="padding: 40px;">
                                Belum ada data bahan makanan. Klik tombol <strong>+ Tambah Bahan Baru</strong> untuk memulai.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Bahan -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <h3>+ Tambah Bahan Makanan</h3>
            <button class="modal-close" onclick="closeModal('modalTambah')">&times;</button>
        </div>
        <form action="<?= base_url('bahan/tambah') ?>" method="POST">
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label class="form-label">Kode Bahan</label>
                    <input type="text" name="kode_bahan" class="form-control" value="<?= $kode_bahan ?>" readonly required>
                </div>
                
                <div class="form-group mb-2">
                    <label class="form-label">Nama Bahan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_bahan" class="form-control" placeholder="Contoh: Mie Basah, Daging Ayam" required>
                </div>

                <div class="grid-2 mb-2">
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat->id ?>"><?= htmlspecialchars($cat->nama_kategori) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Satuan <span class="text-danger">*</span></label>
                        <input type="text" name="satuan" class="form-control" placeholder="Contoh: kg, ikat, botol, liter" required>
                    </div>
                </div>

                <div class="grid-2 mb-2">
                    <div class="form-group">
                        <label class="form-label">Stok Awal</label>
                        <input type="number" step="0.01" name="stok_awal" class="form-control" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Batas Minimum (Peringatan) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="batas_minimum" class="form-control" value="5" min="0" required>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Estimasi Harga Satuan (Rp)</label>
                    <input type="number" name="harga_satuan" class="form-control" placeholder="0" min="0">
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Keterangan / Catatan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan tambahan seperti merk, supplier biasa, dsb."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalTambah')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Bahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Bahan -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <h3>✏️ Edit Data Bahan</h3>
            <button class="modal-close" onclick="closeModal('modalEdit')">&times;</button>
        </div>
        <form id="formEditBahan" action="" method="POST">
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label class="form-label">Kode Bahan</label>
                    <input type="text" id="edit_kode_bahan" class="form-control" readonly disabled>
                </div>
                
                <div class="form-group mb-2">
                    <label class="form-label">Nama Bahan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_bahan" id="edit_nama_bahan" class="form-control" required>
                </div>

                <div class="grid-2 mb-2">
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" id="edit_kategori_id" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat->id ?>"><?= htmlspecialchars($cat->nama_kategori) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Satuan <span class="text-danger">*</span></label>
                        <input type="text" name="satuan" id="edit_satuan" class="form-control" required>
                    </div>
                </div>

                <div class="grid-2 mb-2">
                    <div class="form-group">
                        <label class="form-label">Batas Minimum <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="batas_minimum" id="edit_batas_minimum" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Harga Satuan (Rp)</label>
                        <input type="number" name="harga_satuan" id="edit_harga_satuan" class="form-control">
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Keterangan / Catatan</label>
                    <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function filterBahanTable() {
    const search = document.getElementById('searchBahan').value.toLowerCase();
    const category = document.getElementById('filterKategori').value;
    const rows = document.querySelectorAll('#tableBahan tbody tr');

    rows.forEach(row => {
        const name = row.getAttribute('data-nama') || '';
        const code = row.getAttribute('data-kode') || '';
        const cat = row.getAttribute('data-kategori') || '';

        const matchSearch = name.includes(search) || code.includes(search);
        const matchCat = !category || cat === category;

        if (matchSearch && matchCat) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function editBahan(data) {
    document.getElementById('formEditBahan').action = '<?= base_url('bahan/edit/') ?>' + data.id;
    document.getElementById('edit_kode_bahan').value = data.kode_bahan;
    document.getElementById('edit_nama_bahan').value = data.nama_bahan;
    document.getElementById('edit_kategori_id').value = data.kategori_id || '';
    document.getElementById('edit_satuan').value = data.satuan;
    document.getElementById('edit_batas_minimum').value = data.batas_minimum;
    document.getElementById('edit_harga_satuan').value = data.harga_satuan;
    document.getElementById('edit_keterangan').value = data.keterangan || '';
    openModal('modalEdit');
}
</script>
