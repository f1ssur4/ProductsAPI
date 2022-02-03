<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('catalog')->insert([
            'name' => Str::random(10),
            'id_brand' => rand(1, 5),
            'id_category' => rand(1, 4),
            ''
        ]);
    }
}
