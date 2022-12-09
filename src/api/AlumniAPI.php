<?php
    class AlumniAPI {
        protected $table = "siswa_alumni";

        public function getAllData(){
            $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');
            $sql = "SELECT * FROM $this->table";
            $result = mysqli_query($koneksi, $sql);
            return $result;
        }

        public function getSpecData($nisn){
            $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');
            $sql = "SELECT * FROM $this->table WHERE nisn = '$nisn'";
            $result = mysqli_query($koneksi, $sql);
            return $result;
        }

        public function rawQuery($sql){
            $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');

            mysqli_query($koneksi, $sql); 
            return 1;
        }
    }
?>