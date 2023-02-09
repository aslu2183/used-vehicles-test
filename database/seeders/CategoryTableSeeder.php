<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = [
            ['name' => 'Bike'],
            ['name' => 'Car'],
            ['name' => 'Truck'],
            ['name' => 'Bus']
        ];
        foreach($cats as $cat){
            Category::create($cat);
        }
    }
}
