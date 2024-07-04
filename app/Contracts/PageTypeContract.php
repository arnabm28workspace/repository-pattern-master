<?php

namespace App\Contracts;

/**
 * Interface PageTypeContract
 * @package App\Contracts
 */
interface PageTypeContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listPageTypes(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findPageTypeById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createPageType(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePageType(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deletePageType($id);

   
}