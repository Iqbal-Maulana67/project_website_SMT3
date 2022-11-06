<?php 
// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'root', 
    'pass' => '', 
    'db'   => 'db_sma_darus_sholah' 
); 
 
// DB table to use 
$table = 'siswa_aktif'; 
 
// Table's primary key 
$primaryKey = 'nisn'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'nisn', 'dt' => 0 ), 
    array( 'db' => 'nama',  'dt' => 1 ), 
    array( 'db' => 'jenis_kelamin',      'dt' => 2 ), 
    array( 'db' => 'kelas',     'dt' => 3 ), 
    array( 'db' => 'nama_ortu',    'dt' => 4 ), 
    array( 'db' => 'alamat',    'dt' => 5 ), 
); 
 
$searchFilter = array(); 
if(!empty($_GET['search_keywords'])){ 
    $searchFilter['search'] = array( 
        'first_name' => $_GET['search_keywords'], 
        'last_name' => $_GET['search_keywords'], 
        'email' => $_GET['search_keywords'], 
        'country' => $_GET['search_keywords'] 
    ); 
} 
if(!empty($_GET['filter_option'])){ 
    $searchFilter['filter'] = array( 
        'kelas' => $_GET['filter_option'] 
    ); 
} 
 
// Include SQL query processing class 
require 'ssp.class.php'; 
 
// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, $searchFilter) 
);