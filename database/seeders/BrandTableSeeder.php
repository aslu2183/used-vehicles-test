<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['name' => 'AUDI','category_id' => 2],
            ['name' => 'BMW','category_id' => 2],
            ['name' => 'BENTLEY','category_id' => 2],
            ['name' => 'CHEVROLET','category_id' => 2],
            ['name' => 'DODGE','category_id' => 2],
        ];

        foreach($brands as $brand){
            Brand::create($brand);
        }
    }
}
