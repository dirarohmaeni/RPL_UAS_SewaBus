<?php
/* ===============================
   FILTER PERIODE
================================ */
$dari   = $_GET['dari'] ?? '';
$sampai = $_GET['sampai'] ?? '';

$where = '';
if (!empty($dari) && !empty($sampai)) {
    $where = "WHERE p.tanggal_sewa BETWEEN '$dari' AND '$sampai'";
}

/* ===============================
   DATA LAPORAN
================================ */
$data = mysqli_query($conn, "
    SELECT 
        p.id,
        pl.nama AS pelanggan,
        b.nama_bus,
        p.tanggal_sewa,
        p.tanggal_kembali,
        p.status,
        p.denda,
        p.total_harga
    FROM pemesanan p
    LEFT JOIN pelanggan pl ON p.user_id = pl.id
    LEFT JOIN bus b ON p.bus_id = b.id
    $where
    ORDER BY p.tanggal_sewa ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemesanan Bus</title>
    <link rel="stylesheet" href="public/css/print.css">
</head>

<body onload="window.print()">

<!-- ================= HEADER LAPORAN ================= -->
<div class="report-header">
    <h2>SEWA BUS JAYA ABADI</h2>
    <p>Jl. Raya Transport No. 123</p>
    <p>Telp. 0812-xxxx-xxxx</p>

    <hr>

    <h3>LAPORAN PEMESANAN BUS</h3>
</div>

<!-- ================= TABEL DATA ================= -->
<table class="report-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Nama Bus</th>
            <th>Tgl Sewa</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Denda (Rp)</th>
            <th>Total (Rp)</th>
        </tr>
    </thead>

    <tbody>
    <?php
        $no = 1;
        $total_denda = 0;
        $total_pendapatan = 0;
    ?>

    <?php if (mysqli_num_rows($data) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
            <?php
                $total_denda += $row['denda'] ?? 0;
                $total_pendapatan += $row['total_harga'];
            ?>
            <tr>
                <td align="center"><?= $no++ ?></td>
                <td><?= $row['pelanggan'] ?></td>
                <td><?= $row['nama_bus'] ?></td>
                <td align="center"><?= date('d-m-Y', strtotime($row['tanggal_sewa'])) ?></td>
                <td align="center">
                    <?= $row['tanggal_kembali']
                        ? date('d-m-Y', strtotime($row['tanggal_kembali']))
                        : '-' ?>
                </td>
                <td align="center"><?= ucfirst($row['status']) ?></td>
                <td align="right"><?= number_format($row['denda'] ?? 0) ?></td>
                <td align="right"><?= number_format($row['total_harga']) ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" align="center">
                Data pemesanan tidak tersedia
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<!-- ================= TOTAL ================= -->
<table class="report-total">
    <tr>
        <td align="right"><b>Total Denda</b></td>
        <td align="right" width="180">
            Rp <?= number_format($total_denda) ?>
        </td>
    </tr>
    <tr>
        <td align="right"><b>Total Pendapatan</b></td>
        <td align="right">
            Rp <?= number_format($total_pendapatan) ?>
        </td>
    </tr>
</table>

<!-- ================= TANDA TANGAN ================= -->
<div class="report-footer">
    <div class="ttd">
        <p><?= date('d F Y') ?></p>
        <p>Pimpinan</p>

        <br><br><br>

        <p><b>( Budi Santoso )</b></p>
    </div>
</div>

</body>
</html>
