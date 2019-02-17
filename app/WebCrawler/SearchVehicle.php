<?php

namespace App\WebCrawler;

use App\User;
use GuzzleHttp\Client;

class SearchVehicle{
    
    function searchVehicle($vehicle){
        $client = new Client(['base_uri' => 'https://www.seminovosbh.com.br']);
    }
}