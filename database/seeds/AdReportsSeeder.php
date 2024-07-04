<?php

use Illuminate\Database\Seeder;
use App\Models\AdReports;

class AdReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\AdReports::class,10)->create();
    }
}