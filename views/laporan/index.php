<?php
/* ===============================
   RINGKASAN LAPORAN
================================ */
$ringkasan = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT 
        COUNT(*) AS total_pesanan,
        IFNULL(SUM(total_harga),0) AS total_pendapatan,
        SUM(status = 'selesai') AS selesai,
        SUM(status = 'pending') AS pending
    FROM pemesanan
"));

/* ===============================
   DATA LAPORAN PEMESANAN
================================ */
$data = mysqli_query($conn, "
    SELECT 
        p.id,
        pl.nama AS nama_pelanggan,
        b.nama_bus,
        p.tanggal_sewa,
        p.tanggal_kembali,
        p.total_harga,
        p.status
    FROM pemesanan p
    JOIN pelanggan pl ON p.user_id = pl.id
    JOIN bus b ON p.bus_id = b.id
    ORDER BY p.tanggal_sewa DESC
");
?>

<h2 class="page-title">📊 Laporan Pemesanan</h2>

<!-- ACTION -->
<div class="action-bar">
    <a href="index.php?page=laporan_cetak" target="_blank" class="btn btn-info">🖨️ Cetak Laporan</a>
</div>

<!-- ================= RINGKASAN ================= -->
<div class="card-wrapper">

    <div class="card">
        <h4>Total Pemesanan</h4>
        <p><?= $ringkasan['total_pesanan'] ?></p>
    </div>

    <div class="card">
        <h4>Total Pendapatan</h4>
        <p>Rp <?= number_format($ringkasan['total_pendapatan']) ?></p>
    </div>

    <div class="card">
        <h4>Selesai</h4>
        <p><?= $ringkasan['selesai'] ?></p>
    </div>

    <div class="card">
        <h4>Pending</h4>
        <p><?= $ringkasan['pending'] ?></p>
    </div>

</div>

<!-- ================= TABEL LAPORAN ================= -->
<div class="card">
    <h3>📋 Detail Pemesanan</h3>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Bus</th>
                <th>Tgl Sewa</th>
                <th>Tgl Kembali</th>
                <th>Durasi</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): 
            $durasi = (strtotime($row['tanggal_kembali']) - strtotime($row['tanggal_sewa'])) / 86400;
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_pelanggan'] ?></td>
                <td><?= $row['nama_bus'] ?></td>
                <td><?= $row['tanggal_sewa'] ?></td>
                <td><?= $row['tanggal_kembali'] ?></td>
                <td><?= $durasi ?> Hari</td>
                <td>Rp <?= number_format($row['total_harga']) ?></td>
                <td>
                    <span class="badge <?= $row['status']=='selesai' ? 'bg-hijau' : 'bg-kuning' ?>">
                        <?= ucfirst($row['status']) ?>
                    </span>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
