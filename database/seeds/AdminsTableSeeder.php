<?php

use App\Models\Admin;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        Admin::create([
            'name'      =>  'Admin Admin',
            'email'     =>  'admin@user.com',
            'password'  =>  bcrypt('Abc@1234'),
        ]);

        //factory(Admin::class,10)->create();
    }
}
