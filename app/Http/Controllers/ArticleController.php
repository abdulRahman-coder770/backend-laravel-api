<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use App\Services\ThirdPartyApiService;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $thirdPartyServices;


    public function __construct(ThirdPartyApiService $thirdPartyApiService)
    {
        $this->thirdPartyServices = $thirdPartyApiService;
    }

    public function getNewsApiData()
    {
        $request=new Request(['q'=>'a']);
        $arrayNewsApi = $this->thirdPartyServices->normalizingNewsApi($request);
        $arrayGuardian = $this->thirdPartyServices->normalizingGuardianApi($request);
        $arrayNYTimes = $this->thirdPartyServices->normalizingNYTimesApi($request);
        $response= array_merge($arrayNewsApi,$arrayGuardian,$arrayNYTimes);
        \response([
            'articles'=>$response
        ]);
    }
    public function searchArticles(Request $request)
    {
        $arrayNewsApi = $this->thirdPartyServices->normalizingNewsApi($request);
        $arrayGuardian = $this->thirdPartyServices->normalizingGuardianApi($request);
        $arrayNYTimes = $this->thirdPartyServices->normalizingNYTimesApi($request);
        $response= array_merge($arrayNewsApi,$arrayGuardian,$arrayNYTimes);
        \response([
            'articles'=>$response
        ]);
    }

    public function getArticlesAndPreferenceById(Request $request){
        $preference=Preference::findOrFail($request->id);
        $pref=[];
        $pref['category']=$preference->category->name;
        $pref['author']=$preference->author->name;
        $pref['source']=$preference->source->name;
        $pref['country']=$preference->country->name;
        $pref['start_date']=$preference->date->start_date;
        $request = new Request($pref);


        $articles=(new ThirdPartyApiService())->searchDataFromApi($request,config('apisUrls.NewsApiUrl'), config('apisKeys.NewsApiKey'));

        return \response([
            'articles'=>$articles,
            'preference'=>array_merge($pref,$preference)
        ]);
    }
}
