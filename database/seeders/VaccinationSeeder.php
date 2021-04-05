<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dog_vaccination')->delete();
        DB::table('dog_vaccination')->insert([
            ['id' => 1, 'name' => 'Canine Parvovirus', 'status' => 1],
            ['id' => 2, 'name' => 'Canine Distemper', 'status' => 1],
            ['id' => 3, 'name' => 'Hepatitis', 'status' => 1],
            ['id' => 4, 'name' => 'Rabies', 'status' => 1],
            ['id' => 5, 'name' => 'Leptospirosis', 'status' => 1],
            ['id' => 6, 'name' => 'DHPP', 'status' => 1],
            ['id' => 7, 'name' => 'Bordetella', 'status' => 1],
            ['id' => 8, 'name' => 'Canine Influenza', 'status' => 1],
            ['id' => 9, 'name' => 'Lyme Disease', 'status' => 1],
            ['id' => 10, 'name' => 'Para Influenza', 'status' => 1]
        ]);
    }
}
