<?php

use Illuminate\Database\Seeder;
use App\Models\Country;
use Faker\Factory as Faker;
class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Country::insert([
                    ["name"=>"India","code" => 'IN', "flag" => '<span class="flag-icon flag-icon-in"></span>',"created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
                    ["name"=>"Australia","code" => 'AU', "flag" => '<span class="flag-icon flag-icon-au"></span>',"created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
                    ["name"=>"South Africa","code" => 'ZA', "flag" => '<span class="flag-icon flag-icon-za"></span>',"created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
                    ["name"=>"United Kingdom","code" => 'GB', "flag" => '<span class="flag-icon flag-icon-gb"></span>',"created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
                    ["name"=>"United States","code" => 'US', "flag" => '<span class="flag-icon flag-icon-us"></span>',"created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58']
                ]);
    }
}
