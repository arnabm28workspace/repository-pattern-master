<?php

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::insert([
            ["package_type"=>"basic_package","name" => 'Standard', "description" => '<p>This is test</p>', "status" => true, "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
            ["package_type"=>"basic_package","name" => 'Featured', "description" => '<p>This is test</p>', "status" => true, "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
            ["package_type"=>"add_on","name" => 'Highlighted', "description" => '<p>This is test</p>', "status" => true, "created_at" => '2020-03-10 21:30:58', "updated_at" => '2020-03-10 21:30:58'],
        ]);
    }
}
