<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use App\Services\ThirdPartyApiService;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function getNewsApiData()
    {
        $response = (new ThirdPartyApiService())->getDataFromApi(config('apisUrls.NewsApiUrl'), config('apisKeys.NewsApiKey'));
        return $response['articles'];
    }
    public function searchArticles(Request $request)
    {
         $response=(new ThirdPartyApiService())->searchDataFromApi($request,config('apisUrls.NewsApiUrl'), config('apisKeys.NewsApiKey'));
        return $response['articles'];
    }

    public function getArticlesAndPreferenceById(Request $request){
        $preference=Preference::findOrFail($request->id);
        $pref=[];
        $pref['category']=$preference->category->name;
        $pref['author']=$preference->author->name;
        $pref['source']=$preference->source->name;
        $pref['country']=$preference->country->name;
        $pref['start_date']=$preference->date->start_date;

        $articles=(new ThirdPartyApiService())->searchDataFromApi($pref,config('apisUrls.NewsApiUrl'), config('apisKeys.NewsApiKey'));

        return \response([
            'articles'=>$articles,
            'preference'=>array_merge($pref,$preference)
        ]);
    }
}
