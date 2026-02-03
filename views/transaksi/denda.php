<?php
function hitungDenda($tanggal_kembali, $tarif_per_hari = 500000) {

    $hari_ini = date('Y-m-d');

    if ($hari_ini <= $tanggal_kembali) {
        return 0;
    }

    $tgl_kembali = new DateTime($tanggal_kembali);
    $tgl_sekarang = new DateTime($hari_ini);

    $selisih = $tgl_kembali->diff($tgl_sekarang)->days;

    $denda = $selisih * $tarif_per_hari;

    return $denda;
}
