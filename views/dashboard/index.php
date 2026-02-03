<?php
if (!isset($_SESSION['login'])) {
    header("Location: index.php?page=login");
    exit;
}

// PESANAN TERBARU
$pesananBaru = mysqli_query($conn,"
    SELECT 
        p.id,
        pl.nama AS pelanggan,
        p.tanggal_sewa,
        p.status
    FROM pemesanan p
    LEFT JOIN pelanggan pl ON p.user_id = pl.id
    ORDER BY p.id DESC
    LIMIT 5
");

// TOTAL DATA
$totalBus        = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM bus"))['total'];
$busTersedia     = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM bus WHERE status='tersedia'"))['total'];
$totalPelanggan  = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM pelanggan"))['total'];
$totalPesanan    = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM pemesanan"))['total'];
?>

<div class="dashboard">

<div class="main">

    <!-- STATISTIC -->
    <div class="stat-grid">

        <div class="stat-card">
            <span>🚌</span>
            <div>
                <h4>Total Bus</h4>
                <p><?= $totalBus ?></p>
            </div>
        </div>

        <div class="stat-card green">
            <span>✅</span>
            <div>
                <h4>Bus Tersedia</h4>
                <p><?= $busTersedia ?></p>
            </div>
        </div>

        <div class="stat-card blue">
            <span>🧾</span>
            <div>
                <h4>Total Pesanan</h4>
                <p><?= $totalPesanan ?></p>
            </div>
        </div>

        <div class="stat-card purple">
            <span>👤</span>
            <div>
                <h4>Pelanggan</h4>
                <p><?= $totalPelanggan ?></p>
            </div>
        </div>

    </div>

    <!-- QUICK ACTION -->
    <div class="quick-grid">

        <a href="index.php?page=bus_tambah" class="quick-card">
            ➕<br>Tambah Bus
        </a>

        <a href="index.php?page=pelanggan&tambah=1" class="quick-card">
            👤<br>Tambah Pelanggan
        </a>

        <a href="index.php?page=pemesanan&tambah=1" class="quick-card">
            📝<br>Buat Pesanan
        </a>

        <a href="index.php?page=transaksi" class="quick-card">
            🔄<br>Transaksi
        </a>

    </div>

    <!-- RECENT ORDER -->
    <div class="card">
        <h3 style="margin-bottom:15px">🧾 Pemesanan Terbaru</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
            <?php $no=1; while($p = mysqli_fetch_assoc($pesananBaru)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $p['pelanggan'] ?></td>
                    <td><?= $p['tanggal_sewa'] ?></td>
                    <td>
                        <span class="badge 
                            <?= $p['status']=='dipinjam' ? 'bg-kuning' : 'bg-hijau' ?>">
                            <?= ucfirst($p['status']) ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
