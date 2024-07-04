<?php

namespace App\Http\Controllers\Site;

use App\Models\Setting;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\Site\PaymentService;
use Auth;
use Session;

class PackageController extends BaseController
{

	/**
	 * @var PaymentService
	 */
	protected $paymentService;

	/**
	 * PackageController constructor.
	 * @param CategoryContract $categoryRepository
	 */

	public function __construct(PaymentService $paymentService)
	{
	    $this->paymentService = $paymentService;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ad_id = Session::get('ad_id');
        // echo "ad_id : ".$ad_id;
        // die("xyz");
    	$packages = $this->paymentService->fetchPackages();
        $setting_option_payment = Setting::get('stripe_payment_method');

        $this->setPageTitle('Buy Package', '');
        return view('site.packages.index',["packages"=>$packages,"ad_id"=>$ad_id,"setting_option_payment"=>$setting_option_payment]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upgrade(Request $request)
    {
        // echo $request->type;
        // die();
        $id = $request->ad_id;
        $type = $request->type;
    	$packages = $this->paymentService->fetchPackages();

        $last_package = $this->paymentService->fetchBasicPackageDetails($id);

        if(count($last_package)>0){
            $last_package_id = $last_package[0]->package_id;
            $last_package_price = $last_package[0]->price;
            $last_package_duration = $last_package[0]->duration;
        }else{
            $last_package_id = '';
            $last_package_price = '0';
            $last_package_duration = '';
        }

        $setting_option_payment = Setting::get('stripe_payment_method');

        $this->setPageTitle('Buy Package', '');
        return view('site.packages.upgrade',["packages"=>$packages,"ad_id"=>$id,"last_package_id"=>$last_package_id,"last_package_price"=>$last_package_price,"last_package_duration"=>$last_package_duration,"type"=>$type,"setting_option_payment"=>$setting_option_payment]);
    }
}
