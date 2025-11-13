
<?php

// Memasukkan file konfigurasi database
include_once 'db-config.php';

class MasterData extends Database {

    // Method untuk mendapatkan daftar program studi
    public function getProduk(){
        $query = "SELECT * FROM tb_produk";
        $result = $this->conn->query($query);
        $produk = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $produk[] = [
                    'id' => $row['kode_produk'],
                    'nama' => $row['nm_produk']
                ];
            }
        }
        return $produk;
    }

    // Method untuk mendapatkan daftar provinsi
    public function getPelanggan(){
        $query = "SELECT * FROM tb_pelanggan";
        $result = $this->conn->query($query);
        $pelanggan = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $pelanggan[] = [
                    'id' => $row['id_pelanggan'],
                    'nama' => $row['nm_pelanggan']
                ];
            }
        }
        return $pelanggan;
    }

    // Method untuk mendapatkan daftar status mahasiswa menggunakan array statis
    public function getStatus(){
        return [
            ['id' => 1, 'nama' => 'Aktif'],
            ['id' => 2, 'nama' => 'Tidak Aktif'],
            ['id' => 3, 'nama' => 'Cuti'],
            ['id' => 4, 'nama' => 'Lulus']
        ];
    }

// Method untuk input data produk
public function inputProduk($data){
    $namaProduk = $data['nama'];
    $kodeProduk = $data['kode'];

    $query = "INSERT INTO tb_produk (kode_produk, nm_produk) VALUES (?, ?)";
    $stmt = $this->conn->prepare($query);
    if(!$stmt){
        return false;
    }

    $stmt->bind_param("ss", $kodeProduk, $namaProduk);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}


    // Method untuk mendapatkan data program studi berdasarkan kode
    public function getUpdateProduk($id){
        $query = "SELECT * FROM tb_produk WHERE kode_produk = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $produk = null;
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $produk = [
                'id' => $row['kode_produk'],
                'nama' => $row['nm_produk']
            ];
        }
        $stmt->close();
        return $produk;
    }

    // Method untuk mengedit data program studi
    public function updateProduk($data){
        $kodeProduk = $data['kode'];
        $namaProduk = $data['nama'];
        $query = "UPDATE tb_produk SET nm_produk = ? WHERE kode_produk = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("ss", $namaProduk, $kodeProduk);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk menghapus data program studi
    public function deleteProduk($id){
        $query = "DELETE FROM tb_produk WHERE kode_produk = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk input data provinsi
    public function inputPelanggan($data){
        $namaPelanggan = $data['nama'];
        $query = "INSERT INTO tb_pelanggan (nm_pelanggan) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("s", $namaPelanggan);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk mendapatkan data provinsi berdasarkan id
    public function getUpdatePelanggan($id){
        $query = "SELECT * FROM tb_pelanggan WHERE id_pelanggan = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pelanggan = null;
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $pelanggan = [
                'id' => $row['id_pelanggan'],
                'nama' => $row['nm_pelanggan']
            ];
        }
        $stmt->close();
        return $pelanggan;
    }

    // Method untuk mengedit data 
    public function updatePelanggan($data){
        $idPelanggan= $data['id'];
        $namaPelanggan = $data['nama'];
        $query = "UPDATE tb_pelanggan SET nm_pelanggan = ? WHERE id_pelanggan = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("si", $namaPelanggan, $idPelanggan);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk menghapus data provinsi
    public function deletePelanggan($id){
        $query = "DELETE FROM tb_pelanggan WHERE id_pelanggan = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

}

?>
