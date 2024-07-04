<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\PaymentService;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    
    protected $paymentService;
    
    /**
     * PaymentController constructor
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $payments = $this->paymentService->fetchPaymentList();

        $this->setPageTitle('Payments', 'List of all payments');
        return view('admin.payments.index', compact('payments'));
    }
}
