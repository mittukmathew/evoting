<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Current timestamp
        $now = Carbon::now();

        // Insert candidates
        DB::table('candidates')->insert([
            [
                'name' => 'Candidate 1',
                'party' => 'Democratic Party',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Candidate 2',
                'party' => 'Republican Party',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Candidate 3',
                'party' => 'Independent',
                'created_at' => $now,
                'updated_at' => $now
            ]
           
        ]);
    }
}