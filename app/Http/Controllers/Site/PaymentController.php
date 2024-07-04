<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\Site\PaymentService;
use Auth;
use Session;
use Redirect;

class PaymentController extends BaseController
{

	/**
     * @var PaymentService
     */
    protected $paymentService;

    /**
     * PaymentController constructor.
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
    public function paymentProcess(Request $request)
    {
        $paymentResponse = $this->paymentService->storePayment($request);

        if($paymentResponse){
            //return $this->responseRedirect('my-ads/live', 'Payment done successfully for this ad!' ,'success');
            return redirect('my-ads/');
        }else{
            return $this->responseRedirectBack('Error! Please Try again.', 'error', true, true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upgradeProcess(Request $request)
    {
        $upgradeResponse = $this->paymentService->upgradePayment($request);

        if($upgradeResponse){
            //return $this->responseRedirect('my-ads/live', 'Payment done successfully for this ad!' ,'success');
            return redirect('my-ads/live');
        }else{
            return $this->responseRedirectBack('Error! Please Try again.', 'error', true, true);
        }
    }

    public function updateFreePackage($ad_id,$id){
        $response = $this->paymentRepository->updateFreePackage($ad_id,$id);

        if($response){
            Session::flash ( 'success-message', 'Package successfully updated for this ad!' );
            return redirect('my-ads');
        }else{
            Session::flash ( 'error-message', "Error! Please Try again." );
            return Redirect::back ();
        }
    }
}
