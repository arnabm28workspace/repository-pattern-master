<?php

use Illuminate\Database\Seeder;
use App\Models\PageType;

class PageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PageType::insert([
            [
                'name' => 'Top Level'
            ],
            [
                'name' => 'Categories'
            ],
            [
                'name' => 'Location'
            ],
        ]);
    }
}
