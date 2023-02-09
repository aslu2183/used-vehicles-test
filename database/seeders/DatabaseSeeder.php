<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call(CategoryTableSeeder::class);
       $this->call(BrandTableSeeder::class);
       $this->call(ModelTableSeeder::class);
       $this->call(TrimTableSeeder::class);
    }
}
