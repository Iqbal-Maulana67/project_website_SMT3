<?php

    require '../config/koneksi.php';
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('ExportAlumni');

    $query = "SELECT * FROM siswa_alumni";
    $result = mysqli_query($koneksi, $query);

    $sheet->setCellValue('A1', 'NISN');
    $sheet->setCellValue('B1', 'Nama');
    $sheet->setCellValue('C1', 'Jenis Kelamin');
    $sheet->setCellValue('D1', 'Nomer HP');
    $sheet->setCellValue('E1', 'Alamat');
    $sheet->setCellValue('F1', 'Tahun Lulusan');
    $sheet->setCellValue('G1', 'Status Alumni');
    $sheet->setCellValue('H1', 'Nama Instansi');
    $sheet->setCellValue('I1', 'Password');

    $i = 2;
    while($row = mysqli_fetch_array($result)){
        $sheet->setCellValue('A'.$i, $row['nisn']);
        $sheet->setCellValue('B'.$i, $row['nama']);
        $sheet->setCellValue('C'.$i, $row['jenis_kelamin']);
        $sheet->setCellValue('D'.$i, $row['nomer_hp']);
        $sheet->setCellValue('E'.$i, $row['alamat']);
        $sheet->setCellValue('F'.$i, $row['tahun_lulusan']);
        $sheet->setCellValue('G'.$i, $row['status_alumni']);
        $sheet->setCellValue('H'.$i, $row['nama_instansi']);
        $sheet->setCellValue('I'.$i, $row['password']);
        $i++;
    }

    $date = date('YmdHis');

    $namafile = "export_alumni_excel_".$date.".xlsx";    

    header('Content-Type: applicatoin/vnd.openxmlformats-officedocuments.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$namafile);
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    // header('Location: exportedFile/'.$namafile);

?>
