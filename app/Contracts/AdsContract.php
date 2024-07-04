<?php

namespace App\Contracts;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface AdsContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listAds(string $order = 'id', string $sort = 'desc', array $columns = ['*']);
   
   	/**
     * @param int $id
     * @return mixed
     */
    public function findAdsById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createAds(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateAds(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteAds($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function uploadAdImage(array $params);

    public function fetchAllAds();

    public function updateAdStatus(array $params);

    public function fetchAdsByUser($id,string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateAdPaymentStatus(array $params);

    /**
     * Fetch Messages by user id
     */
    public function fetchMessagesByUserId();

    /**
     * Fetch All ads
     */
    public function getAds();

}