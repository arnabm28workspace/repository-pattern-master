<?php

use Illuminate\Database\Seeder;
use App\Models\PackagePriceTime;

class PackagePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PackagePriceTime::insert([
            ["package_id"=>"1","price" => '30', "duration" => '7', "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
            ["package_id"=>"1","price" => '40', "duration" => '10', "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
            ["package_id"=>"1","price" => '50', "duration" => '15', "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
            ["package_id"=>"2","price" => '50', "duration" => '7', "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
            ["package_id"=>"2","price" => '60', "duration" => '10', "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
            ["package_id"=>"2","price" => '70', "duration" => '15', "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
            ["package_id"=>"3","price" => '50', "duration" => '7', "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
            ["package_id"=>"3","price" => '60', "duration" => '10', "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
            ["package_id"=>"3","price" => '70', "duration" => '15', "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
        ]);
    }
}
