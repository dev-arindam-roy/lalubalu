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
            ['id' => 1, 'name' => 'Labrador Retriever', 'status' => 1],
            ['id' => 2, 'name' => 'Beagle', 'status' => 1],
            ['id' => 3, 'name' => 'German Shepherd', 'status' => 1],
            ['id' => 4, 'name' => 'Great Dane', 'status' => 1],
            ['id' => 5, 'name' => 'Boxer', 'status' => 1],
            ['id' => 6, 'name' => 'Rottweiler', 'status' => 1],
            ['id' => 7, 'name' => 'Pug', 'status' => 1],
            ['id' => 8, 'name' => 'Golden Retriever', 'status' => 1],
            ['id' => 9, 'name' => 'Cocker Spaniel', 'status' => 1],
            ['id' => 10, 'name' => 'Dachshund', 'status' => 1],
            ['id' => 11, 'name' => 'Indian Spitz', 'status' => 1],
            ['id' => 12, 'name' => 'Pomeranian', 'status' => 1],
            ['id' => 13, 'name' => 'Tibetan Mastiff', 'status' => 1],
            ['id' => 14, 'name' => 'Dalmatian', 'status' => 1],
            ['id' => 15, 'name' => 'Bullmastiff', 'status' => 1],
            ['id' => 16, 'name' => 'English Mastiff', 'status' => 1]
        ]);
    }
}
