<?php
namespace App\Repositories;

use App\Models\AdMessages;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\AdsMessagesContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Mail;
use App\Mail\SendMailable;

/**
 * Class AdsMessagesRepository
 *
 * @package \App\Repositories
 */
class AdsMessagesRepository extends BaseRepository implements AdsMessagesContract
{
    use UploadAble;

    /**
     * AdsMessagesRepository constructor.
     * @param AdMessages $model
     */
    public function __construct(AdMessages $model)
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
    public function listAdsMessages(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findAdsMessageById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return adMessage|mixed
     */
    public function createAdsMessage(array $params)
    {
        try {
            $collection = collect($params);

            $adMessage = new AdMessages;
            $adMessage->ad_id = $collection['ad_id'];
            $adMessage->email = $collection['email'];
            $adMessage->phone = $collection['phone'];
            $adMessage->subject = $collection['subject'];
            $adMessage->message = $collection['message'];

            $adMessage->save();

            $message_data = [   "ad_title"=>$adMessage->ad->title,
                                "phone"=>$collection['phone'],
                                "email"=>$collection['email'],
                                "subject"=>$collection['subject'],
                                "message"=>$collection['message'],
                                "greetings"=>"Hello,",
                                "end_greetings"=>"Regards,",
                                "from_user"=>"Viggaro",
                                "to"=>$adMessage->ad->email,
                                "from"=>'viggaro@example.com',
                                "mail_type"=>'ad_message'
                            ];
                                
            $mail = Mail::send(new SendMailable($message_data));

            return $adMessage;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateAdsMessage(array $params)
    {
        $adMessage = $this->findAdsMessageById($params['id']);
        $collection = collect($params)->except('_token');
        $adMessage->ad_id = $collection['ad_id'];
        $adMessage->email = $collection['email'];
        $adMessage->phone = $collection['phone'];
        $adMessage->subject = $collection['subject'];
        $adMessage->message = $collection['message'];
        
        $adMessage->save();

        return $adMessage;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateMessageStatus($id)
    {
        $adMessage = $this->findAdsMessageById($id);
        $adMessage->is_read = 1;
        $adMessage->save();

        $count_unread_messages = 0;
        $allMessages = array();
        $messages = array();
        $user_id = auth()->user()->ads();
        $ads = auth()->user()->ads()->get();
        foreach ($ads as $key=>$ad) {
            $message = [];
            $message = $ad->messages()->get();
            if(count($message)>0)
            {
                array_push($allMessages, $message);
            }
        }
        foreach ($allMessages as $key => $mymessages) {
            foreach ($mymessages as $key => $message) {
                array_push($messages, $message);
            }
        }
        foreach ($messages as $key => $value) {
            if($value->is_read == 0)
                $count_unread_messages++;
        }

        return $count_unread_messages;

    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteAdsMessage($id)
    {
        $adMessage = $this->findAdsMessageById($id);

        $adMessage->delete();

        return $adMessage;
    }

    /**
     * @return mixed
     */
    public function getAllMessages(){
        return AdMessages::with('ad')->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAllMessagesByAdId($id){
        return AdMessages::with('ad')->where('ad_id',$id)->get();
    }

}