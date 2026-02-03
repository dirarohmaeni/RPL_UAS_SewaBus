<?php
$conn = mysqli_connect("localhost", "root", "", "sewa_bus");

if (!$conn) {
    die("Koneksi database gagal");
}
