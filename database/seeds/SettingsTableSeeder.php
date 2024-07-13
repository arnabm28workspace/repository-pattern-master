<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

	/**
	 * @var array
	 */
	protected $settings = [
		[
			'key'                       =>  'site_name',
			'value'                     =>  'Repository Pattern Master',
		],
		[
			'key'                       =>  'site_title',
			'value'                     =>  'Repository Pattern Master',
		],
		[
			'key'                       =>  'default_email_address',
			'value'                     =>  'test@gmail.com',
		],
		[
			'key'                       =>  'currency_code',
			'value'                     =>  'GBP',
		],
		[
			'key'                       =>  'currency_symbol',
			'value'                     =>  '£',
		],
		[
			'key'                       =>  'social_facebook',
			'value'                     =>  '',
		],
		[
			'key'                       =>  'social_twitter',
			'value'                     =>  '',
		],
		[
			'key'                       =>  'social_instagram',
			'value'                     =>  '',
		],
		[
			'key'                       =>  'social_linkedin',
			'value'                     =>  '',
		],
		[
			'key'                       =>  'google_analytics',
			'value'                     =>  '',
		],
		[
			'key'                       =>  'facebook_pixels',
			'value'                     =>  '',
		],
		[
			'key'                       =>  'stripe_payment_method',
			'value'                     =>  true,
		],
		[
			'key'                       =>  'stripe_key',
			'value'                     =>  'pk_test_o8MRIEumzMsVU7wHqg8xFFob',
		],
		[
			'key'                       =>  'stripe_secret_key',
			'value'                     =>  'sk_test_W8QAJT5EhliVOMKUlrAGZTEh',
		],
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $index => $setting)
        {
            $result = Setting::insert($setting);
            if (!$result) {
                $this->command->info("Insert failed at record $index.");
                return;
            }
        }
        $this->command->info('Inserted '.count($this->settings). ' records');
    }
}
