<?php
$q = $_GET['q'] ?? '';

$data = mysqli_query($conn, "
    SELECT 
        p.id,
        pl.nama AS nama_pelanggan,
        b.nama_bus,
        p.tanggal_sewa,
        p.tanggal_kembali,
        p.total_harga,
        p.metode_pembayaran,
        p.status_pembayaran,
        p.status
    FROM pemesanan p
    JOIN pelanggan pl ON p.user_id = pl.id
    JOIN bus b ON p.bus_id = b.id
    WHERE pl.nama LIKE '%$q%'
    ORDER BY p.id DESC
");
?>

<h2 class="page-title">📋 Data Pemesanan</h2>

<div class="page-toolbar">

    <!-- SEARCH -->
    <form method="GET" class="toolbar-search">
        <input type="hidden" name="page" value="pelanggan">

        <input
            type="text"
            name="q"
            placeholder="🔍 Cari nama / no HP..."
            value="<?= htmlspecialchars($q) ?>">

        <button class="btn">Cari</button>
    </form>

    <!-- ACTION BUTTON -->
    <div class="toolbar-action">
    <a href="index.php?page=pemesanan&tambah=1" class="btn btn-tambah">
        ➕ Tambah Pemesanan
    </a>
</div>

</div>

<!-- CARD LIST -->
<div class="card-list">

<?php if(mysqli_num_rows($data) > 0): ?>
<?php while($row = mysqli_fetch_assoc($data)): ?>

<div class="order-card">

    <!-- HEADER -->
    <div class="order-header">
        <div>
            <h3><?= htmlspecialchars($row['nama_pelanggan']) ?></h3>
            <small><?= htmlspecialchars($row['nama_bus']) ?></small>
        </div>

        <span class="badge 
            <?= $row['status']=='dipinjam' ? 'bg-kuning' : 'bg-hijau' ?>">
            <?= ucfirst($row['status']) ?>
        </span>
    </div>

    <!-- BODY -->
    <div class="order-body">
        <p>📅 <b>Sewa:</b>
            <?= $row['tanggal_sewa'] ?>
            →
            <?= $row['tanggal_kembali'] ?: '-' ?>
        </p>

        <p>💰 <b>Total:</b>
            Rp <?= number_format($row['total_harga']) ?>
        </p>

        <p>💳 <b>Metode:</b>
            <?= $row['metode_pembayaran'] ?: '-' ?>
        </p>

        <p>
            <b>Status Bayar:</b>
            <?php if($row['status_pembayaran'] == 'Lunas'): ?>
                <span class="badge bg-hijau">Lunas</span>
            <?php else: ?>
                <span class="badge bg-kuning">Belum Bayar</span>
            <?php endif; ?>
        </p>
    </div>

    <!-- ACTION -->
    <div class="order-action">
        <a href="index.php?page=pemesanan&detail=<?= $row['id'] ?>"
           class="btn btn-info">👁️ Detail</a>

        <?php if($row['status_pembayaran'] != 'Lunas'): ?>
            <a href="index.php?page=pembayaran&id=<?= $row['id'] ?>"
               class="btn btn-edit">💳 Bayar</a>
        <?php endif; ?>
    </div>

</div>

<?php endwhile; ?>
<?php else: ?>
    <div class="card" style="text-align:center">
        Data pemesanan tidak ditemukan
    </div>
<?php endif; ?>

</div>
