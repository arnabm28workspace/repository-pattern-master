<?php

namespace App\Contracts;

/**
 * Interface AdSearchContract
 * @package App\Contracts
 */
interface AdSearchContract
{

    /**
     * @param array $params
     * @return mixed
     */
    public function storeSearchData(array $params);


}