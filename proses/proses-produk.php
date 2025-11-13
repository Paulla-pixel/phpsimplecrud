<?php

// Memasukkan file class-master.php untuk mengakses class MasterData
include '../config/class-master.php';
// Membuat objek dari class MasterData
$master = new MasterData();
// Mengecek aksi yang dilakukan berdasarkan parameter GET 'aksi'
if($_GET['aksi'] == 'inputproduk'){
    // Mengambil data prodi dari form input menggunakan metode POST dan menyimpannya dalam array
    $kode = $_POST['kode']; 
    $nama = $_POST['nama']; 
// ...
$data = [
    'kode' => $kode,
    'nama' => $nama
];
    // Memanggil method inputProdi untuk memasukkan data  dengan parameter array $dataProdi
   $input = $master->inputProduk($data);

    if($input){
        // Jika berhasil, redirect ke halaman master-prodi-list.php dengan status inputsuccess
        header("Location: ../master-produk-list.php?status=inputsuccess");
    } else {
        // Jika gagal, redirect ke halaman master-prodi-input.php dengan status failed
        header("Location: ../master-produk-input.php?status=failed");
    }
} elseif($_GET['aksi'] == 'updateproduk'){
    // Mengambil data prodi dari form edit menggunakan metode POST dan menyimpannya dalam array
    $dataProduk = [
        
        'nama' => $_POST['nama']
    ];
    // Memanggil method updateProdi untuk mengupdate data prodi dengan parameter array $dataProdi
    $update = $master->updateProduk($dataProduk);
    if($update){
        // Jika berhasil, redirect ke halaman master-prodi-list.php dengan status editsuccess
        header("Location: ../master-produk-list.php?status=editsuccess");
    } else {
        // Jika gagal, redirect ke halaman master-prodi-edit.php dengan status failed dan membawa id prodi
        header("Location: ../master-produk-edit.php?id=".$dataProduk['id']."&status=failed");
    }
} elseif($_GET['aksi'] == 'deleteproduk'){
    // Mengambil id prodi dari parameter GET
    $id = $_GET['id'];
    // Memanggil method deleteProdi untuk menghapus data  berdasarkan id
    $delete = $master->deleteProduk($id);
    if($delete){
        // Jika berhasil, redirect ke halaman master-prodi-list.php dengan status deletesuccess
        header("Location: ../master-produk-list.php?status=deletesuccess");
    } else {
        // Jika gagal, redirect ke halaman master-prodi-list.php dengan status deletefailed
        header("Location: ../master-produk-list.php?status=deletefailed");
    }
}

?>