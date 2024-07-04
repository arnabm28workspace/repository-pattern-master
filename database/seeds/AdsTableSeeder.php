<?php
use App\Models\Ads;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Ads::class,20)->create();
        /* Ads::insert([
            ["title" => 'This is test advert 1', "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.", "unique_id" => "000001",'category_id'=>"1", "country_id" => "1", "city" => "Test City","type"=>"1","package_id"=>"1","email"=>"test@testmail.com","phone"=>"0123456789","website"=>"http://testwebsite.com","user_id"=>"1","price"=>0,"expire_date"=>date('Y-m-d', strtotime("+30 days")),"is_blocked"=>0],
            ["title" => 'This is test advert 2', "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.", "unique_id" => "000002",'category_id'=>"2", "country_id" => "1", "city" => "Test City","type"=>"1","package_id"=>"3","email"=>"test@testmail.com","phone"=>"0123456789","website"=>"http://testwebsite.com","user_id"=>"1","price"=>0,"expire_date"=>date('Y-m-d', strtotime("+30 days")),"is_blocked"=>0],
            ["title" => 'This is test advert 3', "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.", "unique_id" => "000003",'category_id'=>"2", "country_id" => "1", "city" => "Test City","type"=>"1","package_id"=>"4","email"=>"test@testmail.com","phone"=>"0123456789","website"=>"http://testwebsite.com","user_id"=>"1","price"=>0,"expire_date"=>date('Y-m-d', strtotime("+30 days")),"is_blocked"=>0],
            ["title" => 'This is test advert 4', "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.", "unique_id" => "000004",'category_id'=>"1", "country_id" => "1", "city" => "Test City","type"=>"1","package_id"=>"4","email"=>"test@testmail.com","phone"=>"0123456789","website"=>"http://testwebsite.com","user_id"=>"1","price"=>0,"expire_date"=>date('Y-m-d', strtotime("+30 days")),"is_blocked"=>0],
            ["title" => 'This is test advert 5', "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.", "unique_id" => "000005",'category_id'=>"5", "country_id" => "1", "city" => "Test City","type"=>"1","package_id"=>"3","email"=>"test@testmail.com","phone"=>"0123456789","website"=>"http://testwebsite.com","user_id"=>"1","price"=>0,"expire_date"=>date('Y-m-d', strtotime("+30 days")),"is_blocked"=>0],
            ["title" => 'This is test advert 6', "description" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.", "unique_id" => "000006",'category_id'=>"3", "country_id" => "1", "city" => "Test City","type"=>"1","package_id"=>"4","email"=>"test@testmail.com","phone"=>"0123456789","website"=>"http://testwebsite.com","user_id"=>"1","price"=>0,"expire_date"=>date('Y-m-d', strtotime("+30 days")),"is_blocked"=>0]
        ]); */
    }
}
