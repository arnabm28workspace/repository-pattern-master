<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\Admin\AdminService;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;

class UserManagementController extends BaseController
{

    protected $adminService;

    /**
     * UserManagementController constructor.
     * @param AdminService $adminService
     */

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * List all the users
     */
    public function listUsers()
    {
    	$user_details = $this->adminService->fetchUsers();
    	$this->setPageTitle('Users', 'List of all users');
    	return view('admin.users.index',['user_details'=>$user_details]);
    }

    /**
     * Update user with approve or block status
     * @param Request $request 
     */
    public function updateUser(Request $request)
    {
        $response = $this->adminService->blockUser($request->user_id,$request->is_block);

        if($response){
            return response()->json(array('message'=>'Successfully updated'));
        }
    }

    /**
     * View user profile details with respect to user id
     * @param $id 
     */
    public function viewDetail($id)
    {
        $data = $this->adminService->fetchUserById($id);
        
        $this->setPageTitle('User Profile Details','User Profile');
        return view('admin.users.details',['userProfile'=>$data['user'],'username'=>$data['userDetails']['name'],'userdetails'=>$data['userDetails'],'ads'=>$data['ads'],'payments'=>$data['payments']]);
    }

    /**
     * View user payment details
     * @param $id 
     */
    public function viewPaymentDetails($id)
    {
        $payments = $this->adminService->fetchPaymentDetails($id);
        
        $this->setPageTitle('User Payment Details','User Payment');
        return view('admin.users.payment_details',['payments'=>$payments]);
    }
}
