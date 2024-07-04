<?php

namespace App\Contracts;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface AdsImageContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listAdsImage($id, string $order = 'id', string $sort = 'desc', array $columns = ['*']);
}