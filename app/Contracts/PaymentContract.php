<?php

namespace App\Contracts;

/**
 * Interface PaymentContract
 * @package App\Contracts
 */
interface PaymentContract
{

    /**
     * @param array $params
     * @return mixed
     */
    public function showPaymentList();

    /**
     * @param array $params
     * @return mixed
     */
    public function processPayment(array $params);

    /**
     * @param int $ad_id
     * @param int $package_id
     * @return boolean
     */
    public function updateFreePackage($ad_id,$package_id);
   
}