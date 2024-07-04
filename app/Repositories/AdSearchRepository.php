<?php
namespace App\Repositories;

use App\Models\AdSearchHistory;
use App\Contracts\AdSearchContract;

/**
 * Class AdsRepository
 *
 * @package \App\Repositories
 */
class AdSearchRepository extends BaseRepository implements AdSearchContract
{
	/**
	 * AdSearchRepository constructor.
	 * @param AdSearchHistory $model
	 */
	public function __construct(AdSearchHistory $model)
	{
	    parent::__construct($model);
	    $this->model = $model;
	}

	/**
	 * Store search content 
	 * @param array $params
	 * @return mixed
	 */
	public function storeSearchData(array $params){

	    $search_content = array();
	    $search_content['category'] = $params['category'];
	    $search_content['country'] = $params['country'];
	    $search_content['city'] = $params['city'];

	    $adsearchDetails = new $this->model;
	    $adsearchDetails->ip_address = $params['ip_address'];
	    $adsearchDetails->search_content = $search_content;
	    $adsearchDetails->save();

	    return $adsearchDetails;

	}

}