<?php

namespace Database\Seeders;

use App\Models\Trim;
use Illuminate\Database\Seeder;

class TrimTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trims = [
            ['name' => '4WD','model_id' => 4],
            ['name' => '2WD','model_id' => 4],
            ['name' => '4*4','model_id' => 4],
        ];

        foreach($trims as $trim){
            Trim::create($trim);
        }
    }
}
