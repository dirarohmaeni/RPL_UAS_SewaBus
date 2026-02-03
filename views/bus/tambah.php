<?php
if (isset($_POST['simpan'])) {

    // ambil data
    $nama_bus  = $_POST['nama_bus'];
    $plat      = $_POST['plat'];
    $kapasitas = $_POST['kapasitas'];
    $harga     = $_POST['harga'];

    // ===== FOTO =====
    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];

    // ubah spasi jadi _
    $foto_baru = str_replace(' ', '_', $foto);

    // pindahkan ke folder public/images
    move_uploaded_file($tmp, "public/images/" . $foto_baru);

    // simpan ke database
    mysqli_query($conn, "
        INSERT INTO bus (nama_bus, plat, kapasitas, harga, status, foto)
        VALUES (
            '$nama_bus',
            '$plat',
            '$kapasitas',
            '$harga',
            'tersedia',
            '$foto_baru'
        )
    ");

    header("Location: index.php?page=bus");
    exit;
}
?>

<h2>➕ Tambah Bus</h2>

<form method="post">
    <label>Nama Bus</label>
    <input type="text" name="nama_bus" required>

    <label>Plat Nomor</label>
    <input type="text" name="plat" required>

    <label>Kapasitas</label>
    <input type="number" name="kapasitas" required>

    <label>Harga Sewa</label>
    <input type="number" name="harga" required>

    <div class="action-bar">
        <button type="submit" name="simpan" class="btn btn-simpan">💾 Simpan</button>
        <a href="index.php?page=bus" class="btn btn-batal">✖ Batal</a>
    </div>
</form>
