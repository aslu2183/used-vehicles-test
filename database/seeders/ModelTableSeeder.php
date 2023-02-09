<?php

namespace Database\Seeders;

use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

class ModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['name' => 'A8','brand_id' => 1],
            ['name' => 'X2','brand_id' => 2],
            ['name' => 'X7','brand_id' => 2],
            ['name' => 'X6','brand_id' => 2],
            ['name' => 'Azure','brand_id' => 3],
            ['name' => 'Camaro','brand_id' => 4],
            ['name' => 'VAN','brand_id' => 5],
           
        ];

        foreach($brands as $brand){
            VehicleModel::create($brand);
        }
    }
}
