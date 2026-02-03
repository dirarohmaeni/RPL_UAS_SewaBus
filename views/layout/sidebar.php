<?php
$current = $_GET['page'] ?? 'dashboard';
?>

<aside class="sidebar">

    <div class="sidebar-brand">
        <span class="logo">🚌</span>
        <div>
            <h3>Sewa Bus</h3>
            <small>Admin Panel</small>
        </div>
    </div>

    <nav class="sidebar-menu">
        <a href="index.php?page=dashboard" class="<?= $current=='dashboard'?'active':'' ?>">🏠 Dashboard</a>
        <a href="index.php?page=bus" class="<?= $current=='bus'?'active':'' ?>">🚌 Data Bus</a>
        <a href="index.php?page=pelanggan" class="<?= $current=='pelanggan'?'active':'' ?>">👤 Pelanggan</a>
        <a href="index.php?page=pemesanan" class="<?= $current=='pemesanan'?'active':'' ?>">📑 Pemesanan</a>
        <a href="index.php?page=transaksi" class="<?= $current=='transaksi'?'active':'' ?>">🔄 Transaksi</a>
        <a href="index.php?page=laporan" class="<?= $current=='laporan'?'active':'' ?>">📊 Laporan</a>
    </nav>

    <div class="sidebar-footer">
        <a href="index.php?page=logout" class="btn-logout">🚪 Logout</a>
    </div>

</aside>
