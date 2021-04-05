<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DogBreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dog_breeds')->delete();
        DB::table('dog_breeds')->insert([
            ['id' => 1, 'name' => 'Labradoe Retriever', 'status' => 1]
        ]);
    }
}
