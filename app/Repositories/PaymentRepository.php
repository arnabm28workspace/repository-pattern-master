<?php
namespace App\Repositories;

use App\Models\Setting;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Package;
use App\Models\Ads;
use App\Contracts\PaymentContract;
use App\Contracts\ProfileContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Auth;

/**
 * Class PaymentRepository
 *
 * @package \App\Repositories
 */
class PaymentRepository implements PaymentContract
{

		protected $profileRepository;
		
		/**
		 * PaymentRepository constructor.
		 * @param Payment $model
		 * @param ProfileContract $profileRepository
		 */
		public function __construct(Payment $model, ProfileContract $profileRepository)
		{
				$this->model = $model;
				$this->profileRepository = $profileRepository;
		}

		/**
		 * @param array $params
		 * @return mixed
		 */
		public function showPaymentList() {
			return Payment::with('ad')->orderBy('id', 'desc')->get();
		}

		/**
		 * @param array $params
		 * @return mixed
		 */
		public function processPayment(array $params) {

			$stripe_api = Setting::get('stripe_secret_key');
			$user_id = auth()->user()->id;
			$user_profile_details = auth()->user()->profile()->first();
			\Stripe\Stripe::setApiKey ( $stripe_api );
			try {
				$payment_intent = \Stripe\PaymentIntent::create([
					'description' => 'Software development services',
					'shipping' => [
						'name' => $params["name"],
						'address' => [
							'line1' => $user_profile_details->company_name,
							'postal_code' => $user_profile_details->post_code,
							'city' => 'San Francisco',
							'state' => 'CA',
							'country' => 'US',
						],
					],
					'amount' => ($params["pay_amount"])*100,
					'currency' => 'usd',
					'payment_method' => 'pm_card_visa',
					'payment_method_types' => ['card'],
				]);
				$payment_intent_id = $payment_intent->id;
				$payment_intent = \Stripe\PaymentIntent::retrieve(
					$payment_intent_id
				);
				$payment_intent->confirm([
					'payment_method' => 'pm_card_visa',
				]);
				$customer = \Stripe\Customer::create([
					'name' => $params["name"],
					'address' => [
						'line1' => $user_profile_details->company_name,
						'postal_code' => $user_profile_details->post_code,
						'city' => 'San Francisco',
						'state' => 'CA',
						'country' => 'US',
					],
				]);
				$package_id = $params["package_id"];
				$package_duration = $params['package_duration'];
				$ad_id = $params['ad_id'];
				$package_id = $params['package_id'];
				$package_name = $params['package_name'];
				$add_on_id = $params['add_on_id'];
				$add_on_duration = $params['add_on_duration'];
				$package_amount = $params['package_amount'];
				$add_on_amount = $params['add_on_amount'];
				$add_on_arr = json_decode($params['ad_arr']);

				$paymentData = array();

				if($package_id!=0){
					$data = array(
						'package_id'=>$package_id,
						'package_name'=>$package_name,
						'price'=>$package_amount,
						'duration'=>$package_duration,
						'purchase_date'=>\Carbon\Carbon::now()->toDateString()
					);
				}else{
					$data = array();
				}
				$paymentData['basic_package'] = $data;

				$add_ons = array();
				foreach($add_on_arr as $add_on){
					$data = array(
						'package_id'=>$add_on->id,
						'package_name'=>$add_on->name,
						'price'=>$add_on->price,
						'duration'=>$add_on->duration,
						'purchase_date'=>\Carbon\Carbon::now()->toDateString()
					);

					array_push($add_ons, $data);
				}

				$paymentData['add_ons'] = $add_ons;
				$paymentValue = json_encode($paymentData);

				$renew_date = \Carbon\Carbon::now()->add($package_duration, 'day');
				$payment_records = array('user_id'=>$user_id,
									'amount'=>$params["pay_amount"],
									'ad_id'=>$ad_id,
									'package_id'=>$package_id,
									'payment_intent_id'=>$payment_intent_id,
									'payment_customer_id'=>$customer->id,
									'payment_info'=>$paymentValue,
									'paid_on'=>\Carbon\Carbon::now(),
									'renew_on'=>$renew_date
								);
				$payment_record_id = Payment::create($payment_records);
					
				return true;   
					
			} catch ( \Exception $e ) {
					return false;
			}
		}

		/**
		 * @param array $params
		 * @return mixed
		 */
		public function upgradePayment(array $params) {
			$stripe_api = Setting::get('stripe_secret_key');
			$user_id = auth()->user()->id;
			$user_profile_details = auth()->user()->profile()->first();
			\Stripe\Stripe::setApiKey ( $stripe_api );
			try {
					$payment_intent = \Stripe\PaymentIntent::create([
						'description' => 'Software development services',
						'shipping' => [
							'name' => $params["name"],
							'address' => [
								'line1' => $user_profile_details->company_name,
								'postal_code' => $user_profile_details->post_code,
								'city' => 'San Francisco',
								'state' => 'CA',
								'country' => 'US',
							],
						],
						'amount' => ($params["pay_amount"])*100,
						'currency' => 'usd',
						'payment_method' => 'pm_card_visa',
						'payment_method_types' => ['card'],
					]);
					$payment_intent_id = $payment_intent->id;
					$payment_intent = \Stripe\PaymentIntent::retrieve(
						$payment_intent_id
					);
					$payment_intent->confirm([
						'payment_method' => 'pm_card_visa',
					]);
					$customer = \Stripe\Customer::create([
						'name' => $params["name"],
						'address' => [
							'line1' => $user_profile_details->company_name,
							'postal_code' => $user_profile_details->post_code,
							'city' => 'San Francisco',
							'state' => 'CA',
							'country' => 'US',
						],
					]);
					$package_id = (isset($params["package_id"]) && $params["package_id"]!='')?$params["package_id"]:0;
					$package_duration = $params['package_duration'];
					$ad_id = $params['ad_id'];
					$package_id = $package_id;
					$package_name = $params['package_name'];
					$add_on_id = $params['add_on_id'];
					$add_on_duration = $params['add_on_duration'];
					$package_amount = $params['package_amount'];
					$add_on_amount = $params['add_on_amount'];
					$pay_type = $params['pay_type'];
					$add_on_arr = json_decode($params['ad_arr']);

					$paymentData = array();

					if($package_id!=0){
						$data = array(
							'package_id'=>$package_id,
							'package_name'=>$package_name,
							'price'=>$package_amount,
							'duration'=>$package_duration,
							'purchase_date'=>\Carbon\Carbon::now()->toDateString()
						);
					}else{
						$data = array();
					}
					$paymentData['basic_package'] = $data;

					$add_ons = array();
					foreach($add_on_arr as $add_on){
						$data = array(
							'package_id'=>$add_on->id,
							'package_name'=>$add_on->name,
							'price'=>$add_on->price,
							'duration'=>$add_on->duration,
							'purchase_date'=>\Carbon\Carbon::now()->toDateString()
						);

						array_push($add_ons, $data);
					}

					$paymentData['add_ons'] = $add_ons;
					$paymentValue = json_encode($paymentData);

					$renew_date = \Carbon\Carbon::now()->add($package_duration, 'day');
					$payment_records = array('user_id'=>$user_id,
											'amount'=>$params["pay_amount"],
											'ad_id'=>$ad_id,
											'package_id'=>$package_id,
											'payment_intent_id'=>$payment_intent_id,
											'payment_customer_id'=>$customer->id,
											'payment_info'=>$paymentValue,
											'paid_on'=>\Carbon\Carbon::now(),
											'renew_on'=>$renew_date
									);
					$payment_record_id = Payment::create($payment_records);
					
					return true;   
					
			} catch ( \Exception $e ) {
				dd($e);
					return false;
			}
		}

		public function updateFreePackage($ad_id,$package_id){
			$package_duration = Package::select('duration')->where('id',$package_id)->first();
			$renew_date = \Carbon\Carbon::now()->addDays($package_duration['duration']);
			$ads  = Ads:: find($ad_id);
			$ads->expiry_date=$renew_date;
			$ads->package_id=$package_id;
			$ads->save();
			
			return true;   
		}

		public function getPaymentListByUserId($user_id){
			return Payment::with('ad')->where('user_id',$user_id)->orderBy('id', 'desc')->get();
		}

		public function getPaymentDetails($id){
			$payment = Payment::where('id',$id)->orderBy('id', 'desc')->get();
			return $payment;
		}
}