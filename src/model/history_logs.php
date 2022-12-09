<?php
    class historyLogs {
        public function insertHistory($adminUsername, $action, $primary_key, $tableName){
            $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');

            $sql = "INSERT INTO history_logs (`username`, `action`, `deskripsi`) VALUES (
                '$adminUsername', '$action', '$adminUsername telah melakukan $action pada data $primary_key di $tableName')";
            mysqli_query($koneksi, $sql);
        }
    }
?>