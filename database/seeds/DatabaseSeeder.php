<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        //$this->call(AdminsTableSeeder::class);
        //$this->call(LocationSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PageTypeSeeder::class);
        //$this->call(PageSeeder::class);
        $this->call(PackageSeeder::class);
        //$this->call(SettingsTableSeeder::class);
        //$this->call(AdsTableSeeder::class);
        //$this->call(AdsImagesTableSeeder::class);
        //$this->call(PaymentSeeder::class);
        //$this->call(AdMessageSeeder::class);
        //$this->call(AdReportsSeeder::class);
        //$this->call(PackagePriceSeeder::class);
    }
}
