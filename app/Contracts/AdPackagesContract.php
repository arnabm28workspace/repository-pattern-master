<?php

namespace App\Contracts;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface AdPackagesContract
{
	/**
     * @param int $id
     * @return mixed
     */
    public function getPackageDetails($id);

    /**
     * @param int $id
     * @return mixed
     */
    public function storePaymentAdPackageDetails(array $params);

    /**
     * @param int $id
     * @return mixed
     */
    public function upgradePaymentAdPackageDetails(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function getPaymentAdPackageDetails(array $params);
}