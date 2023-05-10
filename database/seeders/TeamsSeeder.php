<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            Team::insert([
                ['name' => 'Liverpool'],
                ['name' => 'Arsenal'],
                ['name' => 'Chelsea'],
                ['name' => 'Manchester City'],
            ]);
        });
    }
}
