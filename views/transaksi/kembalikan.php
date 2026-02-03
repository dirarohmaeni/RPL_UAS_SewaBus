<?php
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<script>alert('ID transaksi tidak valid');location.href='index.php?page=transaksi';</script>";
    exit;
}

/* ===============================
   AMBIL DATA PEMESANAN
================================ */
$q = mysqli_query($conn, "
    SELECT 
        p.*, 
        b.id AS bus_id,
        b.harga
    FROM pemesanan p
    JOIN bus b ON p.bus_id = b.id
    WHERE p.id = '$id'
");

$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "<script>alert('Data pemesanan tidak ditemukan');location.href='index.php?page=transaksi';</script>";
    exit;
}

/* ===============================
   HITUNG DENDA
================================ */
$tgl_kembali_seharusnya = strtotime($data['tanggal_kembali']);
$hari_ini = strtotime(date('Y-m-d'));

$denda = 0;
if ($hari_ini > $tgl_kembali_seharusnya) {
    $terlambat = ($hari_ini - $tgl_kembali_seharusnya) / 86400;
    $denda = ceil($terlambat) * 50000; // 50rb per hari
}

/* ===============================
   PROSES SIMPAN
================================ */
if (isset($_POST['simpan'])) {

    // update pemesanan
    mysqli_query($conn, "
        UPDATE pemesanan SET
            status = 'selesai',
            status_pengembalian = 'selesai',
            denda = '$denda'
        WHERE id = '$id'
    ");

    // update bus
    mysqli_query($conn, "
        UPDATE bus SET status = 'tersedia'
        WHERE id = '{$data['bus_id']}'
    ");

    header("Location: index.php?page=transaksi");
    exit;
}
?>

<h2 class="page-title">🔄 Pengembalian Bus</h2>

<div class="card">
    <p><b>Bus:</b> <?= $data['bus_id'] ?></p>
    <p><b>Tanggal Kembali Seharusnya:</b> <?= $data['tanggal_kembali'] ?></p>
    <p><b>Denda:</b> Rp <?= number_format($denda) ?></p>

    <form method="post">
        <button type="submit" name="simpan" class="btn btn-warning">
            ✔ Proses Pengembalian
        </button>
        <a href="index.php?page=transaksi" class="btn">
            Batal
        </a>
    </form>
</div>
