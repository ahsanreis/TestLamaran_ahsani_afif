<?php

namespace Tests\Feature;

use App\Helpers;
use App\Models\Authors;
use App\Models\Books;
use Database\Seeders\AuthorsSeeder;
use Database\Seeders\BooksSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class BookTest extends TestCase
{
    public function testRegisterBookSuccess()
    {
        $this->seed([AuthorsSeeder::class]);
        $this->post('/api/books', [
            'title' => 'How To Read',
            'description' => 'Its book about how to read',
            'publish_date' => Helpers::stringToDate('1996-10-20')
        ])->assertStatus(200)->assertJson([
            'data' => [
                'title' => 'How To Read',
                'description' => 'Its book about how to read',
                'publish_date' => Helpers::stringToDate('1996-10-20')
            ]
        ]);
    }

    public function testRegisterBookValidationError()
    {
        $this->seed([AuthorsSeeder::class]);
        $this->post('/api/books', [
            'title' => '',
            'description' => 'Its book about how to read',
            'publish_date' => Helpers::stringToDate('1996-10-20')
        ])->assertStatus(400)->assertJson([
            'errors' => [
                'title' => [
                    'The title field is required.'
                ]
            ]
        ]);
    }

    public function testGetAllBooks()
    {
        $this->seed([AuthorsSeeder::class, BooksSeeder::class]);
        $this->get('/api/books')->assertStatus(200)->assertJson([
            'data' => [
                [
                    'title' => 'Lord Of the Rings',
                    'description' => "An epic high fantasy novel written by English author J. R. R. Tolkien",
                    'publish_date' => Helpers::stringToDate('2001-10-18')
                ]
            ]
        ]);
    }

    public function testGetBooksById()
    {
        $this->seed([AuthorsSeeder::class, BooksSeeder::class]);
        $book = Books::first();

        $this->get('/api/books/'. $book->id)->assertStatus(200)->assertJson([
            "data" => [
                'title' => 'Lord Of the Rings',
                'description' => 'An epic high fantasy novel written by English author J. R. R. Tolkien',
                'publish_date' => '2001-10-18'
            ]
        ]);
    }

    public function testGetBookByAuthorId()
    {
        $this->seed([AuthorsSeeder::class, BooksSeeder::class]);
        $author = Authors::first();

        $this->get('/api/authors/'.$author->id.'/books')
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'title' => 'Lord Of the Rings',
                    'description' => 'An epic high fantasy novel written by English author J. R. R. Tolkien',
                    'publish_date' => '2001-10-18'
                ]
            ]
        ]);
    }

    public function testGetBookByAuthorIdNotFound()
    {
        $this->seed([AuthorsSeeder::class, BooksSeeder::class]);
        $author = Authors::first();

        $this->get('/api/authors/'.($author->id + 4).'/books')
        ->assertStatus(404)
        ->assertJson([
            'errors' => [
                'messages' => [
                    'Author Not Found'
                ]
            ]
        ]);
    }

    public function testUpdateBookSuccess()
    {
        $this->seed([AuthorsSeeder::class, BooksSeeder::class]);
        $book = Books::first();

        $this->put('/api/books/'. $book->id, [
            'title' => 'How To Write',
            'description' => 'Its book about how to write',
            'publish_date' => Helpers::stringToDate('1996-10-20')
        ])->assertStatus(200)->assertJson([
            'data' => [
                'title' => 'How To Write',
                'description' => 'Its book about how to write',
                'publish_date' => Helpers::stringToDate('1996-10-20')
            ]
        ]);
    }

    public function testUpdateBookValidationFail()
    {
        $this->seed([AuthorsSeeder::class, BooksSeeder::class]);
        $book = Books::first();

        $this->put('/api/books/'. $book->id, [
            'title' => '',
            'description' => 'Its book about how to write',
            'publish_date' => Helpers::stringToDate('1996-10-20')
        ])->assertStatus(400)->assertJson([
            'errors' => [
                'title' => [
                    'The title field is required.'
                ]
            ]
        ]);
    }


    public function testUpdateBookNotFound()
    {
        $this->seed([AuthorsSeeder::class, BooksSeeder::class]);
        $book = Books::first();

        $this->put('/api/books/'. $book->id + 1, [
            'title' => 'How To Write',
            'description' => 'Its book about how to write',
            'publish_date' => Helpers::stringToDate('1996-10-20')
        ])->assertStatus(404)->assertJson([
            'errors' => [
                'messages' => [
                    'Book Not Found'
                ]
            ]
        ]);
    }

    public function testDeleteBook()
    {
        $this->seed([AuthorsSeeder::class, BooksSeeder::class]);
        $book = Books::first();

        $this->delete('/api/books/'.$book->id)
        ->assertStatus(200)
        ->assertJson([
            'data' => true,
        ]);
    }
}
