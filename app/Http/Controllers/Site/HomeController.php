<?php
namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Site\HomeService;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class HomeController extends BaseController
{
    protected $homeService;

    /**
     * SiteController constructor
     * @param HomeService $homeService
     */
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    /**
     * Display a listing of the resource.
     * * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $client_ip = $request->ip();
        $selected_category = '';
        $locationInfoIP = \Location::get($client_ip);
        $selected_country = strtolower(!empty($locationInfoIP)?$locationInfoIP->countryName:'');
        $selected_city = strtolower(!empty($locationInfoIP)?$locationInfoIP->cityName:'');
        $search_terms = array('country' => $selected_country, 'city' => $selected_city, 'category' => $selected_category);
        $datas = $this->homeService->fetchAllDatas($search_terms);

        $this->setPageTitle('Home', '');
        return view('site.home.index',compact('datas', 'selected_category', 'selected_country', 'selected_city'));
    }

    public function bugReport(Request $request) {
        $this->setPageTitle('Report Bug', '');
        $request->session()->put('previous_url', \URL::previous());
        return view('site.report-bug');
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