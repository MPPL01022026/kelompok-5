<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Monitoring Stok Bahan Makanan - Warung Mie Ayam Mastono">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Mie Ayam Mastono</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">🍜</div>
                <div class="brand-text">
                    <h2>Mie Ayam Mastono</h2>
                    <span>Monitoring Stok Digital</span>
                </div>
            </div>
            
            <nav class="sidebar-menu">
                <div class="menu-label">Menu Utama</div>
                
                <a href="<?= base_url('dashboard') ?>" class="menu-item <?= (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : '' ?>">
                    <span class="icon">📊</span>
                    Dashboard
                </a>
                
                <a href="<?= base_url('bahan') ?>" class="menu-item <?= (isset($active_menu) && $active_menu == 'bahan') ? 'active' : '' ?>">
                    <span class="icon">📦</span>
                    Data Bahan
                </a>

                <div class="menu-label">Transaksi Stok</div>
                
                <a href="<?= base_url('stok-masuk') ?>" class="menu-item <?= (isset($active_menu) && $active_menu == 'stok_masuk') ? 'active' : '' ?>">
                    <span class="icon">📥</span>
                    Stok Masuk
                </a>
                
                <a href="<?= base_url('stok-keluar') ?>" class="menu-item <?= (isset($active_menu) && $active_menu == 'stok_keluar') ? 'active' : '' ?>">
                    <span class="icon">📤</span>
                    Stok Keluar
                </a>

                <div class="menu-label">Monitoring</div>
                
                <a href="<?= base_url('status-stok') ?>" class="menu-item <?= (isset($active_menu) && $active_menu == 'status_stok') ? 'active' : '' ?>">
                    <span class="icon">🔍</span>
                    Status Stok
                </a>
                
                <a href="<?= base_url('riwayat') ?>" class="menu-item <?= (isset($active_menu) && $active_menu == 'riwayat') ? 'active' : '' ?>">
                    <span class="icon">📋</span>
                    Riwayat
                </a>
                
                <a href="<?= base_url('laporan') ?>" class="menu-item <?= (isset($active_menu) && $active_menu == 'laporan') ? 'active' : '' ?>">
                    <span class="icon">📑</span>
                    Laporan
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="user-avatar">
                        <?= strtoupper(substr($this->session->userdata('nama') ?? 'U', 0, 1)) ?>
                    </div>
                    <div class="user-info">
                        <div class="name"><?= $this->session->userdata('nama') ?? 'User' ?></div>
                        <div class="role"><?= ucfirst($this->session->userdata('role') ?? 'user') ?></div>
                    </div>
                    <a href="<?= base_url('logout') ?>" class="btn btn-icon btn-outline" title="Logout" style="font-size: 14px;">🚪</a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <div>
                    <button class="mobile-toggle" onclick="toggleSidebar()">☰</button>
                    <h1><?= $title ?? 'Dashboard' ?></h1>
                    <div class="breadcrumb">
                        <span>Mie Ayam Mastono</span> / <?= $title ?? 'Dashboard' ?>
                    </div>
                </div>
                <div class="d-flex align-center gap-1">
                    <span class="fs-sm text-muted"><?= date('l, d F Y') ?></span>
                </div>
            </div>

            <div class="content-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        ✅ <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-error">
                        ❌ <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('warning')): ?>
                    <div class="alert alert-warning">
                        ⚠️ <?= $this->session->flashdata('warning') ?>
                    </div>
                <?php endif; ?>
