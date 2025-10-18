<?php


class Lapor {
    private $laporanModel;

    public function __construct(){

        if(!isset($_SESSION)) { 
            session_start(); 
        }


        if(!isset($_SESSION['user_id'])){
            redirect('users/login');
        }
        

        require_once '../app/models/Laporan.php';
        $this->laporanModel = new Laporan();
    }


    public function index(){
        $provinsi = $this->laporanModel->getProvinsi();
        $data = [
            'provinsi' => $provinsi
        ];
        $this->loadView('lapor/index', $data);
    }


    public function lihat(){
        $laporan = $this->laporanModel->getAllLaporan();
        $data = [
            'laporan' => $laporan
        ];
        $this->loadView('lapor/lihat', $data);
    }
    

    public function getKabupaten(){
        if(isset($_POST['id_prov'])){
            $kabupaten = $this->laporanModel->getKabupatenByProvinsi($_POST['id_prov']);

            header('Content-Type: application/json');
            echo json_encode($kabupaten);
        }
    }


    public function tambah(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $namaFileFoto = '';
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
                $target_dir = "uploads/";

                $namaFileFoto = uniqid() . '-' . basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $namaFileFoto;
                

                if(!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)){
                   die('Gagal upload foto.');
                }
            }

            $data = [
                'user_id' => $_SESSION['user_id'],
                'nama_lengkap' => trim($_POST['nama_lengkap']),
                'umur' => trim($_POST['umur']),
                'jenis_kelamin' => trim($_POST['jenis_kelamin']),
                'provinsi_id' => trim($_POST['provinsi']),
                'kabupaten_id' => trim($_POST['kabupaten']),
                'kronologi' => trim($_POST['kronologi']),
                'ciri_ciri' => trim($_POST['ciri_ciri']),
                'tanda_tangan' => $_POST['tanda_tangan'], 
                'foto' => $namaFileFoto
            ];

            if($this->laporanModel->tambahLaporan($data)){
                redirect('lapor/lihat');
            } else {
                die('Terjadi kesalahan saat menyimpan laporan.');
            }

        } else {
            redirect('lapor/index');
        }
    }


    public function loadView($view, $data = []){
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist: ' . $view);
        }
    }






    public function detail($id){

        $laporan = $this->laporanModel->getLaporanById($id);
        
        $data = [
            'laporan' => $laporan
        ];


        $this->loadView('lapor/detail', $data);
    }





    public function hapus($id){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $laporan = $this->laporanModel->getLaporanById($id);


            if($laporan->user_id != $_SESSION['user_id']){

                redirect('lapor/lihat');
            }


            if($this->laporanModel->deleteLaporan($id)){
        
                if(file_exists('uploads/' . $laporan->foto)){
                    unlink('uploads/' . $laporan->foto);
                }

                redirect('lapor/lihat');
            } else {
                die('Gagal menghapus laporan.');
            }

        } else {

            redirect('lapor/lihat');
        }
    }


    public function edit($id){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $laporanLama = $this->laporanModel->getLaporanById($id);
            $namaFoto = $laporanLama->foto;


            if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
                $target_dir = "uploads/";
                $namaFotoBaru = time() . '_' . basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $namaFotoBaru;


                if(file_exists($target_dir . $laporanLama->foto)){
                    unlink($target_dir . $laporanLama->foto);
                }
                

                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                    $namaFoto = $namaFotoBaru;
                }
            }
            
            $data = [
                'id' => $id,
                'nama_lengkap' => trim($_POST['nama_lengkap']),
                'umur' => trim($_POST['umur']),
                'jenis_kelamin' => $_POST['jenis_kelamin'],
                'provinsi_id' => $_POST['provinsi'],
                'kabupaten_id' => $_POST['kabupaten'],
                'kronologi' => trim($_POST['kronologi']),
                'ciri_ciri' => trim($_POST['ciri_ciri']),
                'foto' => $namaFoto,

                'nama_lengkap_err' => '',
                'umur_err' => '',
            ];


            if(empty($data['nama_lengkap'])){ $data['nama_lengkap_err'] = 'Nama lengkap wajib diisi.'; }
            if(empty($data['umur'])){ $data['umur_err'] = 'Umur wajib diisi.'; }


            if(empty($data['nama_lengkap_err']) && empty($data['umur_err'])){
                if($this->laporanModel->updateLaporan($data)){
                    redirect('lapor/detail/' . $id);
                } else {
                    die('Terjadi kesalahan saat mengupdate laporan.');
                }
            } else {

                $this->loadView('lapor/edit', $data);
            }

        } else {



            $laporan = $this->laporanModel->getLaporanById($id);


            if($laporan->user_id != $_SESSION['user_id']){
                redirect('lapor/lihat');
            }
            

            $provinsi = $this->laporanModel->getProvinsi();

            $data = [
                'id' => $id,
                'nama_lengkap' => $laporan->nama_lengkap,
                'umur' => $laporan->umur,
                'jenis_kelamin' => $laporan->jenis_kelamin,
                'provinsi_id' => $laporan->provinsi_id,
                'kabupaten_id' => $laporan->kabupaten_id,
                'kronologi' => $laporan->kronologi,
                'ciri_ciri' => $laporan->ciri_ciri,
                'foto' => $laporan->foto,
                'provinsi' => $provinsi
            ];

            $this->loadView('lapor/edit', $data);
        }
    }
}
