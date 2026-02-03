<?php
$q = $_GET['q'] ?? '';

$data = mysqli_query($conn, "
    SELECT * FROM bus
    WHERE nama_bus LIKE '%$q%' 
       OR plat LIKE '%$q%'
    ORDER BY id DESC
");

$jmlBus = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM bus")
)['total'];

$busTersedia = mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT COUNT(*) AS total 
        FROM bus 
        WHERE LOWER(TRIM(status))='tersedia'
    ")
)['total'];
?>

<h2 class="page-title">🚌 Data Bus</h2>

<!-- INFO CARD -->
<div class="card-wrapper small">
    <div class="card">
        <h4>Total Bus</h4>
        <h2><?= $jmlBus ?></h2>
    </div>
    <div class="card">
        <h4>Stok Tersedia</h4>
        <h2><?= $busTersedia ?></h2>
    </div>
</div>

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
        <a href="index.php?page=bus_tambah" class="btn btn-tambah">➕ Tambah Bus</a>
    </div>

<!-- GRID BUS -->
<div class="bus-grid">

<?php while($row = mysqli_fetch_assoc($data)): ?>
<?php
    $status = strtolower(trim($row['status']));
    $foto = str_replace(' ', '_', $row['nama_bus']) . '.jpg';
    $path = "public/images/" . $foto;
    if (!file_exists($path)) $path = "public/images/default.jpg";
?>

<div class="bus-card">

    <div class="bus-image">
        <img src="<?= $path ?>" alt="<?= $row['nama_bus'] ?>">
        <span class="bus-status <?= $status ?>">
            <?= ucfirst($status) ?>
        </span>
    </div>

    <div class="bus-body">
        <h3><?= $row['nama_bus'] ?></h3>
        <p class="bus-plat">🚐 <?= $row['plat'] ?></p>

        <div class="bus-info">
            <span>👥 <?= $row['kapasitas'] ?> Orang</span>
            <span>💰 Rp <?= number_format($row['harga']) ?></span>
        </div>

        <div class="bus-action">
            <a href="index.php?page=bus_edit&id=<?= $row['id'] ?>" class="btn btn-edit">✏️ Edit</a>
            <a href="index.php?page=bus_hapus&id=<?= $row['id'] ?>"
               onclick="return confirm('Hapus bus ini?')"
               class="btn btn-hapus">🗑️</a>
        </div>
    </div>

</div>

<?php endwhile; ?>

<?php if(mysqli_num_rows($data) == 0): ?>
    <div class="card" style="text-align:center">
        Data bus tidak ditemukan
    </div>
<?php endif; ?>

</div>
