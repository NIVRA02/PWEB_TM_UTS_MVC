<?php
// app/models/Laporan.php
require_once '../app/Database.php';

class Laporan {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // Mengambil semua data provinsi
    public function getProvinsi(){
        $this->db->query("SELECT * FROM provinsi ORDER BY nama_prov ASC");
        return $this->db->resultSet();
    }

    // Mengambil data kabupaten berdasarkan ID Provinsi
    public function getKabupatenByProvinsi($id_prov){
        $this->db->query("SELECT * FROM kabupaten WHERE id_prov = :id_prov ORDER BY nama_kab ASC");
        $this->db->bind(':id_prov', $id_prov);
        return $this->db->resultSet();
    }

    // Menyimpan laporan baru ke database
    public function tambahLaporan($data){
        $this->db->query('INSERT INTO laporan_orang_hilang 
            (user_id, nama_lengkap, umur, jenis_kelamin, provinsi_id, kabupaten_id, kronologi, ciri_ciri, foto, tanda_tangan) 
            VALUES (:user_id, :nama_lengkap, :umur, :jenis_kelamin, :provinsi_id, :kabupaten_id, :kronologi, :ciri_ciri, :foto, :tanda_tangan)');

        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':nama_lengkap', $data['nama_lengkap']);
        $this->db->bind(':umur', $data['umur']);
        $this->db->bind(':jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind(':provinsi_id', $data['provinsi_id']);
        $this->db->bind(':kabupaten_id', $data['kabupaten_id']);
        $this->db->bind(':kronologi', $data['kronologi']);
        $this->db->bind(':ciri_ciri', $data['ciri_ciri']);
        $this->db->bind(':foto', $data['foto']);
        $this->db->bind(':tanda_tangan', $data['tanda_tangan']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Mengambil semua laporan yang ada
    public function getAllLaporan(){
        $this->db->query('SELECT laporan_orang_hilang.*, users.name as pelapor, provinsi.nama_prov, kabupaten.nama_kab 
                         FROM laporan_orang_hilang
                         JOIN users ON laporan_orang_hilang.user_id = users.id
                         JOIN provinsi ON laporan_orang_hilang.provinsi_id = provinsi.id_prov
                         JOIN kabupaten ON laporan_orang_hilang.kabupaten_id = kabupaten.id_kab
                         ORDER BY laporan_orang_hilang.tanggal_lapor DESC');
        return $this->db->resultSet();
    }
    // app/models/Laporan.php

// ... (method-method yang sudah ada sebelumnya) ...

// Method baru untuk mengambil satu laporan berdasarkan ID
    public function getLaporanById($id){
        $this->db->query('SELECT laporan_orang_hilang.*, users.name as pelapor, provinsi.nama_prov, kabupaten.nama_kab 
                        FROM laporan_orang_hilang
                        JOIN users ON laporan_orang_hilang.user_id = users.id
                        JOIN provinsi ON laporan_orang_hilang.provinsi_id = provinsi.id_prov
                        JOIN kabupaten ON laporan_orang_hilang.kabupaten_id = kabupaten.id_kab
                        WHERE laporan_orang_hilang.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // app/models/Laporan.php

// ... (method-method yang sudah ada) ...

// Method baru untuk menghapus laporan
    public function deleteLaporan($id){
        $this->db->query('DELETE FROM laporan_orang_hilang WHERE id = :id');
        $this->db->bind(':id', $id);
        
        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // app/models/Laporan.php

// ... (method-method yang sudah ada) ...

// Method baru untuk mengupdate laporan
    public function updateLaporan($data){
        $this->db->query('UPDATE laporan_orang_hilang SET 
                            nama_lengkap = :nama_lengkap, 
                            umur = :umur, 
                            jenis_kelamin = :jenis_kelamin, 
                            provinsi_id = :provinsi_id, 
                            kabupaten_id = :kabupaten_id, 
                            kronologi = :kronologi, 
                            ciri_ciri = :ciri_ciri,
                            foto = :foto 
                            WHERE id = :id');
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':nama_lengkap', $data['nama_lengkap']);
        $this->db->bind(':umur', $data['umur']);
        $this->db->bind(':jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind(':provinsi_id', $data['provinsi_id']);
        $this->db->bind(':kabupaten_id', $data['kabupaten_id']);
        $this->db->bind(':kronologi', $data['kronologi']);
        $this->db->bind(':ciri_ciri', $data['ciri_ciri']);
        $this->db->bind(':foto', $data['foto']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}
