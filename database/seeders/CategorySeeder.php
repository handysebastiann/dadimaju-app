<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Oli']);
        Category::create(['name' => 'Ban']);
        Category::create(['name' => 'Elektronik']);
        Category::create(['name' => 'Pengereman']);
        Category::create(['name' => 'Aksesoris']);
        Category::create(['name' => 'Alat']);
        Category::create(['name' => 'Bearing']);
        Category::create(['name' => 'Mesin']);
    }
}
