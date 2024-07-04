<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Mail;
use App\Mail\SendEmail;

class InstallController extends BaseController
{
    public function showInstallForm()
    {
        $total_admin = Admin::count();
        
        if ($total_admin > 0){
            return redirect(route('admin.login'));
        } else{
            return view('admin.install.index', compact('total_admin'));
        }
    }

    /**
     * Store a newly created user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createAdmin(Request $request)
    {
        $this->validate($request, [
            'email'      =>  'required|email|unique:admins',
        ]);

        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->email_verified_at = now();
        $admin->password = bcrypt($request->password);
        $admin->save();

        Setting::set('site_name', $request->site_name);
        Setting::set('site_title', $request->site_title);
        Setting::set('currency_code', $request->currency_code);
        Setting::set('currency_symbol', $request->currency_symbol);

        if (!$admin) {
            return $this->responseRedirectBack('Error occurred while creating admin.', 'error', true, true);
        }
            return redirect(route('admin.login'))->with('success', 'Admin Created Successfully!');
    }
}