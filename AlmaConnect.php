<?php
require("SimpleLogger.php");

class AlmaConnect
{
    private $configs;

    function __construct()
    {
        $this->configs = include("config.php");
    }

    public function loginAlma($user_id)
    {
        if (!empty($user_id)) {
            $ch = curl_init();
            $target = $this->configs['alma_base_url'] ."almaws/v1/users/$user_id?apikey=".$this->configs["alma_api_key"]."&expand=loans,requests,fees&format=json";
            curl_setopt($ch, CURLOPT_URL, $target);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "X-Requested-With: XMLHttpRequest",
                "Accept: application/json",
                "contentType: text/plain"
            ));


            $r = curl_exec($ch);
            $response = json_decode($r);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($code === 200)
            {
                SimpleLogger::appendToLog("info", "{$response->primary_id}, {$response->first_name} {$response->last_name} has logged in.");
            }
            else
            {
                SimpleLogger::appendToLog("error", "$user_id was unable to log in with Alma.  $r");
                return null;
            }

            return $response;
        }
    }

    public function loansAlma($unid)
    {
        if (($unid != null) && ($unid != "")) {
            $ch = curl_init();
            $target = $this->configs['alma_base_url'] ."almaws/v1/users/$unid/loans?apikey=".$this->configs['alma_api_key']."&format=json";
            curl_setopt($ch, CURLOPT_URL, $target);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "X-Requested-With: XMLHttpRequest",
                "Accept: application/json",
                "contentType: text/plain"
            ));

            $r = curl_exec($ch);
            $response = json_decode($r);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($code === 200)
            {
                SimpleLogger::appendToLog("info", "{$response->primary_id}, {$response->first_name} {$response->last_name} has logged in.");
            }
            else
            {
                SimpleLogger::appendToLog("error", "$unid was unable to log in with Alma.  $r");
                return null;
            }

            return $response;
        }
    }

    public function loan($unid, $barcode)
    {
        $ch = curl_init();
        $postData = '{"circ_desk":{"value":"'.$this->configs["alma_circ_desk"].'"},"library":{"value":"'.$this->configs["alma_library"].'"}}';
        $target = $this->configs['alma_base_url'] ."almaws/v1/users/$unid/loans?item_barcode=$barcode&apikey=".$this->configs['alma_api_key'];
        curl_setopt($ch, CURLOPT_URL, $target);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Requested-With: XMLHttpRequest",
            "Accept: application/json",
            "content-type: application/json"
        ));

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code == 200)
        {
            SimpleLogger::appendToLog("info", "$unid checked out $barcode");
            return json_decode($response);
        }
        SimpleLogger::appendToLog("error", "$unid was unable to check out $barcode.  Response: $response");
        return json_decode($response);
    }
}