<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(1000, 50000),
            'category_id' => Category::factory(),
            'image_path' => $this->faker->imageUrl(640, 480, 'food'),
            'is_available' => $this->faker->boolean(80), // 80% chance of being available
        ];
    }
}
