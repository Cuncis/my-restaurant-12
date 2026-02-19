<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'description' => 'Administrator with full access'],
            ['name' => 'Cashier', 'description' => 'Cashier with limited access'],
            ['name' => 'Chef', 'description' => 'Chef with access to kitchen operations'],
            ['name' => 'Customer', 'description' => 'Customer with access to order and view menu'],
        ];

        DB::table('roles')->insert($roles);
    }
}
