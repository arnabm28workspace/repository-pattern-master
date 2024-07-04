<?php
use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ["name" => 'Friendship', "slug" => 'friendship', "description" => 'Friendship'],
            ["name" => 'Straight Relationships', "slug" => 'straight-relationships', "description" => 'Straight Relationships'],
            ["name" => 'Adult Dating', "slug" => 'adult-dating', "description" => 'Adult Dating'],
            ["name" => 'Gay and Lesbian', "slug" => 'gay-and-lesbian', "description" => 'Gay and Lesbian'],
            ["name" => 'Escorts and Massages', "slug" => 'escorts-and-massages', "description" => 'Escorts and Massages'],
            ["name" => 'Gay Escorts', "slug" => 'gay-escorts', "description" => 'Gay Escorts'],
            ["name" => 'Trans Escorts', "slug" => 'trans-escorts', "description" => 'Trans Escorts'],
            ["name" => 'Adult Entertainment', "slug" => 'adult-entertainment', "description" => 'Adult Entertainment'],
            ["name" => 'Swingers', "slug" => 'swingers', "description" => 'Swingers'],
            ["name" => 'Adult Jobs', "slug" => 'adult-jobs', "description" => 'Adult Jobs'],
        ]);
    }
}
