<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // default seeder to create fake users by using users factory
        // \App\Models\User::factory(10)->create();

        // truncate deletes data or row from db. so when seed is run firsly it will delete the existing fiels
        // Product::truncate();
        // Category::truncate();
        // * first way for database seeding
        // creating a category and then passing it to create a product in seeder
        // $category = Category::create([
        //     "name" => "Headphones",
        //     "description" => "This Category contains Headphones"
        // ]);

        // Product::create([
        //     "product_name" => "Iphone",
        //     "product_desc" => "An Iphone uses IOS and is developed by Apple",
        //     "price" => "100000",
        //     "category_id" => $category->id
        // ]);
        // * using second method for creating/seeding fake data using factory 
        // Category::factory(5)->create();
        //* overriding the default category_id of the factory in seeder
        Product::factory(3)->create([
            'category_id' => 5
        ]);
    }
}
