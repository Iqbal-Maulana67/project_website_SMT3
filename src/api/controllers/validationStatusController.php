<?php

    require '../validationStatusAPI.php';

    
    $validationStatusController = new validationStatusController();
    if(!isset($_GET['nisn'])){
        $data = $validationStatusController->getIndex();
        echo $data;
    }else{
        $data = $validationStatusController->getSpesificData();
        echo $data;
    }

class validationStatusController {
    private $validationStatusAPI;
    public function __construct()
    {
        session_start();
        $validationStatusAPI = new validationStatusAPI();
        $this->validationStatusAPI = $validationStatusAPI;
    }

    public function getIndex(){
        $listdata = $this->validationStatusAPI->getAllData();
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
        $listdata = $this->validationStatusAPI->getSpecData($_GET['nisn']);
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