<?php

use Illuminate\Database\Seeder;
use App\Models\AdMessages;

class AdMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\AdMessages::class,10)->create();
    }
}