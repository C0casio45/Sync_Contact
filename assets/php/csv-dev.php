<?php
include "class.lib.php";
$lib = new dolibarrMteclib();
$row = 1;
$fullArr = [];
$bar = 0;
if (($csv = fopen($_FILES["contact"]["tmp_name"], "r")) !== FALSE) {
    while (($data = fgetcsv($csv, 1000, ",")) !== FALSE) {
        $num = count($data);
        if($row == 1){$row++;continue;}
        $array = [];
        {for ($c=0; $c < $num; $c++) {
            $line = explode(";",$data[$c]);
            if(isset($array["firstname"])){$array["firstname"] = $line[0];} 
            if(isset($array["lastname"])){$array["lastname"] = $line[1];} 
            if(isset($array["email"])){$array["email"] = $line[4];} 
            if(isset($array["address"])){$array["address"] = $line[8];} 
            if(isset($array["zip"])){$array["zip"] = $line[10];} 
            if(isset($array["town"])){$array["town"] = $line[9];} 
            if(isset($array["phone_mobile"])){$array["phone_mobile"] = $line[6];} 
            if(isset($array["socname"])){$array["socname"] = $line[11];} 
            if(isset($array["poste"])){$array["poste"] = $line[12];} 
            array_push($fullArr, $array);
        }}
        $row++;
    }
    $client = count($fullArr) /30;

    for($i=0 ; $client > $i;$i++ ){
        for($z=0 ; 30 > $z;$z++ ){
            $y = $z + $bar;
            // $id = $lib->clientSearch($fullArr[$y]["email"]);

            // if($id = $lib->clientSearch($fullArr[$y]["email"])){
            //     $lib->clientUpdate($id,$fullArr[$y]);
            // }else{
            //     $lib->clientCreate($fullArr[$y]);
            // }
        }
        $bar += 30;
    }
    fclose($csv);
}
?>