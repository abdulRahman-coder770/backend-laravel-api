<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class ThirdPartyApiService
{
    private function extractRequest(Request $request){
        $results=[];
        foreach ($request as $key=>$value)
        {
            if ($value!='' && $value != null)
            $results[$key]=$value;
        }
        return $results;
    }

    public function getDataFromApi($url, $key): \Illuminate\Http\Client\Response
    {
        return Http::get($url, [
            'q' => 'apple', // Modify the value of the 'q' parameter here
            'from' => '2023-05-10',
            'sortBy' => 'popularity',
            'apiKey' => $key,
        ]);
    }
    public function searchDataFromApi(Request $request,$url, $key): \Illuminate\Http\Client\Response
    {

        return Http::get($url,  array_merge($this->extractRequest($request)),[$key,$key]);

    }

    public function extractPreference(Request $request){
        return $this->extractRequest($request);
    }



}
