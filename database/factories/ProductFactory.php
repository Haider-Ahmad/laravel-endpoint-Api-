<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
     // Specify the model that this factory is for
    protected  $model = Product::class;
    
    public function definition(): array
    {
        return [
            'name'=>$this->faker->name(),
            'price'=>$this->faker->randomFloat(2,1,1000),
            'description'=>$this->faker->sentence(20,true),
        ];
    }
}
