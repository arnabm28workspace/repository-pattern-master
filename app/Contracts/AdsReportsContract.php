<?php

namespace App\Contracts;

/**
 * Interface BlogContract
 * @package App\Contracts
 */
interface AdsReportsContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listAdsReports(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findAdsReportById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createAdsReport(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateAdsReport(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteAdsReport($id);

    public function getAllReports();
}