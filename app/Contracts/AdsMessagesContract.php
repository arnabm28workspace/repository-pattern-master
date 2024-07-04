<?php

namespace App\Contracts;

/**
 * Interface BlogContract
 * @package App\Contracts
 */
interface AdsMessagesContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listAdsMessages(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findAdsMessageById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createAdsMessage(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateAdsMessage(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteAdsMessage($id);

    public function getAllMessages();
}