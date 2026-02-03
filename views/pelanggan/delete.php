<?php
// ================= CEK ID =================
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='card'>ID tidak valid</div>";
    return;
}

$id = (int) $_GET['id'];

// ================= CEK DATA ADA ATAU TIDAK =================
$cek = mysqli_query($conn, "SELECT id FROM pemesanan WHERE id = $id LIMIT 1");

if (mysqli_num_rows($cek) === 0) {
    echo "<div class='card'>Data pemesanan tidak ditemukan</div>";
    return;
}

// ================= PROSES DELETE =================
$hapus = mysqli_query($conn, "DELETE FROM pemesanan WHERE id = $id");

if ($hapus) {
    echo "
        <script>
            alert('✅ Data pemesanan berhasil dihapus');
            window.location.href = 'index.php?page=pemesanan';
        </script>
    ";
} else {
    echo "
        <script>
            alert('❌ Gagal menghapus data');
            window.history.back();
        </script>
    ";
}
