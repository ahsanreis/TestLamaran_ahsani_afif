<?php

namespace Database\Seeders;

use App\Helpers;
use App\Models\Authors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Authors::create([
            'name' => 'Geofrey Mccullagh',
            'bio' => "Born in UK, Work As an Artist",
            'dob' => Helpers::stringToDate('1996-10-20')
        ]);
        Authors::create([
            'name' => 'Lampert Gibson',
            'bio' => "Born in Hungary, Work As a software engineer",
            'dob' => Helpers::stringToDate('1996-10-20')
        ]);
    }
}
