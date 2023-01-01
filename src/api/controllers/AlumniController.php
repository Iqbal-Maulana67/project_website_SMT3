<?php

    require '../AlumniAPI.php';

    $alumniController = new AlumniAPIController();

    if(isset($_POST['update_status'])){
        echo $alumniController->updateStatus();
    }

    if(isset($_POST['update_password'])){
        echo $alumniController->updatePassword();
    }
    
    if(isset($_POST['update_profile'])){
        echo $alumniController->updateDataDiri();
    }

    if(isset($_POST['submit_registration'])){
        echo $alumniController->insertDataRegistration();
    }
    
    if(isset($_POST['submit_login'])){
        $data = $alumniController->loginCheck();
        echo $data;
    }

    if(isset($_GET['nisn'])){
        echo $alumniController->getSpesificData();
    }

    class AlumniAPIController {
        private $alumniAPI;
        public function __construct()
        {
            session_start();
            $alumniAPI = new AlumniAPI();
            $this->alumniAPI = $alumniAPI;
        }
    
        public function getIndex(){
            $listdata = $this->alumniAPI->getAllData();
            $data = [];
            
            if ($listdata->num_rows > 0) {
                while($row = $listdata->fetch_assoc()){ 
                    $data[] = $row;
                }
            }else{
                $data = "None Result";
            }
            return json_encode(array('data' => $data));
        }
    
        public function getSpesificData(){
            $listdata = $this->alumniAPI->getSpecData($_GET['nisn']);
            $data = [];
    
            if ($listdata->num_rows > 0){
                while($row = $listdata->fetch_assoc()){
                    $data[] = $row;
                }
            }else{
                $data = "None Result";
            }
            return json_encode(array('data' => $data));
        }

        public function insertDataRegistration(){
            $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');

            $nisn = $_POST['nisn'];
            $nama_alumni = $_POST['nama_alumni'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $nomer_hp = $_POST['nomer_hp'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            $sql = "SELECT * FROM siswa_aktif WHERE nisn ='$nisn'";
            $result = mysqli_query($koneksi, $sql);
            try{
                $row = $result->fetch_array();
                if(isset($row)){
                    if($row['status'] == 'ALUMNI'){
                        $sql = "INSERT INTO siswa_alumni (nisn, nama, jenis_kelamin, nomer_hp, password) VALUES ('$nisn', '$nama_alumni', '$jenis_kelamin', '$nomer_hp', '$password')";
                        $this->alumniAPI->rawQuery($sql);
    
                        $sql = "DELETE FROM siswa_aktif WHERE nisn = '$nisn'";
                        $this->alumniAPI->rawQuery($sql);
                        
                        http_response_code(200);
                        return json_encode(array('code' => 200, 'message' => 'Akun berhasil dibuat, silahkan login!', 'data' => $row));
                    }else{
                        http_response_code(400);
                        return json_encode(array('code' => 400, 'message' => 'Siswa belum berstatus alumni'));
                    }
                }else{
                    http_response_code(401);
                    return json_encode(array('code' => 401, 'message' => 'NISN tidak ditemukan'));
                }
            }catch(Exception $e){
                return json_encode(array('code' => 401, 'message' => $e->getMessage()));
            }
        }

        public function updateDataDiri(){
            $nisn = $_POST['nisn'];
            $nama_alumni = $_POST['nama_alumni'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $alamat = $_POST['alamat'];
            $tahun_lulus = $_POST['tahun_lulus'];
            $nomer_hp = $_POST['nomer_hp'];

            $sql = "UPDATE siswa_alumni SET nama='$nama_alumni', jenis_kelamin='$jenis_kelamin', alamat='$alamat', tahun_lulusan='$tahun_lulus', nomer_hp='$nomer_hp' WHERE nisn='$nisn'";
            try {
                $this->alumniAPI->rawQuery($sql);
                return json_encode(array('code' => 200, 'message' => 'Berhasi!'));
            } catch (Exception $e) {
                http_response_code(400);
                return json_encode(array('code' => 400, 'message' => $e->getMessage()));
            }
        }

        public function updatePassword(){
            $nisn = $_POST['nisn'];
            $password_lama = $_POST['password_lama'];
            $password_baru = $_POST['password_baru'];
            $password_baru_confirm = $_POST['password_baru_confirm'];

            $listdata = $this->alumniAPI->getSpecData($nisn);
            
            $row = $listdata->fetch_array();
            if($row['password'] == $password_lama){
                if($password_baru == $password_baru_confirm){
                    $sql = "UPDATE siswa_alumni SET `password`='$password_baru' WHERE nisn = '$nisn'";
                    $this->alumniAPI->rawQuery($sql);
                    return json_encode(array('code' => 200, 'message' => 'Password berhasil diganti!'));
                }else {
                    http_response_code(401);
                    return json_encode(array('code' => 401, 'message' => 'Password baru tidak sama dengan konfirmasi!'));
                }
            }else {
                http_response_code(400);
                return json_encode(array('code' => 400, 'message' => 'Password lama tidak sama!'));
            }
        }

        public function updateStatus(){
            $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');
            
            $nisn = $_POST['nisn'];
            $status_alumni = $_POST['status_alumni'];
            $nama_instansi = $_POST['nama_instansi'];

            $sql = "SELECT * FROM validasi_status_alumni WHERE nisn = '$nisn'";
            $result = mysqli_query($koneksi, $sql);
            $row = $result->fetch_array();
            
            if(isset($row['nisn'])){
                if(isset($_FILES['img_pendukung'])){
                    $ext_file = pathinfo($_FILES['img_pendukung']['name'], PATHINFO_EXTENSION);
                    $nama_file_baru = 'validasi_status_images_'.$nisn.'.'.$ext_file;
        
                    if(is_file('../img/validasi_status_images/'.$nama_file_baru)) unlink('../img/validasi_status_images/'.$nama_file_baru);
        
                    $tmp_file = $_FILES['img_pendukung']['tmp_name'];   
        
                    if($ext_file == "jpg" || $ext_file == "jpeg" || $ext_file == "png"){
                        $sql = "UPDATE validasi_status_alumni SET status_alumni = '$status_alumni', nama_instansi = '$nama_instansi', img_pendukung = '$nama_file_baru'";
                        $this->alumniAPI->rawQuery($sql);
                        move_uploaded_file($tmp_file, '../../../img/validasi_status_images/'.$nama_file_baru);
                        return json_encode(array('code' => 200, 'message' => 'Berhasil memperbarui permintaan validasi, silahkan ditunggu!'));
                    }
                }else{
                    http_response_code(400);
                    return json_encode(array('code' => 400, 'message' => 'Sertakan foto pendukung validasi!'));
                }    
            }else{
                if(isset($_FILES['img_pendukung'])){
                    $ext_file = pathinfo($_FILES['img_pendukung']['name'], PATHINFO_EXTENSION);
                    $nama_file_baru = 'validasi_status_images_'.$nisn.'.'.$ext_file;
        
                    if(is_file('../img/validasi_status_images/'.$nama_file_baru)) unlink('../img/validasi_status_images/'.$nama_file_baru);
        
                    $tmp_file = $_FILES['img_pendukung']['tmp_name'];   
        
                    if($ext_file == "jpg" || $ext_file == "jpeg" || $ext_file == "png"){
                        $sql = "INSERT INTO validasi_status_alumni VALUES ('$nisn', '$status_alumni', '$nama_instansi', '$nama_file_baru')";
                        $this->alumniAPI->rawQuery($sql);
                        move_uploaded_file($tmp_file, '../../../img/validasi_status_images/'.$nama_file_baru);
                        return json_encode(array('code' => 200, 'message' => 'Berhasil melakukan permintaan validasi, silahkan ditunggu!'));
                    }
                }else{
                    http_response_code(400);
                    return json_encode(array('code' => 400, 'message' => 'Sertakan foto pendukung validasi!'));
                }
            }
            
        }

        public function loginCheck(){
            $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');

            $nisn = $_POST['nisn'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM siswa_alumni WHERE nisn='$nisn' AND password='$password'";
            $result = mysqli_query($koneksi, $sql);
            $row = $result->fetch_assoc();
            if(isset($row)){
                return json_encode(array('code' => 200, 'message' => 'Akun ditemukan, Login berhasil!', 'data' => $row));
            }else{
                http_response_code(400);
                return json_encode(array('code' => 400, 'message' => 'NISN/Password salah atau tidak ditemukan!'));
            }
        }
    }
