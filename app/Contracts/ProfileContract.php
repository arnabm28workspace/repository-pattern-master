<?php

namespace App\Contracts;

/**
 * Interface ProfileContract
 * @package App\Contracts
 */
interface ProfileContract
{

    /**
     * @param array $params
     * @return mixed
     */
    public function showProfile();

    /**
     * @param array $params
     * @return mixed
     */
    public function showProfileById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateorcreateProfile(array $params, int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateProfile(array $params, int $id);
   
}