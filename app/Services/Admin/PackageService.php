<?php

namespace App\Services\Admin;

use App\Contracts\PackageContract;
use Illuminate\Support\Facades\Hash;
use Auth;

class PackageService
{
    protected $packageRepository;
    
    /**
     * class PackageService constructor
     */
    public function __construct(PackageContract $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    /**
     * Fetch List of Packages
     * @return mixed
     */
    public function fetchPackages() {
        return $this->packageRepository->listPackages();
    }

    /**
     * Fetch individual package
     * @param int $id
     * @return mixed
     */
    public function fetchPackageById($id) {
        return $this->packageRepository->findPackageById($id);
    }

    /**
     * Save Package information
     * @param int $id
     * @return mixed
     */
    public function createPackage($request) {
        $params = $request->except('_token');
        return $this->packageRepository->createPackage($params);
    }

    /**
     * Update Package info
     * @param Request $request
     * @return mixed
     */
    public function updatePackage($request) {
        $params = $request->except('_token');
        return $this->packageRepository->updatePackage($params);
    }

    /**
     * Delete a package
     * @param int $id
     * @return mixed
     */
    public function deletePackage($id) {
        return $this->packageRepository->deletePackage($id);
    }

    public function updateStatus($request) {
        $params = $request->except('_token');
        return $this->packageRepository->updatePackageStatus($params);
    }
}