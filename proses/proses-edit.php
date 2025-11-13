<?php

// Memasukkan file class-transaksi.php untuk mengakses class Mahtransaksiasiswa
include_once '../config/class-transaksi.php';
// Membuat objek dari class Mahasiswa
$transaksi = new Transaksi();
// Mengambil data mahasiswa dari form edit menggunakan metode POST dan menyimpannya dalam array
$dataTransaksi = [
    'id' => $_POST['id'],
    'nama' => $_POST['nama'],
    'produk' => $_POST['jenis produk'],
    'alamat' => $_POST['alamat'],
    'email' => $_POST['email'],
    'telp' => $_POST['telp'],
    'status' => $_POST['status']
];
// Memanggil method editMahasiswa untuk mengupdate data mahasiswa dengan parameter array $dataMahasiswa
$edit = $transaksi->editTransaksi($dataTransaksi);
// Mengecek apakah proses edit berhasil atau tidak - true/false
if($edit){
    // Jika berhasil, redirect ke halaman data-list.php dengan status editsuccess
    header("Location: ../data-list.php?status=editsuccess");
} else {
    // Jika gagal, redirect ke halaman data-edit.php dengan status failed dan membawa id mahasiswa
    header("Location: ../data-edit.php?id=".$dataTransaksi['id']."&status=failed");
}

?>