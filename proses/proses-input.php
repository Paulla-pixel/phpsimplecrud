<?php 
include_once '../config/class-transaksi.php';
$transaksi = new Transaksi(); 
$dataPelanggan = [
    'nama' => $_POST['nama'],
    'nama_produk' => $_POST['produk'],
    'alamat' => $_POST['alamat'],
    'email' => $_POST['email'],
    'telp' => $_POST['telp'],
];

$input = $transaksi->inputTransaksi($dataPelanggan);

if($input){
    // 💡 PERBAIKAN: Gunakan status yang benar untuk operasi tambah/insert
    header("Location: ../data-list.php?status=addsuccess"); 
} else {
    // 💡 PERBAIKAN: Redirect ke halaman tambah data, bukan edit data
    // karena ID data yang gagal di-input tidak tersedia.
    header("Location: ../data-add.php?status=failed");
}

// Pastikan selalu ada 'exit();' setelah header() untuk menghentikan eksekusi script
exit(); 
?>