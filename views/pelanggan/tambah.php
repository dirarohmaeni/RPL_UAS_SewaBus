<?php
if (isset($_POST['simpan'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);

    $simpan = mysqli_query($conn, "
        INSERT INTO pelanggan (nama, alamat, no_hp)
        VALUES ('$nama', '$alamat', '$no_hp')
    ");

    if ($simpan) {
        echo "<script>
            alert('Pelanggan berhasil ditambahkan');
            window.location='index.php?page=pelanggan';
        </script>";
    } else {
        echo "<script>alert('Gagal menambah pelanggan');</script>";
    }
}
?>

<h2 class="page-title">➕ Tambah Pelanggan</h2>

<div class="card-center">
    <div class="card form-card">

        <form method="POST">
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama" required placeholder="Masukkan nama pelanggan">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="4" required placeholder="Masukkan alamat"></textarea>
            </div>

            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="telp" required placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-actions">
                <button type="submit" name="simpan" class="btn">
                    💾 Simpan
                </button>

                <a href="index.php?page=pelanggan" class="btn btn-hapus">
                    ✖ Batal
                </a>
            </div>
        </form>

    </div>
</div>
