<?php

namespace Database\Seeders;

use App\Model\Catalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++) {
            DB::table('catalog')->insert([
                'name' => 'Fridge' . $i,
                'id_brand' => rand(1, 5),
                'id_category' => rand(1, 4),
                'id_availability' => rand(1, 3),
                'price' => rand(2000, 10000),
                'id_currency' => rand(1, 3),
            ]);
        }
    }
}
