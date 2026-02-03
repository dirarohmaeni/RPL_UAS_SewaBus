<?php
// ================= AMBIL ID =================
$id = $_GET['id'] ?? 0;
if ($id == 0) {
    header("Location: index.php?page=bus");
    exit;
}

// ================= AMBIL DATA BUS =================
$q = mysqli_query($conn, "SELECT * FROM bus WHERE id=$id");
$bus = mysqli_fetch_assoc($q);

if (!$bus) {
    echo "Data bus tidak ditemukan";
    exit;
}

// ================= UPDATE DATA =================
if (isset($_POST['update'])) {

    $nama_bus  = $_POST['nama_bus'];
    $plat      = $_POST['plat'];
    $kapasitas = $_POST['kapasitas'];
    $harga     = $_POST['harga'];
    $status    = $_POST['status'];

    // JIKA ADA FOTO BARU
    if (!empty($_FILES['foto']['name'])) {

        $foto = time() . '_' . $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];

        move_uploaded_file(
            $tmp,
            __DIR__ . "/../../public/images/" . $foto
        );

        mysqli_query($conn, "
            UPDATE bus SET
                nama_bus='$nama_bus',
                plat='$plat',
                kapasitas='$kapasitas',
                harga='$harga',
                status='$status',
                gambar='$foto'
            WHERE id=$id
        ");

    } else {

        // TANPA GANTI FOTO
        mysqli_query($conn, "
            UPDATE bus SET
                nama_bus='$nama_bus',
                plat='$plat',
                kapasitas='$kapasitas',
                harga='$harga',
                status='$status'
            WHERE id=$id
        ");
    }

    header("Location: index.php?page=bus");
    exit;
}
?>

<h2 class="page-title">✏️ Edit Data Bus</h2>

<div class="card">
<form method="POST" enctype="multipart/form-data">

    <label>Nama Bus</label>
    <input type="text" name="nama_bus" value="<?= htmlspecialchars($bus['nama_bus']) ?>" required>

    <label>Plat Nomor</label>
    <input type="text" name="plat" value="<?= htmlspecialchars($bus['plat']) ?>" required>

    <label>Kapasitas</label>
    <input type="number" name="kapasitas" value="<?= $bus['kapasitas'] ?>" required>

    <label>Harga Sewa</label>
    <input type="number" name="harga" value="<?= $bus['harga'] ?>" required>

    <label>Status</label>
    <select name="status">
        <option value="tersedia" <?= $bus['status']=='tersedia'?'selected':'' ?>>Tersedia</option>
        <option value="dipinjam" <?= $bus['status']=='dipinjam'?'selected':'' ?>>Dipinjam</option>
    </select>

    <label>Foto Bus</label><br>

    <?php if (!empty($bus['foto'])): ?>
        <img src="public/images/<?= $bus['gambar'] ?>"
             width="120"
             style="margin:6px 0;border-radius:6px;">
    <?php else: ?>
        <small>(Belum ada foto)</small>
    <?php endif; ?>

    <input type="file" name="foto" accept="image/*">

    <div class="action-bar" style="margin-top:15px;">
        <button type="submit" name="update" class="btn btn-edit">
            💾 Simpan
        </button>
        <a href="index.php?page=bus" class="btn btn-info">
            ↩️ Kembali
        </a>
    </div>

</form>
</div>
