<?php

namespace App\Contracts;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface PageContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listPages(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findPageById(int $id);

    /**
     * @param $slug
     * @return mixed
     */
    public function findPageBySlug($slug);

    /**
     * @param array $params
     * @return mixed
     */
    public function createPage(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePage(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deletePage($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePageStatus(array $params);

    public function findPage(array $params);
}