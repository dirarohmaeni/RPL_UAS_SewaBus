<?php
$q = $_GET['q'] ?? '';

$where = '';
if ($q != '') {
    $q_safe = mysqli_real_escape_string($conn, $q);
    $where = "WHERE pl.nama LIKE '%$q_safe%'
              OR b.nama_bus LIKE '%$q_safe%'";
}

$data = mysqli_query($conn, "
    SELECT 
        p.id,
        pl.nama AS nama_pelanggan,
        b.nama_bus,
        p.tanggal_sewa,
        p.tanggal_kembali,
        p.status_pengembalian,
        p.denda
    FROM pemesanan p
    LEFT JOIN pelanggan pl ON p.user_id = pl.id
    LEFT JOIN bus b ON p.bus_id = b.id
    $where
    ORDER BY p.id DESC
");
?>

<h2 class="page-title">🔄 Transaksi & Pengembalian</h2>

<!-- TOOLBAR -->
<div class="page-toolbar">

    <form method="GET" class="toolbar-search">
        <input type="hidden" name="page" value="transaksi">
        <input type="text"
               name="q"
               placeholder="🔍 Cari pelanggan / bus..."
               value="<?= htmlspecialchars($q) ?>">
        <button class="btn">Cari</button>
    </form>

</div>

<!-- CARD LIST -->
<div class="card-list">

<?php if(mysqli_num_rows($data) > 0): ?>
<?php while($row = mysqli_fetch_assoc($data)): ?>

<div class="transaction-card">

    <!-- HEADER -->
    <div class="transaction-header">
        <div>
            <h3><?= $row['nama_pelanggan'] ?: '-' ?></h3>
            <small>🚌 <?= $row['nama_bus'] ?></small>
        </div>

        <?php if ($row['status_pengembalian'] == 'belum'): ?>
            <span class="badge bg-kuning">Belum Dikembalikan</span>
        <?php else: ?>
            <span class="badge bg-hijau">Selesai</span>
        <?php endif; ?>
    </div>

    <!-- BODY -->
    <div class="transaction-body">
        <p><b>📅 Tgl Sewa:</b> <?= $row['tanggal_sewa'] ?></p>
        <p><b>📅 Tgl Kembali:</b> <?= $row['tanggal_kembali'] ?: '-' ?></p>
        <p><b>💸 Denda:</b> Rp <?= number_format($row['denda'] ?? 0) ?></p>
    </div>

    <!-- ACTION -->
    <div class="transaction-action">
        <?php if ($row['status_pengembalian'] == 'belum'): ?>
            <a href="index.php?page=kembalikan&id=<?= $row['id'] ?>"
               class="btn btn-warning"
               onclick="return confirm('Proses pengembalian & hitung denda?')">
               🔄 Proses Pengembalian
            </a>
        <?php else: ?>
            <span class="btn btn-selesai">✔ Transaksi Selesai</span>
        <?php endif; ?>
    </div>

</div>

<?php endwhile; ?>
<?php else: ?>

<div class="card" style="text-align:center">
    Tidak ada data transaksi
</div>

<?php endif; ?>

</div>
