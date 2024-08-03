<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('recipes')->insert([
        //     [
        //         'title' => 'Test',
        //         'description' => 'Description',
        //         'image_url' => 'https://img.hellofresh.com/f_auto,fl_lossy,q_auto,w_1200/hellofresh_s3/image/66849ad89b6d1c18ac617ade-be6e7a75.jpeg',
        //         'url' => 'https://www.hellofresh.com.au/recipes/golden-haloumi-and-lime-couscous-66849ad89b6d1c18ac617ade',
        //         'content' => file_get_contents('https://www.hellofresh.com.au/recipes/golden-haloumi-and-lime-couscous-66849ad89b6d1c18ac617ade')
        //     ]
        // ]);
    }
}
