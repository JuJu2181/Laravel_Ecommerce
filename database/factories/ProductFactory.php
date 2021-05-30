<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //creating fake product data
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(10),
            'price' => 10000,
            "category_id" => 1
        ];
    }
}
