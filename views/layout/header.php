<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sewa Bus | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>

<div class="dashboard">

    <?php include "views/layout/sidebar.php"; ?>

    <div class="main">

        <div class="top-header">
            <div>
                <h1>Sistem Sewa Bus</h1>
                <p>Manajemen Bus, Pelanggan & Transaksi</p>
            </div>

            <div class="user-box">
                <span class="user-avatar">👤</span>
                <span><?= $_SESSION['nama'] ?? 'Admin' ?></span>
            </div>
        </div>
