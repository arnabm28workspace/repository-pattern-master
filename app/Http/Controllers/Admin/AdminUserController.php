<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Invitation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class AdminUserController extends BaseController
{
    public function index() {
        $admins = Admin::where('id', '!=', 1)->orderBy('created_at', 'desc')->get();
        $invite_admin = Invitation::whereNull('registered_at')->get();
        $users = $admins->merge($invite_admin)->toArray();
        $this->setPageTitle('Admin Users', '');
        return view('admin.auth.index', compact('users'));
    }

    /**
     * Update user with approve or block status
     * @param Request $request 
     */
    public function updateAdminUser(Request $request)
    {
    	$user_id = $request->id;
    	$update_array=array();

    	if($request->has('is_block'))
    	{
    		$is_block = $request->is_block;
    		$update_array = ['is_block'=>$is_block];
    	}
    	
    	$updated_id = Admin::where('id',$user_id)->update($update_array);
    	return response()->json(array('message'=>'Successfully updated'));
    }

    public function bugReport(Request $request) {
        $this->setPageTitle('Report Bug', '');
        $request->session()->put('previous_url', \URL::previous());
        return view('admin.report-bug');
    }

    public function postBugReport(Request $request) {
        
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'description' =>  'required',
        ]);

        $data = array();
        $user_name = !empty($request->name) ? $request->name:'Guest User';
        $data['mail_type'] = 'reportbug';
        $data['to'] = 'development@adultcreative.co.uk';
        $data['from'] = 'support@adultcreative.co.uk';
        $data['subject'] = 'Report Bug';
        $data['username'] = $user_name;
        $data['description'] = $request->description;
        $data['website'] = config('app.name');
        
        $mail = Mail::send(new SendMailable($data));
        
        $previous_url = $request->session()->get('previous_url');
        
        return redirect($previous_url);
    }
}
