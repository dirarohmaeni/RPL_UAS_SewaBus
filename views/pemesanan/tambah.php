<?php
$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
$bus = mysqli_query($conn, "SELECT * FROM bus");

// SIMPAN PEMESANAN
if (isset($_POST['simpan'])) {

    $user_id            = $_POST['user_id'];
    $bus_id             = $_POST['bus_id'];
    $tanggal_sewa       = $_POST['tanggal_sewa'];
    $tanggal_kembali    = $_POST['tanggal_kembali'];
    $total_harga        = $_POST['total_harga'];
    $metode_pembayaran  = $_POST['metode_pembayaran'];

    // default
    $total_bayar        = 0;
    $status             = 'dipinjam';
    $status_pembayaran  = 'Belum Dibayar';

    mysqli_query($conn, "
        INSERT INTO pemesanan (
            user_id,
            bus_id,
            tanggal_sewa,
            tanggal_kembali,
            total_bayar,
            total_harga,
            metode_pembayaran,
            status_pembayaran,
            status
        ) VALUES (
            '$user_id',
            '$bus_id',
            '$tanggal_sewa',
            '$tanggal_kembali',
            '$total_bayar',
            '$total_harga',
            '$metode_pembayaran',
            '$status_pembayaran',
            '$status'
        )
    ");

    header("Location: index.php?page=pemesanan");
    exit;
}
?>

<h2>📦 Tambah Pemesanan</h2>

<form method="post">

    <label>Pelanggan</label><br>
    <select name="user_id" required>
        <option value="">-- Pilih Pelanggan --</option>
        <?php while ($p = mysqli_fetch_assoc($pelanggan)): ?>
            <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Bus</label><br>
    <select name="bus_id" required>
        <option value="">-- Pilih Bus --</option>
        <?php while ($b = mysqli_fetch_assoc($bus)): ?>
            <option value="<?= $b['id'] ?>"><?= $b['nama_bus'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Tanggal Sewa</label><br>
    <input type="date" name="tanggal_sewa" required><br><br>

    <label>Tanggal Kembali</label><br>
    <input type="date" name="tanggal_kembali" required><br><br>

    <label>Total Harga</label><br>
    <input type="number" name="total_harga" required><br><br>

    <label>Metode Pembayaran</label><br>
    <select name="metode_pembayaran" required>
        <option value="">-- Pilih Metode Pembayaran --</option>
        <option value="Transfer Bank">Transfer Bank</option>
        <option value="E-Wallet">E-Wallet</option>
        <option value="Tunai">Tunai</option>
    </select><br><br>

    <div class="action-bar">
        <button type="submit" name="simpan" class="btn btn-simpan">
            💾 Simpan
        </button>

        <a href="index.php?page=pemesanan" class="btn btn-batal">
            ✖ Batal
        </a>
    </div>
</form>
