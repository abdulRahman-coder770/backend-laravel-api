<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class ThirdPartyApiService
{
    protected $dataForm;
    private function extractRequest(Request $request){
        $results=[];
        foreach ($request as $key=>$value)
        {
            if ($value!='' && $value != null)
            $results[$key]=$value;
        }
        return $results;
    }


//    public function getDataFromApi($url, $key): \Illuminate\Http\Client\Response
//    {
//        return Http::get($url, [
//            'q' => 'apple', // Modify the value of the 'q' parameter here
//            'from' => '2023-05-10',
//            'sortBy' => 'popularity',
//            'apiKey' => $key,
//        ]);
//    }



    public function searchDataFromApi(Request $request,$url, $key): \Illuminate\Http\Client\Response
    {
        return Http::get($url,  array_merge($this->extractRequest($request),['api-key',$key]));
    }

    public function extractPreference(Request $request){
        return $this->extractRequest($request);
    }



    public function normalizingGuardianApi(Request $request){
        if (!$request){
            $request=[];
        }
        $dataform=[];
        $url=config('apisUrls.GuardianUrl');
        $key=config('apisKeys.NewsApiKey');
        $response= Http::get($url, array_merge(['q'=>'a'],$this->extractRequest($request),['api-key',$key]));

        foreach ($response.results as $item){
            $dataform['title']=$item['webTitle'];
            $dataform['url']=$item['webUrl'];
            $dataform['author']=$item['Guardian '];
            $dataform['category']=$item['sectionName'];
            $dataform['imageUrl']=$item['https://www.google.com/url?sa=i&url=https%3A%2F%2Fminutearticle.com%2FMA-User%2F%3Fname%3DSarang%2520%26%2520id%3D34&psig=AOvVaw2aua1K3_rT3wHjPdLk3l8_&ust=1684522932151000&source=images&cd=vfe&ved=0CBEQjRxqFwoTCPiDnYrH__4CFQAAAAAdAAAAABAK'];
        }
        return $dataform;
    }

    public function normalizingNYTimesApi(Request $request){
        if (!$request){
            $request=[];
        }
        $url=config('apisUrls.NyTimesUrl');
        $key=config('apisKeys.NyTimesKey');
        $dataform=[];
        $response= Http::get($url,array_merge($this->extractRequest($request),['api-key',$key]));

        foreach ($response.docs as $item){
            $dataform['title']=$item['abstract'];
            $dataform['url']=$item['web_url'];
            $dataform['author']=$item['source'];
            $dataform['content']=$item['lead_paragraph'];
            $dataform['imageUrl']=$item['https://www.google.com/url?sa=i&url=https%3A%2F%2Fminutearticle.com%2FMA-User%2F%3Fname%3DSarang%2520%26%2520id%3D34&psig=AOvVaw2aua1K3_rT3wHjPdLk3l8_&ust=1684522932151000&source=images&cd=vfe&ved=0CBEQjRxqFwoTCPiDnYrH__4CFQAAAAAdAAAAABAK'];
        }
        return $dataform;
    }

    public function normalizingNewsApi(Request $request){
        if (!$request){
            $request=[];
        }
        $url=config('apisUrls.NewsApiUrl');
        $key=config('apisKeys.NewsApKey');
        $dataform=[];
        $response= Http::get($url,array_merge($this->extractRequest($request),['api-key',$key]));

        foreach ($response->articles as $item){
            $dataform['title']=$item['title'];
            $dataform['url']=$item['url'];
            $dataform['author']=$item['author'];
            $dataform['content']=$item['content'];
            $dataform['imageUrl']=$item['urlToImage'];
        }
        return $dataform;
    }




}
