<!-- ===================================================== -->
<!--                    HEADER BANNER                     -->
<!-- ===================================================== -->

<p align="center">
  <img 
    src="warungsrc/baner.png"
    alt="Sistem Monitoring Stok Bahan Makanan"
    width="100%"
  />
</p>


<!-- ===================================================== -->
<!--                  TYPING ANIMATION                    -->
<!-- ===================================================== -->

<p align="center">
  <img 
    src="https://readme-typing-svg.demolab.com?font=Fira+Code&weight=700&size=22&duration=2800&pause=900&color=16A34A&center=true&vCenter=true&width=850&lines=Sistem+Monitoring+Stok+Bahan+Makanan;Warung+Mi+Ayam+Mas+Tono;Project+MPPL+Kelompok+5;Monitoring+Stok+Lebih+Mudah+dan+Terstruktur"
    alt="Typing Animation"
  />
</p>


<!-- ===================================================== -->
<!--                     NAVIGATION                       -->
<!-- ===================================================== -->

<p align="center">

<a href="#tentang-project">
<img src="https://img.shields.io/badge/🏠%20TENTANG-166534?style=for-the-badge"/>
</a>

<a href="#fitur-utama">
<img src="https://img.shields.io/badge/⚙️%20FITUR-F97316?style=for-the-badge"/>
</a>

<a href="#teknologi">
<img src="https://img.shields.io/badge/💻%20TEKNOLOGI-EAB308?style=for-the-badge"/>
</a>

<a href="#anggota-kelompok">
<img src="https://img.shields.io/badge/👥%20ANGGOTA-16A34A?style=for-the-badge"/>
</a>

<a href="#dokumentasi">
<img src="https://img.shields.io/badge/📄%20DOKUMENTASI-92400E?style=for-the-badge"/>
</a>

</p>

<p align="center">

<a href="#cara-menjalankan">
<img src="https://img.shields.io/badge/🚀%20CARA%20MENJALANKAN-F97316?style=for-the-badge"/>
</a>

</p>


<!-- ===================================================== -->
<!--                 PROJECT STATUS                       -->
<!-- ===================================================== -->

<p align="center">

<img src="https://img.shields.io/badge/PROJECT-grey?style=for-the-badge"/>
<img src="https://img.shields.io/badge/MPPL%202026-166534?style=for-the-badge"/>

<img src="https://img.shields.io/badge/KELOMPOK-grey?style=for-the-badge"/>
<img src="https://img.shields.io/badge/KELOMPOK%205-EAB308?style=for-the-badge"/>

<img src="https://img.shields.io/badge/STATUS-grey?style=for-the-badge"/>
<img src="https://img.shields.io/badge/DEVELOPMENT-F97316?style=for-the-badge"/>

<img src="https://img.shields.io/badge/FRAMEWORK-grey?style=for-the-badge"/>
<img src="https://img.shields.io/badge/CodeIgniter%203-DD2A2A?style=for-the-badge"/>

<img src="https://img.shields.io/badge/DATABASE-grey?style=for-the-badge"/>
<img src="https://img.shields.io/badge/MySQL%20%2F%20MariaDB-00758F?style=for-the-badge"/>

</p>
---

<a id="tentang-project"></a>
# 🍜 Sistem Monitoring Stok Bahan Makanan Berbasis Digital Twin

### Warung Mi Ayam Mas Tono

Sistem Monitoring Stok Bahan Makanan merupakan sebuah sistem berbasis konsep **Digital Twin** yang dikembangkan untuk merepresentasikan kondisi fisik stok bahan makanan secara digital dan aktual di **Warung Mi Ayam Mas Tono**.

Sistem ini dirancang untuk memenuhi tugas mata kuliah **Manajemen Proyek Perangkat Lunak (MPPL)**, mengatasi permasalahan pencatatan manual, mencegah kehabisan stok saat jam sibuk penjualan, menghindari persediaan berlebih yang basi, serta menyediakan transparansi pengadaan bahan bagi pemilik usaha.

---

## 🎯 Konsep Digital Twin pada Sistem

Konsep **Digital Twin** dalam aplikasi ini diterapkan sebagai representasi virtual dari kondisi fisik rak dan persediaan bahan makanan di Warung Mie Ayam Mas Tono:
- **Sinkronisasi Dinamis:** Setiap transaksi stok masuk (*penerimaan dari pasar/supplier*) dan stok keluar (*pemakaian memasak harian*) secara otomatis memperbarui representasi kembar digital secara instan.
- **Visualisasi Status Fisik:** Menggunakan indikator level persentase buffer dan skema visual (*Aman*, *Menipis*, *Kritis/Habis*) untuk merefleksikan volume fisik secara intuitif.
- **Peringatan Ambang Batas Otomatis (*Buffer Threshold*):** Notifikasi dini ketika stok menyentuh atau berada di bawah batas minimum (*safety stock*).

---

## 🎯 Tujuan Project

Project ini bertujuan untuk membantu pemilik warung dalam:

- 📦 Memantau ketersediaan bahan makanan secara real-time
- 📊 Mengetahui jumlah stok fisik aktual yang tersedia
- ⚠️ Mendeteksi dini bahan yang mulai menipis melalui buffer alert
- 📝 Mengelola data bahan makanan, kategori, dan batas minimum
- 🔄 Mempermudah proses pencatatan stok masuk dan keluar
- ⏱️ Mengurangi risiko kehabisan bahan saat operasional jam sibuk warung

---

## 💡 Permasalahan

Pengelolaan stok bahan makanan yang dilakukan secara manual dapat menyebabkan beberapa permasalahan, seperti:

- Kesulitan mengetahui jumlah stok secara cepat
- Risiko kesalahan pencatatan pembukuan manual
- Bahan makanan dapat habis tiba-tiba tanpa diketahui saat warung ramai
- Sulit melakukan pemantauan persediaan dan estimasi nilai aset bahan
- Proses pengecekan fisik membutuhkan waktu dan tenaga

Oleh karena itu, dikembangkan sebuah sistem monitoring stok berbasis Digital Twin yang dapat membantu proses pengelolaan persediaan secara lebih efektif dan efisien.

---

## 🏪 Studi Kasus

### Warung Mi Ayam Mas Tono

Beberapa bahan yang menjadi bagian dari sistem monitoring antara lain:

| 🥘 Bahan | 📦 Contoh Penggunaan | Satuan |
|---|---|:---:|
| 🍜 **Mie Basah** | Bahan utama mi ayam | kg |
| 🍗 **Daging Ayam** | Topping utama mi ayam | kg |
| 🥬 **Sawi Hijau** | Sayuran pelengkap | ikat |
| 🌿 **Daun Bawang** | Pelengkap aromatik | ikat |
| 🧂 **Minyak & Bumbu Racik** | Bahan penyedap dan kuah | liter / botol |
| 🥚 **Telur Puyuh / Ayam** | Bahan pelengkap tambahan | butir |
| 🥟 **Kulit Pangsit** | Pangsit goreng / rebus | bungkus |

---

<a id="fitur-utama"></a>
## 🚀 Fitur Utama

| Fitur | Deskripsi |
|:---:|---|
| 📊 **Dashboard Digital Twin** | Visualisasi kondisi stok bahan dengan indikator kapasitas dan peringatan stok menipis |
| 📦 **Data Bahan (CRUD)** | Mengelola data bahan makanan, kategori, satuan, harga, dan batas minimum stok |
| 📥 **Pencatatan Stok Masuk** | Mencatat pasokan penerimaan bahan dari pasar dan otomatis memperbarui stok fisik |
| 📤 **Pencatatan Stok Keluar** | Mencatat pemakaian bahan masak dengan validasi ketat ketersediaan stok |
| ⚠️ **Monitoring Buffer & Peringatan** | Indikator visual level aman, menipis, atau kritis dengan rekomendasi restock proaktif |
| 📋 **Log Riwayat (Audit Trail)** | Rekaman kronologis dari seluruh mutasi dan aktivitas sistem secara transparan |
| 📑 **Laporan & Cetak Dokumen** | Rekapitulasi mutasi dan valuasi persediaan siap cetak formal / export PDF |

### Rincian Fitur Lengkap:
1. **🔐 Autentikasi Pengguna & Hak Akses:**
   - Login aman dengan hashing password bcrypt dan session management.
   - Hak akses role: **Administrator** dan **Pemilik Usaha (Owner)**.
2. **📊 Dashboard Interaktif:**
   - KPI card statistik: Total bahan terdaftar, bahan stok menipis/kritis, stok masuk hari ini, dan stok keluar hari ini.
   - Grid Digital Twin dengan kartu visual bahan dan progress bar persentase buffer.
   - Panel peringatan dini bahan yang memerlukan restock segera.
3. **📦 Manajemen Master Bahan Makanan:**
   - Kode bahan otomatis terstandarisasi (`BHN-001`, `BHN-002`, dst.).
   - Pengelompokan kategori: Bahan Utama, Bumbu & Rempah, Sayuran, Pelengkap, Minuman.
4. **📥 Transaksi Stok Masuk:**
   - Nomor transaksi otomatis (`SM-YYYYMMDD-XXX`), langsung menambah stok aktual.
5. **📤 Transaksi Stok Keluar:**
   - Nomor transaksi otomatis (`SK-YYYYMMDD-XXX`), proteksi terhadap pengurangan melebihi batas stok.
6. **📋 Riwayat Mutasi Lengkap:**
   - Filter mutasi berdasarkan rentang tanggal dan tipe aktivitas.
7. **📑 Laporan Resmi Siap Cetak:**
   - Mode cetak dokumen rapi lengkap dengan kop surat UMKM dan lembar tanda tangan.

---

<a id="teknologi"></a>
## 🛠️ Arsitektur & Teknologi

| Komponen | Teknologi | Keterangan |
|---|---|---|
| **Backend** | PHP 7.4 / 8.x, **CodeIgniter 3** | MVC Architecture, Lightweight & Fast |
| **Database** | **MySQL / MariaDB** | Relasi tabel InnoDB dengan Foreign Keys |
| **Frontend UI** | **Vanilla CSS & HTML5** | Modern Dark Amber Glassmorphism Theme |
| **Typography** | **Inter (Google Fonts)** | Tipografi modern dan mudah dibaca |
| **Interactivity** | Pure Vanilla JavaScript | Form validation, dynamic DOM, modal management |

---

<a id="anggota-kelompok"></a>
## 👥 Tim Pengembang (Kelompok 5)

**Mata Kuliah:** Manajemen Proyek Perangkat Lunak (MPPL)  
**Dosen Pengampu:** Cut Alna Fadhilla, S.Kom., M.Sc  
**Program Studi:** S1 Informatika — Fakultas Sains dan Teknologi  
**Instansi:** Universitas Samudra, Langsa (2026)

| No. | Nama Anggota | NIM | Peran dalam Proyek |
|:---:|:---|:---:|:---|
| 1 | **Syahid Al Hakim** | `230504051` | Project Manager & Fullstack Developer |
| 2 | **Nur Atikah** | `230504054` | System Analyst & Database Designer |
| 3 | **Mahesa Kayan** | `230504040` | Backend & Integration Engineer |
| 4 | **Jelita Aprilia Anas Tasya** | `230504033` | UI/UX Designer & Frontend Developer |

**Pemilik / Sponsor UMKM:** Dalu Meriana (*Warung Mie Ayam Mastono*)  
**Lokasi Usaha:** Jl. Syiah Kuala No 102, Pb. Blang Pase, Langsa Kota, Kota Langsa, Aceh.

---

<a id="dokumentasi"></a>
## 📂 Struktur Direktori Proyek

```plaintext
mie-ayam/
├── apps/                                  # Source code utama aplikasi CodeIgniter 3
│   ├── .htaccess                          # URL rewrite untuk clean URLs
│   ├── index.php                          # Front controller CodeIgniter
│   ├── assets/
│   │   └── css/
│   │       └── style.css                  # Design System lengkap & responsif
│   └── application/
│       ├── config/
│       │   ├── autoload.php               # Autoload library (database, session, form_validation, url)
│       │   ├── config.php                 # Konfigurasi base_url dinamis & encryption key
│       │   ├── database.php               # Konfigurasi koneksi MySQL
│       │   └── routes.php                 # Pemetaan rute URL aplikasi
│       ├── controllers/
│       │   ├── Auth.php                   # Controller login, autentikasi, logout
│       │   ├── Dashboard.php              # Controller dashboard & API statistik
│       │   ├── Bahan.php                  # Controller CRUD data bahan
│       │   ├── Stok_masuk.php             # Controller transaksi stok masuk
│       │   ├── Stok_keluar.php            # Controller transaksi stok keluar
│       │   ├── Status_stok.php            # Controller monitoring level stok
│       │   ├── Riwayat.php                # Controller log mutasi & riwayat aktivitas
│       │   └── Laporan.php                # Controller rekapitulasi & cetak laporan
│       ├── models/
│       │   ├── User_model.php             # Model data pengguna & verifikasi password
│       │   ├── Bahan_model.php            # Model bahan, kalkulasi stok & batas minimum
│       │   ├── Stok_masuk_model.php       # Model transaksi stok masuk
│       │   ├── Stok_keluar_model.php      # Model transaksi stok keluar
│       │   └── Riwayat_model.php          # Model audit trail aktivitas
│       └── views/
│           ├── templates/
│           │   ├── header.php             # Layout header & navigasi sidebar
│           │   └── footer.php             # Layout footer & script modal/alert
│           ├── auth/
│           │   └── login.php              # Halaman login modern
│           ├── dashboard/
│           │   └── index.php              # Tampilan Dashboard Digital Twin
│           ├── bahan/
│           │   └── index.php              # Tampilan data bahan & modal CRUD
│           ├── stok_masuk/
│           │   └── index.php              # Tampilan catatan stok masuk & modal input
│           ├── stok_keluar/
│           │   └── index.php              # Tampilan catatan stok keluar & modal input
│           ├── status_stok/
│           │   └── index.php              # Tampilan monitoring status & level buffer
│           ├── riwayat/
│           │   └── index.php              # Tampilan riwayat aktivitas & filter tanggal
│           └── laporan/
│               ├── index.php              # Tampilan rekapitulasi persediaan & periode
│               └── cetak.php              # Halaman cetak laporan formal siap print/PDF
├── database/
│   └── mie_ayam_mastono.sql               # Skema database relasional & data awal
├── docs/                                  # Dokumen Project Charter & Laporan MPPL
├── warungsrc/
│   ├── baner.png                          # Banner utama warung mie ayam
│   └── banner.png                         # Alias banner warung
└── README.md                              # Dokumentasi sistem ini
```

---

<a id="cara-menjalankan"></a>
## 🚀 Panduan Instalasi & Menjalankan Aplikasi

### 1. Prasyarat Sistem
- Web Server: **Apache** (tersedia di XAMPP / Laragon / WampServer)
- PHP: Versi **7.4, 8.0, 8.1, atau 8.2**
- MySQL / MariaDB Server

### 2. Impor Database
1. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`) atau terminal MySQL Anda.
2. Buat database baru dengan nama `mie_ayam_mastono` atau langsung impor file SQL:
   - Lokasi file: `database/mie_ayam_mastono.sql`
3. Seluruh tabel (`users`, `kategori_bahan`, `bahan`, `stok_masuk`, `stok_keluar`, `riwayat`) beserta data sampel awal akan otomatis terbuat.

### 3. Konfigurasi Koneksi Database
Jika username dan password MySQL Anda berbeda dari default XAMPP (`root` tanpa password), sesuaikan file:  
`apps/application/config/database.php`

```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',        // Sesuaikan username database Anda
    'password' => '',            // Sesuaikan password database Anda
    'database' => 'mie_ayam_mastono',
    'dbdriver' => 'mysqli',
    ...
);
```

### 4. Menjalankan Aplikasi

#### Cara A: Menggunakan XAMPP (Direkomendasikan)
1. Pindahkan atau buat direktori proyek ini di dalam `htdocs` XAMPP Anda:
   - Contoh: `C:\xampp\htdocs\mie-ayam`
2. Jalankan Apache dan MySQL melalui **XAMPP Control Panel**.
3. Buka browser dan akses:
   ```
   http://localhost/mie-ayam/apps/
   ```

#### Cara B: Menggunakan PHP Built-in Server
1. Buka terminal / PowerShell di direktori `apps`:
   ```powershell
   cd c:\xampp\htdocs\mie-ayam\apps
   php -S localhost:8080
   ```
2. Buka browser dan akses:
   ```
   http://localhost:8080
   ```

---

## 🔑 Akun Default untuk Login

Gunakan salah satu akun berikut untuk masuk ke dalam sistem:

| Role / Jabatan | Username | Password | Keterangan |
|:---|:---|:---|:---|
| **Administrator** | `admin` | `admin123` | Akses penuh manajemen sistem & mutasi stok |
| **Pemilik Usaha** | `pemilik` | `admin123` | Dalu Meriana (Owner Warung) |

---

## 📋 Pengujian & Verifikasi Fitur

Berikut alur verifikasi fitur yang dapat dicoba:
1. **Login:** Masuk dengan akun `admin` / `admin123`.
2. **Dashboard:** Pantau ringkasan kartu statistik, representasi Digital Twin bahan makanan, dan peringatan bahan yang hampir habis.
3. **Data Bahan:** Tambahkan bahan makanan baru (misal: *Pangsit Rebus*, batas minimum: 5 bungkus).
4. **Stok Masuk:** Catat penerimaan bahan masuk dari pasar, periksa bahwa stok fisik bahan langsung bertambah secara otomatis.
5. **Stok Keluar:** Catat pemakaian memasak harian, uji validasi stok jika mencoba menginput jumlah melebihi stok yang ada.
6. **Status Stok:** Tinjau status visual aman/menipis/kritis serta bar kapasitas buffer persediaan.
7. **Riwayat:** Telusuri rekaman kronologis dari semua aksi yang baru saja dilakukan.
8. **Laporan & Cetak:** Pilih periode tanggal, tinjau estimasi total nilai aset persediaan bahan, dan klik tombol **Cetak / Unduh Laporan** untuk melihat format cetak dokumen resmi.

---

## 📄 Lisensi & Hak Cipta

Dikembangkan oleh **Kelompok 5 MPPL 2026** - Program Studi Informatika, Universitas Samudra. Didedikasikan untuk kemajuan operasional UMKM **Warung Mie Ayam Mastono**.
