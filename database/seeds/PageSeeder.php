<?php
use App\Models\Page;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Page::class,10)->create();
    }
}
