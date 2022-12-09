<?php

    require '../BeritaAPI.php';

    
    $beritaController = new BeritaAPIController();
    if(!isset($_GET['IDS'])){
        $data = $beritaController->getIndex();
        echo $data;
    }else{
        $data = $beritaController->getSpesificData();
        echo $data;
    }

class BeritaAPIController {
    private $berita;
    public function __construct()
    {
        session_start();
        $berita = new BeritaAPI();
        $this->berita = $berita;
    }

    public function getIndex(){
        $listdata = $this->berita->getAllData();
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
        $listdata = $this->berita->getSpecData($_GET['IDS']);
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
}   

?>