<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Persediaan - Warung Mie Ayam Mastono</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f8f9fa;
            color: #212529;
            padding: 30px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .header h1 {
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .header h2 {
            font-size: 15px;
            font-weight: 500;
            color: #555;
            margin-bottom: 4px;
        }
        .header p {
            font-size: 13px;
            color: #777;
        }
        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            font-size: 13px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 15px;
        }
        .section-title {
            font-size: 15px;
            font-weight: 700;
            margin: 24px 0 12px;
            padding-bottom: 4px;
            border-bottom: 1px solid #ddd;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        table th, table td {
            border: 1px solid #dee2e6;
            padding: 8px 10px;
            text-align: left;
        }
        table th {
            background-color: #f1f3f5;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            padding-top: 20px;
            page-break-inside: avoid;
        }
        .sig-block {
            text-align: center;
            width: 240px;
        }
        .sig-space {
            height: 70px;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 4px;
        }
        .sig-role {
            font-size: 12px;
            color: #555;
        }
        .no-print {
            text-align: right;
            margin-bottom: 20px;
        }
        .btn-print {
            background: #f59e0b;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            font-weight: 600;
        }
        .btn-print:hover {
            background: #d97706;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Dokumen / Simpan PDF</button>
    </div>

    <div class="container">
        <div class="header">
            <h1>WARUNG MIE AYAM MASTONO</h1>
            <h2>SISTEM MONITORING STOK BAHAN MAKANAN DIGITAL TWIN</h2>
            <p>Jl. Syiah Kuala No 102, Pb. Blang Pase, Langsa Kota, Kota Langsa, Aceh</p>
        </div>

        <div class="meta-info">
            <div>
                <strong>Perihal:</strong> Laporan Ketersediaan & Mutasi Persediaan Bahan<br>
                <strong>Periode:</strong> <?= date('d F Y', strtotime($start)) ?> s/d <?= date('d F Y', strtotime($end)) ?>
            </div>
            <div class="text-right">
                <strong>Tanggal Cetak:</strong> <?= date('d/m/Y H:i') ?> WIB<br>
                <strong>Dicetak Oleh:</strong> <?= htmlspecialchars($this->session->userdata('nama') ?? 'Administrator') ?>
            </div>
        </div>

        <!-- 1. Kondisi Persediaan Fisik Terkini -->
        <div class="section-title">I. Ketersediaan Bahan Makanan Saat Ini</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;" class="text-center">No</th>
                    <th>Kode</th>
                    <th>Nama Bahan Makanan</th>
                    <th>Kategori</th>
                    <th class="text-right">Stok Fisik</th>
                    <th class="text-right">Batas Min</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Estimasi Nilai</th>
                    <th class="text-center">Kondisi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $grand_total = 0;
                if (!empty($bahan)):
                    foreach ($bahan as $b):
                        $subtotal = $b->stok_saat_ini * $b->harga_satuan;
                        $grand_total += $subtotal;
                        $is_empty = ($b->stok_saat_ini <= 0);
                        $is_low = (!$is_empty && $b->stok_saat_ini <= $b->batas_minimum);
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($b->kode_bahan) ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($b->nama_bahan) ?></td>
                        <td><?= htmlspecialchars($b->nama_kategori ?? '-') ?></td>
                        <td class="text-right fw-bold"><?= rtrim(rtrim(number_format($b->stok_saat_ini, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($b->satuan) ?></td>
                        <td class="text-right"><?= rtrim(rtrim(number_format($b->batas_minimum, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($b->satuan) ?></td>
                        <td class="text-right">Rp <?= number_format($b->harga_satuan, 0, ',', '.') ?></td>
                        <td class="text-right fw-bold">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        <td class="text-center">
                            <?= $is_empty ? 'KOSONG' : ($is_low ? 'MENIPIS' : 'AMAN') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    <tr style="background-color: #f9f9f9; font-weight: bold;">
                        <td colspan="7" class="text-right">TOTAL NILAI ESTIMASI PERSEDIAAN:</td>
                        <td class="text-right">Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                        <td></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data persediaan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- 2. Ringkasan Penerimaan Stok Masuk -->
        <div class="section-title">II. Ringkasan Stok Masuk (Periode <?= date('d/m/Y', strtotime($start)) ?> - <?= date('d/m/Y', strtotime($end)) ?>)</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;" class="text-center">No</th>
                    <th>No. Transaksi</th>
                    <th>Tanggal</th>
                    <th>Bahan Makanan</th>
                    <th class="text-right">Jumlah Masuk</th>
                    <th class="text-right">Total Biaya</th>
                    <th>Pemasok</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $tot_masuk_rp = 0;
                if (!empty($stok_masuk)):
                    foreach ($stok_masuk as $sm):
                        $tot_masuk_rp += $sm->harga_beli;
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($sm->kode_transaksi) ?></td>
                        <td><?= date('d/m/Y', strtotime($sm->tanggal)) ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($sm->nama_bahan) ?></td>
                        <td class="text-right fw-bold">+<?= rtrim(rtrim(number_format($sm->jumlah, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($sm->satuan) ?></td>
                        <td class="text-right"><?= $sm->harga_beli > 0 ? 'Rp ' . number_format($sm->harga_beli, 0, ',', '.') : '-' ?></td>
                        <td><?= htmlspecialchars($sm->supplier ?: '-') ?></td>
                    </tr>
                <?php endforeach; ?>
                    <tr style="background-color: #f9f9f9; font-weight: bold;">
                        <td colspan="5" class="text-right">TOTAL PENGELUARAN PEMBELIAN:</td>
                        <td class="text-right">Rp <?= number_format($tot_masuk_rp, 0, ',', '.') ?></td>
                        <td></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada transaksi stok masuk pada periode ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- 3. Ringkasan Pengeluaran Stok Keluar -->
        <div class="section-title">III. Ringkasan Stok Keluar / Pemakaian (Periode <?= date('d/m/Y', strtotime($start)) ?> - <?= date('d/m/Y', strtotime($end)) ?>)</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;" class="text-center">No</th>
                    <th>No. Transaksi</th>
                    <th>Tanggal</th>
                    <th>Bahan Makanan</th>
                    <th class="text-right">Jumlah Keluar</th>
                    <th>Keperluan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (!empty($stok_keluar)):
                    foreach ($stok_keluar as $sk):
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($sk->kode_transaksi) ?></td>
                        <td><?= date('d/m/Y', strtotime($sk->tanggal)) ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($sk->nama_bahan) ?></td>
                        <td class="text-right fw-bold">-<?= rtrim(rtrim(number_format($sk->jumlah, 2, '.', ''), '0'), '.') ?> <?= htmlspecialchars($sk->satuan) ?></td>
                        <td><?= htmlspecialchars($sk->keperluan ?: 'Pemakaian Harian') ?></td>
                        <td><?= htmlspecialchars($sk->keterangan ?: '-') ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada transaksi stok keluar pada periode ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Tanda Tangan Stakeholder -->
        <div class="signatures">
            <div class="sig-block">
                <p>Mengetahui,</p>
                <p class="sig-role">Pemilik Warung Mie Ayam Mastono</p>
                <div class="sig-space"></div>
                <p class="sig-name">Dalu Meriana</p>
                <p class="sig-role">Owner / Sponsor Proyek</p>
            </div>

            <div class="sig-block">
                <p>Langsa, <?= date('d F Y') ?></p>
                <p class="sig-role">Penanggung Jawab Proyek (MPPL)</p>
                <div class="sig-space"></div>
                <p class="sig-name">Syahid Al Hakim</p>
                <p class="sig-role">Project Manager - Kelompok 5</p>
            </div>
        </div>
    </div>

</body>
</html>
