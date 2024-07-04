<?php

namespace App\Http\Controllers\Admin;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Contracts\PackageContract;
use App\Services\Admin\PackageService;
use App\Http\Controllers\BaseController;

class PackageController extends BaseController
{
    /**
     * @var PackageContract
     */
    protected $packageService;

    /**
     * PackageController constructor.
     * @param PackageService $packageService
     */

    public function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = $this->packageService->fetchPackages();

        $this->setPageTitle('Packages', '');
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Create Package', '');
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customMessages = [
            'duration.0.filled' => 'Duration field is required.',
            'price.0.filled' => 'Price field is required.'
        ];

        $this->validate($request, [
            'name'          =>  'required|max:191',
            'price'         =>  'required|array',
            'price.0'       =>  'filled|min:1',
            'duration'      =>  'required|array',
            'duration.0'    =>  'filled|min:1',
        ], $customMessages);

        $package = $this->packageService->createPackage($request);

        if (!$package) {
            return $this->responseRedirectBack('Error occurred while creating package.', 'error', true, true);
        }
        return $this->responseRedirect('admin.package.index', 'Package added successfully' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = $this->packageService->fetchPackageById($id);
        $this->setPageTitle('Package: '.$package->name, '');
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $customMessages = [
            'duration.0.filled' => 'Duration field is required.',
            'price.0.filled' => 'Price field is required.'
        ];

        $this->validate($request, [
            'name'        =>  'required|max:191',
            'price'         =>  'required|array',
            'price.0'       =>  'filled|min:1',
            'duration'      =>  'required|array',
            'duration.0'    =>  'filled|min:1',
        ], $customMessages);

        $package = $this->packageService->updatePackage($request);

        if (!$package) {
            return $this->responseRedirectBack('Error occurred while updating package.', 'error', true, true);
        }
        return $this->responseRedirectBack('Package updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $package_data = $this->packageService->fetchPackageById($id); // Stores the package data
        $package_type = $package_data->package_type; // Package Type

        if($package_type == "basic_package")
        {
            return $this->responseRedirectBack('You cannot delete a basic package.', 'error', true, true);
        }else{
            $package = $this->packageService->deletePackage($id);
            if (!$package) {
                return $this->responseRedirectBack('Error occurred while deleting package.', 'error', true, true);
            }
            return $this->responseRedirect('admin.package.index', 'Package deleted successfully' ,'success',false, false);
        }
    }

    public function updateStatus(Request $request) {
        $response = $this->packageService->updateStatus($request);
        if($response){
            return response()->json(array('message'=>'Successfully updated package status'));
        }
    }
}
