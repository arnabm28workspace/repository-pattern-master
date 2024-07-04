<?php

namespace App\Contracts;

/**
 * Interface AdDetailsContract
 * @package App\Contracts
 */
interface AdDetailsContract
{
	/**
     * @param array $params
     * @return mixed
     */
    public function storeAdDetails(array $params);

	/**
     * @param array $params
     * @return mixed
     */
    public function updateAdDetails(array $params);

    /**
     * @param int $id
     * @return mixed
     */
    public function getCustomFieldValue($id,$key);

    /**
     * @param int $id
     * @return mixed
     */
    public function getRatesValue($id);
}