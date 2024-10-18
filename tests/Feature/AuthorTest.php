<?php

namespace Tests\Feature;

use App\Helpers;
use App\Models\Authors;
use Database\Seeders\AuthorsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    public function testRegisterAuthor()
    {
        $time = strtotime('10-07-2000');
        $format = date('Y-m-d', $time);
        $this->post('/api/authors', [
            'name' => 'Ahsani Afif',
            'bio' => "A Young man that passionate in software development and design",
            'dob' => $format
        ])->assertStatus(201)->assertJson([
            "data" => [
                'name' => 'Ahsani Afif',
                'bio' => "A Young man that passionate in software development and design",
                'dob' => $format
            ]
        ]);

    }
    public function testRegisterAuthorValidationError()
    {
        $time = strtotime('10-07-2000');
        $format = date('Y-m-d', $time);
        $this->post('/api/authors', [
            'name' => '',
            'bio' => "A Young man that passionate in software development and design",
            'dob' => $format
        ])->assertStatus(400)->assertJson([
            "errors" => [
                'name' => [
                    "The name field is required."
                ]
            ]
        ]);
    }

    public function testGetAllAuthors()
    {
        $this->seed([AuthorsSeeder::class]);
        $this->get('/api/authors')->assertStatus(200)->assertJson([
            "data" => [
                [
                    'name' => 'Geofrey Mccullagh',
                    'bio' => "Born in UK, Work As an Artist",
                    'dob' => Helpers::stringToDate('1996-10-20')
                ],
                [
                    'name' => 'Lampert Gibson',
                    'bio' => "Born in Hungary, Work As a software engineer",
                    'dob' => Helpers::stringToDate('1996-10-20')
                ]
            ]
        ]);
    }

    public function testGetSingleAuthorSuccess()
    {
        $this->seed([AuthorsSeeder::class]);
        $author = Authors::first();
        $this->get('/api/authors/'. $author->id)->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Geofrey Mccullagh',
                'bio' => 'Born in UK, Work As an Artist',
                'dob' => '1996-10-20'
            ]
            ]);
    }
    public function testGetSingleAuthorNotFound()
    {
        $this->seed([AuthorsSeeder::class]);
        $author = Authors::first();
        $this->get('/api/authors/'. $author->id + 2)->assertStatus(404)->assertJson([
            'errors' => [
                "messages" => [
                    "Author Not Found"
                ]
            ]
            ]);
    }
    public function testUpdateSingleAuthorSuccess()
    {
        $this->seed([AuthorsSeeder::class]);
        $author = Authors::first();
        $this->put('/api/authors/'. $author->id,[
            'name' => 'Geofrey Mccullagh',
            'bio' => 'Born in UK, Work As an Cruise Ship Captain',
            'dob' => '1996-10-20'
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Geofrey Mccullagh',
                'bio' => 'Born in UK, Work As an Cruise Ship Captain',
                'dob' => '1996-10-20'
            ]
        ]);

    }

    public function testUpdateSingleAuthorNotFound()
    {
        $this->seed([AuthorsSeeder::class]);
        $author = Authors::first();
        $this->put('/api/authors/'. $author->id + 4,[
            'name' => 'Geofrey Mccullagh',
            'bio' => 'Born in UK, Work As an Cruise Ship Captain',
            'dob' => '1996-10-20'
        ])->assertStatus(404)->assertJson([
            'errors' => [
                'messages' => [
                    'Author Not Found'
                ]
            ]
        ]);

    }
    public function testUpdateSingleAuthorValidationError()
    {
        $this->seed([AuthorsSeeder::class]);
        $author = Authors::first();
        $this->put('/api/authors/'. $author->id,[
            'name' => '',
            'bio' => 'Born in UK, Work As an Cruise Ship Captain',
            'dob' => '1996-10-20'
        ])->assertStatus(400)->assertJson([
            'errors' => [
                'name' => [
                    "The name field is required."
                ]
            ]
        ]);
    }

    public function testDeleteSingleAuthorSuccess()
    {
        $this->seed([AuthorsSeeder::class]);
        $author = Authors::first();
        $this->delete('/api/authors/'. $author->id, [] )->assertStatus(200)->assertJson([
            'data' => true
            ]);
    }

    public function testDeleteSingleAuthorNotFound()
    {
        $this->seed([AuthorsSeeder::class]);
        $author = Authors::first();
        $this->delete('/api/authors/'. $author->id + 3, [] )->assertStatus(404)->assertJson([
            'errors' => [
                'messages' => [
                    "Author Not Found"
                ]
            ]
        ]);
    }
}
