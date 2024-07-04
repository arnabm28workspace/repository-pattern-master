<?php
namespace App\Repositories;

use App\Models\AdReports;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\AdsReportsContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Mail;
use App\Mail\SendMailable;

/**
 * Class AdsReportsRepository
 *
 * @package \App\Repositories
 */
class AdsReportsRepository extends BaseRepository implements AdsReportsContract
{
    use UploadAble;

    /**
     * AdsReportsRepository constructor.
     * @param AdReports $model
     */
    public function __construct(AdReports $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listAdsReports(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findAdsReportById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return adReport|mixed
     */
    public function createAdsReport(array $params)
    {
        try {
            $collection = collect($params);

            $adReport = new AdReports;
            $adReport->ad_id = $collection['ad_id'];
            $adReport->user_id = $collection['user_id'];
            $adReport->reason = $collection['reason'];

            $adReport->save();

            $report_data = [    "ad_title"=>$adReport->ad->title,
                                "user_name"=>$adReport->user->name,
                                "user_email"=>$adReport->user->email,
                                "subject"=>"Ad Report",
                                "report_reason"=>$collection['reason'],
                                "greetings"=>"Hello,",
                                "end_greetings"=>"Regards,",
                                "from_user"=>"Viggaro",
                                "to"=>'development@adultcreative.co.uk',
                                "from"=>'viggaro@example.com',
                                "mail_type"=>'reportad'
                            ];
                                
            $mail = Mail::send(new SendMailable($report_data));

            return $adReport;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateAdsReport(array $params)
    {
        $adReport = $this->findAdsReportById($params['id']);
        $collection = collect($params)->except('_token');
        $adReport->ad_id = $collection['ad_id'];
        $adReport->user_id = $collection['user_id'];;
        $adReport->reason = $collection['reason'];
        
        $adReport->save();

        return $adReport;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteAdsReport($id)
    {
        $adReport = $this->findAdsReportById($id);

        $adReport->delete();

        return $adReport;
    }

    /**
     * @return mixed
     */
    public function getAllReports(){
        return AdReports::with('ad')->with('user')->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAllReportsByAdId($id){
        return AdReports::with('ad')->with('user')->where('ad_id',$id)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getReportDetailsById($id){
        return AdReports::with('ad')->with('user')->where('id',$id)->get();
    }
}