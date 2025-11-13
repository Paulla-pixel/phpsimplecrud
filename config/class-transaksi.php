<?php
// BARIS PERBAIKAN: Memastikan class Database (dari db-config.php) terdefinisi
include_once 'db-config.php'; 

// Mengubah nama class dari Mahasiswa menjadi Transaksi
class Transaksi extends Database {

    /**
     * Method untuk input data transaksi
     * Data di-insert ke tb_transaksi
     */
   public function inputTransaksi($data){
    // Ambil data dari parameter $data
    $nm_pelanggan = $data['nama']; 
    $nama_produk = $data['nama_produk']; 
    $alamat = $data['alamat'];
    $email = $data['email'];
    $telp = $data['telp'];
        
        // Menyiapkan query SQL untuk insert data menggunakan prepared statement
    
      $query = "INSERT INTO tb_transaksi (nm_pelanggan, nama_produk, alamat, email, telp) VALUES (?,?,?,?,?)";
    $stmt = $this->conn->prepare($query);
        
        // Mengecek apakah statement berhasil disiapkan
        if(!$stmt){
             // Jika prepare gagal, Anda bisa mendapatkan error database di sini
             // Misalnya: return "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
            return false;
        }
        
{// Memasukkan parameter ke statement: 5 string (s)
        $stmt->bind_param("sssss", $nm_pelanggan, $jenis_produk, $alamat, $email, $telp);
        $result = $stmt->execute();
        $stmt->close();
        
        // Mengembalikan hasil eksekusi query
        return $result;
    }
}

    // [METODE LAINNYA (getAllTransaksi, getUpdateTransaksi, editTransaksi, deleteTransaksi, searchTransaksi) TETAP SAMA KARENA SUDAH BENAR DAN SESUAI DENGAN STRUKTUR SQL TB_TRANSAKSI DAN TB_PRODUK]
    
   public function getAllTransaksi() {
    // Query ambil data transaksi + produk
    $query = "
        SELECT 
            t.id_transaksi,
            t.nm_pelanggan,
            t.alamat,
            t.telp,
            t.email,
            p.nama AS nama_produk
        FROM tb_transaksi t
        LEFT JOIN tb_produk p ON t.jenis_produk = p.kode_produk
    ";

    $stmt = $this->conn->prepare($query);
    if(!$stmt){
        die('Query prepare failed: ' . $this->conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $transaksi = [];
    while($row = $result->fetch_assoc()) {
        $transaksi[] = [
            'id' => $row['id_transaksi'],
            'nm_pelanggan' => $row['nm_pelanggan'],
            'nama_produk' => $row['nama_produk'], 
            'alamat' => $row['alamat'],
            'email' => $row['email'],
            'telp' => $row['telp']
        ];
    }

    $stmt->close();
    return $transaksi;
}

}

    public function getUpdateTransaksi($id){
        $query = "SELECT * FROM tb_transaksi WHERE id_transaksi = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = false;
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $data = [
                'id' => $row['id_transaksi'], 
                'nama' => $row['nm_pelanggan'],
                'jenis' => $row['jenis_produk'],
                'alamat' => $row['alamat'],
                'email' => $row['email'],
                'telp' => $row['telp']
            ];
        }
        $stmt->close();
        return $data;
    }

    public function editTransaksi($data){
        $id = $data['id'];
        $nm_pelanggan = $data['nama'];
        $jenis_produk = $data['jenis']; 
        $alamat = $data['alamat'];
        $email = $data['email'];
        $telp = $data['telp'];
        
        $query = "UPDATE tb_transaksi SET nm_pelanggan = ?, jenis_produk = ?, alamat = ?, email = ?, telp = ? WHERE id_transaksi = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("sssssi", $nm_pelanggan, $jenis_produk, $alamat, $email, $telp, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteTransaksi($id){
        $query = "DELETE FROM tb_transaksi WHERE id_transaksi = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function searchTransaksi($kataKunci){
        $likeQuery = "%".$kataKunci."%";
        
        $query = "SELECT t.id_transaksi, t.nm_pelanggan, nama_produk, t.alamat, t.email, t.telp
                  FROM tb_transaksi t
                  LEFT JOIN tb_produk p ON t.nama_produk = p.kode_produk
                  WHERE t.nm_pelanggan LIKE ? OR t.nama_produk LIKE ? OR nama_produk LIKE ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return [];
        }
        $stmt->bind_param("sss", $likeQuery, $likeQuery, $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $transaksi = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $transaksi[] = [
                    'id' => $row['id_transaksi'],
                    'nm_pelanggan' => $row['nm_pelanggan'],
                    'nama_produk' => $row['nama_produk'],
                    'alamat' => $row['alamat'],
                    'email' => $row['email'],
                    'telp' => $row['telp']
                ];
            }
        }
        $stmt->close();
        return $transaksi;
    }
}
?>