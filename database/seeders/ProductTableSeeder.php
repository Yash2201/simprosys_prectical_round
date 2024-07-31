<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 1000) as $index) {
            DB::table('products')->insert([
                'category_id' => 1,
                'title' => $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 10, 1000),
                'status' =>  $faker->randomElement(['available', 'out of stock', 'pre-order']),
                'created_at' => now()
            ]);
        }
    }
}
