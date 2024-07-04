<?php

namespace App\Services\Admin;

use App\Contracts\PaymentContract;
use Illuminate\Support\Facades\Hash;
use App\Contracts\PackageContract;
use App\Models\AdPackages;
use Auth;

class PaymentService
{
    protected $paymentRepository;
    protected $packageRepository;
    
    /**
     * class PackageService constructor
     */
    public function __construct(PaymentContract $paymentRepository,PackageContract $packageRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->packageRepository = $packageRepository;
    }

    /**
     * Fetch List of Payments
     * @return mixed
     */
    public function fetchPaymentList() {
        $payments = array();
        $paymentsData = $this->paymentRepository->showPaymentList();

        foreach($paymentsData as $payment){
            $packages = AdPackages::with('package')->where('ad_id',$payment->ad_id)->get();

            $package_name = '';
            $package_expire_date = '';
            $add_on_name = '';
            $add_on_expire_date = '';
            foreach ($packages as $p) {
                if($p->package_type=='basic_package'){
                    $package_name = $this->packageRepository->findPackageById($p->package_id)->name;
                    $package_expire_date = $p->expiry_date;
                }

                if($p->package_type=='add_on'){
                    $add_on_name = $this->packageRepository->findPackageById($p->package_id)->name;
                    $add_on_expire_date = $p->expiry_date;
                }
            }

            $payment->package_name = $package_name;
            $payment->package_expire_date = $package_expire_date;
            $payment->add_on_name = $add_on_name;
            $payment->add_on_expire_date = $add_on_expire_date;

            array_push($payments, $payment);
        }

        // echo "<pre>";
        // print_r($payments);
        // die();
        return $payments;
    }
}

?>