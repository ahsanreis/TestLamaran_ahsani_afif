<?php

namespace Database\Seeders;

use App\Helpers;
use App\Models\Authors;
use App\Models\Books;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = Authors::first();
        Books::create([
            'title' => 'Lord Of the Rings',
            'description' => "An epic high fantasy novel written by English author J. R. R. Tolkien",
            'publish_date' => Helpers::stringToDate('2001-10-18'),
            "author_id" => $author->id
        ]);
    }
}
