<?php

namespace App\Http\Controllers\User;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\PackageContract;
use Auth;

class PackageController extends Controller
{

	/**
	 * @var PackageContract
	 */
	protected $packageRepository;

	/**
	 * PackageController constructor.
	 * @param CategoryContract $categoryRepository
	 */

	public function __construct(PackageContract $packageRepository)
	{
	    $this->packageRepository = $packageRepository;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
    	$stripe_key = Setting::get('stripe_key');
    	$package_id = auth()->user()->package_id;
    	$packages = $this->packageRepository->listPackages();
        return view('site.package',["packages"=>$packages,"profile_package_id"=>$package_id,"stripe_key"=>$stripe_key,"ad_id"=>$id]);
    }
}
