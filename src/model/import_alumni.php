<?php

require '../../vendor/autoload.php';
require '../config/koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (isset($_POST['submit_import'])) {

    $tgl_sekarang = date('YmdHis');

    $nama_file_baru = 'data' . $tgl_sekarang . '.xlsx';

    $path = '../tmp/' . $nama_file_baru;

    if (is_file('../tmp/' . $nama_file_baru)) unlink('../tmp/' . $nama_file_baru);

    $ext = pathinfo($_FILES['namafile']['name'], PATHINFO_EXTENSION);

    $tmp_file = $_FILES['namafile']['tmp_name'];

    if ($ext == "xlsx") {
        move_uploaded_file($tmp_file, '../tmp/' . $nama_file_baru);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load('../tmp/' . $nama_file_baru);
        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $numrow = 1;
        foreach ($sheet as $row) {
            $nisn = $row['A'];
            $nama = $row['B'];
            $jenis_kelamin = $row['C'];
            $no_hp = $row['D'];
            $alamat = $row['E'];
            $tahun_lulusan = $row['F'];
            $status_alumni = $row['G'];
            $nama_instasi = $row['H'];
            $password = $row['I'];

            if ($nisn == "") continue;

            if ($numrow > 1) {
                $query = "INSERT INTO siswa_alumni VALUES(
                    '" . $nisn . "',
                    '" . $nama . "',
                    '" . $jenis_kelamin . "',
                    '" . $no_hp . "',
                    '" . $alamat . "',
                    '" . $tahun_lulusan . "',
                    '" . $status_alumni . "',
                    '" . $nama_instasi . "',
                    '" . $password . "')";
                try {
                    mysqli_query($koneksi, $query);
                    header("Location: ../table_alumni.php");
                } catch (Exception $e) {
                    if ($e->getCode() == 1062) {
                        $query = "UPDATE siswa_alumni SET nama = '" . $nama . "', jenis_kelamin = '" . $jenis_kelamin . "', 
                        nomer_hp = '" . $no_hp . "', alamat = '" . $alamat . "', tahun_lulusan = '" . $tahun_lulusan . "', status_alumni = '" . $status_alumni . "', 
                        nama_instansi = '" . $nama_instasi . "', password= '" . $password . "' WHERE nisn = '" . $nisn . "'";
                        mysqli_query($koneksi, $query);
                        unlink($path);
                        header("Location: ../table_alumni.php");
                    } else {
                        echo 'Error Code: ' . $e->getCode();
                        echo 'Error Message: ' . $e->getMessage();
                        unlink($path);
                    }
                }
            }

            $numrow++;
        }
        unlink($path);
    }
    // header("Location: ../table_siswa.php");
}
