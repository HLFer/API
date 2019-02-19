<?php

namespace App\WebCrawler;

use App\User;
//use GuzzleHttp\Client;
use Goutte\Client;
//use GuzzleHttp\Client as GuzzleClient;

class SearchVehicle{
    
    function searchVehicle($brand, $model){
        $client = new Client();
        return $client->request('GET', "https://www.seminovosbh.com.br/comprar/$brand/$model/");
       
    }
}