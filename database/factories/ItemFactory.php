<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    use HasFactory;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(1000, 50000),
            'category_id' => $this->faker->randomElement(Category::pluck('id')->toArray()),
            'image_path' => 'https://loremflickr.com/640/480/food?random=' . $this->faker->numberBetween(1, 1000),
            'is_available' => $this->faker->boolean(80), // 80% chance of being available
        ];
    }
}
