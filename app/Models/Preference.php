<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'feedable',
        'category_id',
        'country_id',
        'source_id',
        'author_id',
        'feed_news_id'
    ];

    public function source(){
        return $this->belongsTo('App\Models\Source');
    }

    public function author(){
        return $this->belongsTo('App\Models\Author');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function country(){
        return $this->belongsTo('App\Models\Country');
    }

    public function date(){
        return $this->belongsTo('App\Models\Date');
    }

    public function feed_news(){
        return $this->belongsTo('App\Models\Feed_News');
    }
}
