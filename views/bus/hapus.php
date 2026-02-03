<?php
// AMANKAN SESSION
if (!isset($_SESSION['login'])) {
    header("Location: index.php?page=login");
    exit;
}

// AMBIL ID
$id = $_GET['id'] ?? 0;
if ($id == 0) {
    header("Location: index.php?page=bus");
    exit;
}

// HAPUS DATA
mysqli_query($conn, "DELETE FROM bus WHERE id = $id");

// KEMBALI KE DATA BUS
header("Location: index.php?page=bus");
exit;
