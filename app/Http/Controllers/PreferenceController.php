<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\country;
use App\Models\Date;
use App\Models\Feed_news;
use App\Models\Preference;
use App\Models\Source;
use App\Services\thirdPartyApiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    protected $thirdPartyServices;


    public function __construct(thirdPartyApiService $thirdPartyApiService)
    {
        $this->thirdPartyServices = $thirdPartyApiService;

    }

    public function save(Request $request)
    {
        $data = $this->thirdPartyServices->extractPreference($request);
        if ($data['category']) {
            $checkCat = Category::where('name', '=', $data['category'])->first();
            if ($checkCat === null) {
                $category = new Category();
                $category->name = $data['category'];
                $category->save();
                $category_id = $category->id;
            }
            else{
                $category_id = $checkCat->id;
            }


        }
        if ($data['author']) {
            $checkAuthor = Author::where('name', '=', $data['author'])->first();
            if ($checkAuthor === null) {
                $author = new Author();
                $author->name = $data['author'];
                $author->save();
                $author_id = $author->id;
            }
            else{
                $category_id = $checkAuthor->id;
            }
        }

        if ($data['source']) {
            $checkSource = Source::where('name', '=', $data['source'])->first();
            if ($checkSource === null) {
                $source = new Source();
                $source->name = $data['source'];
                $source->save();
                $source_id = $source->id;
            }
            else{
                $source_id = $checkSource->id;
            }
        }

        if ($data['country']) {
            $checkCountry= Country::where('name', '=', $data['country'])->first();
            if ($checkCountry === null) {
                $country = new Country();
                $country->name = $data['country'];
                $country->save();
                $country_id = $country->id;
            }
            else{
                $country_id = $checkCountry->id;

            }
        }

        if ($data['date']) {

            $date = new Date();
            if ($data['feed_name']){
                $date->startDate=Carbon::now()->subDays(3)->toDateTimeString();
            }
            else
                $date->start_date = $data['date'];

            $date->save();
            $date_id = $date->id;
        }

        if ($data['feed_name']) {
            $feed_news = new Feed_news();
            $feed_news->name = $data['feed_name'];
            $feed_news->save();
            $feed_news_id = $feed_news->id;
        }

        $user_id = Auth::id();


        if ($data['name']) {
            $pref = new Preference();
            $pref->category_id = $category_id;
            $pref->country_id = $country_id;
            $pref->author_id = $author_id;
            $pref->source_id = $source_id;
            $pref->date_id = $date_id;
            $pref->user_id = $user_id;
            $pref->feedable = 1;
            $pref->feed_news_id = $feed_news_id;
        }


        $pref->save();

        $prefs=Preference::where('user_id',$user_id)->with('categories.name','authors.name','countries','sources','dates')->get();

        return response([
            'prefs' => $prefs
        ]);
    }
}
