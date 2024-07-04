<?php

namespace App\Contracts;

/**
 * Interface CategoryFormContract
 * @package App\Contracts
 */
interface CategoryFormContract
{
    /**
     * @param array $params
     * @return mixed
     */
    public function createCategoryForm(array $params);

    /**
     * @param int $id
     * @return mixed
     */
    public function findFormById(int $id);

   
}