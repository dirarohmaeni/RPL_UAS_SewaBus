<?php
// ================= VALIDASI ID =================
if (!isset($_GET['detail']) || !is_numeric($_GET['detail'])) {
    echo "<div class='card'>ID tidak valid</div>";
    return;
}

$id = (int) $_GET['detail'];

// ================= QUERY AMAN =================
$query = mysqli_query($conn, "
    SELECT 
        p.*,
        pl.nama AS pelanggan,
        pl.no_hp,
        b.nama_bus,
        b.plat
    FROM pemesanan p
    JOIN pelanggan pl ON p.user_id = pl.id
    JOIN bus b ON p.bus_id = b.id
    WHERE p.id = $id
    LIMIT 1
");

$data = mysqli_fetch_assoc($query);

// ================= CEK DATA =================
if (!$data) {
    echo "<div class='card'>Data pemesanan tidak ditemukan</div>";
    return;
}
?>

<h2 class="page-title">📄 Detail Pemesanan</h2>

<div class="card-wrapper">

    <!-- CARD PELANGGAN -->
    <div class="card">
        <h4>👤 Data Pelanggan</h4>
        <p><b>Nama:</b><br><?= htmlspecialchars($data['pelanggan']) ?></p>
        <p><b>No HP:</b><br><?= htmlspecialchars($data['no_hp']) ?></p>
    </div>

    <!-- CARD BUS -->
    <div class="card">
        <h4>🚌 Data Bus</h4>
        <p><b>Bus:</b><br><?= htmlspecialchars($data['nama_bus']) ?></p>
        <p><b>Plat:</b><br><?= htmlspecialchars($data['plat']) ?></p>
    </div>

    <!-- CARD PEMESANAN -->
    <div class="card">
        <h4>📅 Data Pemesanan</h4>
        <p><b>Tanggal Sewa:</b><br><?= $data['tanggal_sewa'] ?></p>
        <p><b>Tanggal Kembali:</b><br><?= $data['tanggal_kembali'] ?></p>
        <p><b>Total Harga:</b><br>Rp <?= number_format($data['total_harga']) ?></p>
        <p>
            <b>Status:</b><br>
            <span class="badge <?= $data['status']=='pending' ? 'bg-kuning' : 'bg-hijau' ?>">
                <?= ucfirst($data['status']) ?>
            </span>
        </p>
    </div>

</div>

<div class="action-bar">
    <a href="index.php?page=pemesanan" class="btn btn-kembali">
        ← Kembali
    </a>
</div>
