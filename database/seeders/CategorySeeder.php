<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Appetizers', 'description' => 'Start your meal with our delicious appetizers'],
            ['name' => 'Main Courses', 'description' => 'Satisfy your hunger with our hearty main courses'],
            ['name' => 'Desserts', 'description' => 'Indulge in our sweet and delightful desserts'],
            ['name' => 'Beverages', 'description' => 'Quench your thirst with our refreshing beverages'],
        ];

        DB::table('categories')->insert($categories);
    }
}
