<?php
class dolibarrMteclib {

    private $apikey = "your api key here";
    private $apiurl = "your url here"; // https://[DNS]/api/index.php/

    /**
     * @param string $method POST,GET,PUT,DELETE
     * @param string $url url de l'api
     * @param bool $data 
     * 
     * @var string apikey
     * 
     * @return string json result                       
     */
    function CallAPI($method, $apikey, $url, $data = false)
    {
        $curl = curl_init();
        $httpheader = ['DOLAPIKEY: '.$apikey];

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                $httpheader[] = "Content-Type:application/json";

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                break;
            case "PUT":

            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                $httpheader[] = "Content-Type:application/json";

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }


    /**
     * @param string $h1 title
     * @param string $number number of ollas
     * @return string html result
     */
    public function clientCreate($array){
        $array["client"] = "1";
        $array['code_client'] = "-1";
        $newClientResult = $this->CallAPI("POST", $this->apikey, $this->apiurl."contacts", json_encode($array));
        $newClientResult = json_decode($newClientResult, true);
        return true;
    }

    public function clientSearch($email){
        // $data = $this->CallAPI("GET", $this->apikey, $this->apiurl."contacts", array(
        //     "sortfield" => "t.rowid", 
        //     "sortorder" => "ASC", 
        //     "limit" => "1",
        //     "sqlfilters" => "(t.email:=:'".$email."')"  //(t.email:=:'test@test.test')
        //     ));
        $data = $this->CallAPI("GET", $this->apikey,$this->apiurl."contacts/email/".$email);
        $data = json_decode($data, true);
        $id = false;
        if(isset($data["id"])){$id = $data["id"];}
        return $id;
    }
    
    public function clientUpdate($id,$array){
        $data = $this->CallAPI("PUT", $this->apikey, $this->apiurl."contacts/".$id, json_encode($array));
        $data = json_decode($data, true);
        return true;
    }
}
?>