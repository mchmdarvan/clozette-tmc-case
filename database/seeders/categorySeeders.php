<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class categorySeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Define the number of categories you want to generate
        $numberOfCategories = 10;

        for ($i = 0; $i < $numberOfCategories; $i++) {
            Category::create([
                'name' => $faker->word,
            ]);
        }
    }
}
