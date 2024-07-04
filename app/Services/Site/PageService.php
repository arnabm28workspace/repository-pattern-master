<?php

namespace App\Services\Site;

use App\Contracts\PageContract;
use Illuminate\Support\Facades\Hash;

class PageService
{
	protected $pageRepository;

    /**
     * class PageService constructor
     */
    public function __construct(PageContract $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Fetch Page
     * @return mixed
     */
    public function findPageBySlug($slug){
        return $this->pageRepository->findPageBySlug($slug);
    }

    public function findPageByCountry($slug){
        return $this->pageRepository->findPageByCountry($slug);
    }

    public function findPage($params){
        return $this->pageRepository->findPage($params);
    }
}