<?php

// Memasukkan file class-mahasiswa.php untuk mengakses class Mahasiswa
include_once '../config/class-transaksi.php';
// Membuat objek dari class Mahasiswa
$transaksi = new Transaksi();
// Mengambil id mahasiswa dari parameter GET
$kode = $_GET['kode'];
// Memanggil method deleteMahasiswa untuk menghapus data mahasiswa berdasarkan id
$delete = $transaksi->deleteTransaksi($kode);
// Mengecek apakah proses delete berhasil atau tidak - true/false
if($delete){
    // Jika berhasil, redirect ke halaman data-list.php dengan status deletesuccess
    header("Location: ../data-list.php?status=deletesuccess");
} else {
    // Jika gagal, redirect ke halaman data-list.php dengan status deletefailed
    header("Location: ../data-list.php?status=deletefailed");
}

?>