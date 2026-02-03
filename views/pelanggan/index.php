<?php
// ================== HAPUS ==================
if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM pelanggan WHERE id=".$_GET['hapus']);
    header("Location: index.php?page=pelanggan");
    exit;
}

// ================== SEARCH ==================
$q = $_GET['q'] ?? '';

// ================== PAGINATION ==================
$limit = 10;
$hal = $_GET['hal'] ?? 1;
$start = ($hal - 1) * $limit;

// ================== DATA ==================
$data = mysqli_query($conn, "
    SELECT * FROM pelanggan
    WHERE nama LIKE '%$q%' OR no_hp LIKE '%$q%'
    ORDER BY id DESC
    LIMIT $start, $limit
");

// ================== TOTAL DATA ==================
$total = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM pelanggan
    WHERE nama LIKE '%$q%' OR no_hp LIKE '%$q%'
");
$totalData = mysqli_fetch_assoc($total)['total'];
$totalHal = ceil($totalData / $limit);
?>

<div class="main">
    <h2>👤 Data Pelanggan</h2>

    <!-- SEARCH -->
    <form method="GET" class="action-bar">
        <input type="hidden" name="page" value="pelanggan">

        <input type="text"
               name="q"
               placeholder="Cari nama / no HP..."
               value="<?= htmlspecialchars($q) ?>"
               style="max-width:260px">

        <button class="btn">🔍 Cari</button>
    </form>

    <!-- ACTION -->
    <div class="action-bar">
        <a href="index.php?page=pelanggan&tambah=1" class="btn btn-tambah">➕ Tambah Pelanggan</a>
    </div>

    <!-- TABLE -->
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php $no = $start + 1; while($p = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $p['nama'] ?></td>
            <td><?= $p['no_hp'] ?></td>
            <td><?= $p['alamat'] ?></td>
            <td>
                <a href="index.php?page=pelanggan&edit=<?= $p['id'] ?>" class="btn btn-edit">✏️</a>
                <a href="index.php?page=pelanggan&hapus=<?= $p['id'] ?>"
                   onclick="return confirm('Yakin ingin menghapus pelanggan ini?')"
                   class="btn btn-hapus">🗑</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
