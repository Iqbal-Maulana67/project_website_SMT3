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
            $kelas = $row['D'];
            $golongan = $row['E'];
            $jurusan = $row['F'];
            $nama_ortu = $row['G'];
            $alamat = $row['H'];
            $status_siswa = $row['I'];

            if ($nisn == "") continue;

            if ($numrow > 1) {
                $query = "INSERT INTO siswa_aktif VALUES(
                    '" . $nisn . "',
                    '" . $nama . "',
                    '" . $jenis_kelamin . "',
                    '" . $kelas . "',
                    '" . $golongan . "',
                    '" . $jurusan . "',
                    '" . $nama_ortu . "',
                    '" . $alamat . "',
                    '" . $status_siswa . "')";
                try {
                    mysqli_query($koneksi, $query);
                    header("Location: ../table_siswa.php");
                } catch (Exception $e) {
                    if ($e->getCode() == 1062) {
                        $query = "UPDATE siswa_aktif SET nama_siswa = '" . $nama . "', jenis_kelamin = '" . $jenis_kelamin . "', 
                        kelas = '" . $kelas . "', golongan = '" . $golongan . "', id_jurusan = '" . $jurusan . "', nama_ortu = '" . $nama_ortu . "', 
                        alamat = '" . $alamat . "', status = '" . $status_siswa . "' WHERE nisn = '" . $nisn . "'";
                        mysqli_query($koneksi, $query);
                        unlink($path);
                        header("Location: ../table_siswa.php");
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
