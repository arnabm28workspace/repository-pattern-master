<?php

namespace App\Services\Site;

use App\Contracts\PackageContract;
use App\Contracts\PaymentContract;
use App\Contracts\AdsContract;
use App\Contracts\AdPackagesContract;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\User;

class PaymentService
{
	protected $paymentRepository;
	protected $packageRepository;
	protected $adsRepository;
	protected $adPackagesRepository;

	/**
	 * PaymentService constructor.
	 * @param CategoryContract $categoryRepository
	 */
	public function __construct(PackageContract $packageRepository, PaymentContract $paymentRepository,AdsContract $adsRepository,AdPackagesContract $adPackagesRepository)
	{
	    $this->packageRepository = $packageRepository;
	    $this->paymentRepository = $paymentRepository;
	    $this->adsRepository = $adsRepository;
	    $this->adPackagesRepository = $adPackagesRepository;
	}

	/**
     * Fetch all packages
     * @return mixed
     */
	public function fetchPackages(){
		return $this->packageRepository->fetchPackageWithPriceDuration();
	}

	/**
     * Save package payment information
     * @param Request $request
     * @return mixed
     */
	public function storePayment($request){
		$params = $request->except('_token');
		if($this->paymentRepository->processPayment($params))
		{
			$this->adPackagesRepository->storePaymentAdPackageDetails($params);
			$adParams = array("id" => $params['ad_id'], "is_payment" => true);
			return $this->adsRepository->updateAdPaymentStatus($adParams);
		}
	}

	/**
     * Save package payment information
     * @param Request $request
     * @return mixed
     */
	public function upgradePayment($request){
		$params = $request->except('_token');
        if($this->paymentRepository->upgradePayment($params))
        {
        	return $this->adPackagesRepository->upgradePaymentAdPackageDetails($params);
        }
	}

	/**
     * Get package details
     * @param int $id
     * @return mixed
     */
    public function fetchBasicPackageDetails($id){
        return $this->adPackagesRepository->getPackageDetails($id);
    }
}