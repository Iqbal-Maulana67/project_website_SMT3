<?php
    class validationStatusAPI {
        protected $table = "validasi_status_alumni";

        public function getAllData(){
            $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');
            $sql = "SELECT * FROM $this->table";
            $result = mysqli_query($koneksi, $sql);
            return $result;
        }

        public function getSpecData($id_primary){
            $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');
            $sql = "SELECT * FROM $this->table WHERE nisn = '$id_primary'";
            $result = mysqli_query($koneksi, $sql);
            return $result;
        }
    }
?>