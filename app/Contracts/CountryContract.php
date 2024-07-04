<?php

namespace App\Contracts;

/**
 * Interface PageContract
 * @package App\Contracts
 */
interface CountryContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCountries(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCountryById(int $id);

    /**
     * @param string $code
     * @return mixed
     */
    public function fetchLocationByCountryCode(string $code);

    /**
     * @param string $name
     * @return mixed
     */
    public function findCountryByName(string $name);

    /**
     * @param string $slug
     * @return mixed
     */
    public function findCountryBySlug(string $slug);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCountry(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCountry(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCountryStatus(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCountry($id);
}