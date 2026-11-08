<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - Sistem Monitoring Stok Bahan Makanan Warung Mie Ayam Mastono">
    <title>Login - Mie Ayam Mastono</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <div class="login-card">
                <div class="login-logo">
                    <div class="logo-icon">🍜</div>
                    <h1>Warung Mie Ayam Mastono</h1>
                    <p>Sistem Monitoring Stok Digital Twin</p>
                </div>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-error">
                        ❌ <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        ✅ <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login') ?>" method="post" id="loginForm">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" 
                               placeholder="Masukkan username" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" 
                               placeholder="Masukkan password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        🔐 Masuk
                    </button>
                </form>

                <div style="text-align: center; margin-top: 24px;">
                    <p style="font-size: 11px; color: var(--text-muted);">
                        Jl. Syiah Kuala No 102, Langsa Kota<br>
                        &copy; <?= date('Y') ?> Warung Mie Ayam Mastono
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() { alert.remove(); }, 300);
        }, 5000);
    });
    </script>
</body>
</html>
