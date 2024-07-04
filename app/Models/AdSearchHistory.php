<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdSearchHistory extends Model
{
	protected $table = 'adsearchhistory';
    protected $casts = [
        'search_content' => 'array'
    ];

    /**
     * Fetch most searched content 
     * @param array $params
     * @return mixed
     */
    public static function fetchMostSearchedContent(){

        $most_searched_content = AdSearchHistory::select('search_content', DB::raw('count(search_content) search_count'))->groupBy('search_content')->orderBy('search_count','desc')->get();
        
        return $most_searched_content;

    }
}
