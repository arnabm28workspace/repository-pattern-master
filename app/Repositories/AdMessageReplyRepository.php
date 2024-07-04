<?php
namespace App\Repositories;

use App\Models\AdMessageReply;
use App\Contracts\AdMessageReplyContract;
use App\Traits\UploadAble;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Auth;
use Mail;
use App\Mail\SendMailable;

/**
 * Class AdsRepository
 *
 * @package \App\Repositories
 */
class AdMessageReplyRepository extends BaseRepository implements AdMessageReplyContract
{
    use UploadAble;

    /**
     * PackageRepository constructor.
     * @param Package $model
     */
    public function __construct(AdMessageReply $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function storeAdMessageReply(array $params)
    {
       $adMessageReply = new $this->model;
       $adMessageReply->message_id = $params['id'];
       $adMessageReply->reply_message = $params['reply_message'];
       $adMessageReply->save();

       $messagereply_data = [   "ad_title"=>$adMessageReply->admessage->ad->title,
                           "subject"=>$adMessageReply->admessage->subject,
                           "message"=>$params['reply_message'],
                           "greetings"=>"Hello,",
                           "end_greetings"=>"Regards,",
                           "from_user"=>"Viggaro",
                           "to"=>$adMessageReply->admessage->email,
                           "from"=>$adMessageReply->admessage->ad->email,
                           "mail_type"=>'ad_message'
                       ];
                           
       $mail = Mail::send(new SendMailable($messagereply_data));

       return $adMessageReply; 
    }
}