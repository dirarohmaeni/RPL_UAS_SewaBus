<?php
$id = $_GET['id'] ?? 0;
if ($id == 0) {
    header("Location: index.php?page=pemesanan");
    exit;
}

$data = mysqli_query($conn, "
    SELECT * FROM pemesanan WHERE id=$id
");
$p = mysqli_fetch_assoc($data);

if (!$p) {
    echo "Data pemesanan tidak ditemukan";
    exit;
}

// ================= PROSES BAYAR =================
if (isset($_POST['bayar'])) {

    $metode = $_POST['metode'];
    $total_bayar = $p['total_harga'] + $p['denda'];

    mysqli_query($conn, "
        UPDATE pemesanan SET
            metode_pembayaran = '$metode',
            status_pembayaran = 'Lunas',
            total_bayar       = '$total_bayar'
        WHERE id = $id
    ");

    header("Location: index.php?page=pemesanan");
    exit;
}
?>

<h2 class="page-title">💳 Pembayaran</h2>

<form method="POST" class="card" style="max-width:420px">
    <label>Metode Pembayaran</label>
    <select name="metode" required>
        <option value="">-- Pilih Metode --</option>
        <option value="Tunai">Tunai</option>
        <option value="Transfer">Transfer</option>
        <option value="QRIS">QRIS</option>
    </select>

    <br><br>

    <p><b>Total Harga :</b> Rp <?= number_format($p['total_harga']) ?></p>
    <p><b>Denda :</b> Rp <?= number_format($p['denda']) ?></p>
    <p><b>Total Bayar :</b> Rp <?= number_format($p['total_harga'] + $p['denda']) ?></p>

    <br>
    <button type="submit" name="bayar" class="btn btn-login">
        💳 Bayar Sekarang
    </button>
</form>
