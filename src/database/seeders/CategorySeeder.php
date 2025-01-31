<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'Remessa Parcial'
        ]);
        DB::table('categories')->insert([
            'name' => 'Remessa'
        ]);

        /*
        \App\Models\Category::create([
            'name' => 'Remessa Parcial'
        ]);

        \App\Models\Category::create([
            'name' => 'Remessa'
        ]);
        */
    }
}
