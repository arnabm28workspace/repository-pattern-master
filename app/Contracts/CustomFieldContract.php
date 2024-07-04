<?php

namespace App\Contracts;

interface CustomFieldContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCustomFields(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCustomFieldById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCustomField(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCustomField(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCustomField($id);
}