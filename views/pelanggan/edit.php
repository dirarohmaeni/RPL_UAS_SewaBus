<?php
if (!isset($_GET['edit']) || !is_numeric($_GET['edit'])) {
    echo "<div class='card'>ID tidak valid</div>";
    return;
}

$id = (int) $_GET['edit'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    mysqli_query($conn, "
        UPDATE pelanggan SET
            nama   = '$nama',
            no_hp  = '$no_hp',
            alamat = '$alamat'
        WHERE id = $id
    ");

    header("Location: index.php?page=pelanggan");
    exit;
}

$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM pelanggan WHERE id = $id LIMIT 1")
);

if (!$data) {
    echo "<div class='card'>Data pelanggan tidak ditemukan</div>";
    return;
}
?>

<h2 class="page-title">✏️ Edit Data Pelanggan</h2>

<div class="card form-card">
    <form method="post">

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama"
                   value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>

        <div class="form-group">
            <label>No HP</label>
            <input type="text" name="no_hp"
                   value="<?= htmlspecialchars($data['no_hp']) ?>" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" rows="4" required><?= htmlspecialchars($data['alamat']) ?></textarea>
        </div>

        <div class="form-actions">
            <button class="btn">💾 Simpan</button>
            <a href="index.php?page=pelanggan" class="btn btn-kembali">Batal</a>
        </div>

    </form>
</div>
