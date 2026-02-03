<?php
session_start();
require_once "config/database.php";

$page = $_GET['page'] ?? '';

if (!isset($_SESSION['login']) && !in_array($page, ['login', 'logout'])) {
    header("Location: index.php?page=login");
    exit;
}

// ================= LOGIN PAGE =================
if ($page == 'login') {
    include "views/auth/login.php";
    exit;
}

/* =================
   HALAMAN TANPA LAYOUT
================== */
$tanpa_layout = ['laporan_cetak'];

if (!in_array($page, $tanpa_layout)) {
    include "views/layout/header.php";
}

switch ($page) {

    case 'dashboard':
        include "views/dashboard/index.php";
        break;

    case 'bus':
        include "views/bus/index.php";
        break;

    case 'bus_edit':
        include "views/bus/edit.php";
        break;

    case 'bus_tambah':
        include "views/bus/tambah.php";
        break;

    case 'bus_hapus':
        include "views/bus/hapus.php";
        break;    

    case 'pelanggan':
        if (isset($_GET['tambah'])) {
            include "views/pelanggan/tambah.php";
        } elseif (isset($_GET['edit'])) {
            include "views/pelanggan/edit.php";
        } else {
            include "views/pelanggan/index.php";
        }
        break;
        
    case 'pemesanan':
        if (isset($_GET['tambah'])) {
            include "views/pemesanan/tambah.php";
        } elseif (isset($_GET['detail'])) {
            include "views/pemesanan/detail.php";
        } elseif (isset($_GET['hapus'])) {
            include "views/pemesanan/delete.php";
        } else {
            include "views/pemesanan/index.php";
        } 
        break;    

    case 'transaksi':
        include "views/transaksi/index.php";
        break;

    case 'kembalikan':
        include "views/transaksi/kembalikan.php";
        break;
    
    case 'laporan':
        include "views/laporan/index.php";
        break;

    case 'laporan_cetak':
        include "views/laporan/cetak.php";
        break;    

    case 'pembayaran':
        include "views/pemesanan/pembayaran.php";
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php?page=login");
        exit;

    default:
        include "views/dashboard/index.php";
}

if (!in_array($page, $tanpa_layout)) {
    include "views/layout/footer.php";
}
