<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRegisterRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Authors;
use App\Models\Books;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function addBook(BookRegisterRequest $request): JsonResponse {
        $data = $request->validated();

        $author = Authors::first();

        if (Books::where('title', $data['title'])->count() == 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'title' => [
                        'The title has already been taken.'
                    ]
                ]
            ], 400));
        }

        $book = new Books($data);
        $book->author_id = $author->id;
        $book->save();

        return response()->json([
            'data' => [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'publish_date' => $book->publish_date,
            ]
        ])->setStatusCode(200);
    }

    public function getBooks(): JsonResponse
    {
        $dataCollection = Books::all();

        $data[] =[];
        foreach ($dataCollection as $key => $value){
            $data[$key] = (object)[
                'id' => $value->id,
                'title' => $value->title,
                'description' => $value->description,
                'publish_date' => $value->publish_date,
            ];
        }

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function getBookById(int $id) : JsonResponse
    {
        $book = Books::where('id', $id)->first();

        if (!$book) {
            return response()->json(
                [
                    'errors' => [
                        "messages" => [
                            'Book Not Found'
                        ]
                    ]
                ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'publish_date' => $book->publish_date
            ]
        ], 200);
    }

    public function getBookByAuthorId(int $author_id): JsonResponse
    {
        $dataCollection = Books::where('author_id', $author_id)->get();
        $author = Authors::where('id', $author_id)->first();

        if (!$author) {
            return response()->json([
                'errors' => [
                    'messages' => [
                        'Author Not Found'
                    ]
                ]
            ], 404);
        }

        $data[] =[];
        foreach ($dataCollection as $key => $value){
            $data[$key] = (object)[
                'id' => $value->id,
                'title' => $value->title,
                'description' => $value->description,
                'publish_date' => $value->publish_date
            ];
        }

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function updateBookById(int $id, BookUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $book = Books::where('id', $id)->first();

        if (!$book) {
            return response()->json([
                'errors' => [
                    'messages' => [
                        'Book Not Found'
                    ]
                ]
            ], 404);
        }

        $book->fill($data);
        $book->save();

        return response()->json([
            'data' => [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'publish_date' => $book->publish_date
            ]
        ], 200);
    }

    public function deleteBook(int $id): JsonResponse
    {
        $book = Books::where('id', $id)->first();

        if (!$book) {
            return response()->json([
                'errors' => [
                    'messages' => [
                        'Book Not Found'
                    ]
                ]
            ]);
        }

        $book->delete();

        return response()->json([
            "data" => true
        ]);
    }
}
