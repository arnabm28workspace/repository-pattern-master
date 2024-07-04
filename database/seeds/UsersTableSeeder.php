<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        App\Models\User::create([
            'name'      =>  $faker->name,
            'email'     =>  'arghya@capitalnumbers.com',
            'password'  =>  bcrypt('secret'),
            'email_verified_at' =>  \Carbon\Carbon::now(),
            'is_approve'    =>  true
        ]);
        factory(App\Models\User::class,9)->create();
    }
}
