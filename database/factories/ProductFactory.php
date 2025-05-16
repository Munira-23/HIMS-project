<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
            'product_name' => $this->faker->word,
            'category_id' => Category::inRandomOrder()->first()->id ?? 1, // Ensure category exists
            'quantity' => $this->faker->numberBetween(10, 100),
            'expiry_date' => Carbon::now()->addMonths(rand(6, 24)), // Random expiry date
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
 