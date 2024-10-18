<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRegisterRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Models\Authors;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function registerAuthor(AuthorRegisterRequest $request) : JsonResponse
    {
        $data = $request->validated();

        if (Authors::where('name', $data['name'])->count() == 1) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'name' => [
                        'The name has already been taken.'
                    ]
                ]
            ], 400));
        }

        $author = new Authors($data);
        $author->save();

        return response()->json([
            'data' => [
                'id' => $author->id,
                'name' => $author->name,
                'bio' => $author->bio,
                'dob' => $author->dob
            ]
        ], 201);
    }

    public function getAuthors(): JsonResponse
    {
        $dataCollection = Authors::all();

        $data[] = [];
        foreach ($dataCollection as $key => $value) {
            $data[$key] = (object)[
                'id' => $value->id,
                'name' => $value->name,
                'bio' => $value->bio,
                'dob' => $value->dob
            ];
        }
        return response()->json([
            'data' => $data
        ], 200);
    }

    public function getAuthorsById(int $id): JsonResponse
    {
        $author = Authors::where('id', $id)->first();

        if (!$author) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "messages" => [
                        "Author Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        return response()->json([
            'data' => [
                'id' => $author->id,
                'name' => $author->name,
                'bio' => $author->bio,
                'dob' => $author->dob,
            ]
        ]);
    }
    public function updateAuthorById(int $id, AuthorUpdateRequest $request): JsonResponse
    {
        $author = Authors::where('id', $id)->first();

        if (!$author) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "messages" => [
                        "Author Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $data = $request->validated();
        $author->fill($data);
        $author->save();

        return response()->json([
            'data' => [
                'name' => $author->name,
                'bio' => $author->bio,
                'dob' => $author->dob
            ]
        ])->setStatusCode(200);
    }

    public function deleteAuthor(int $id): JsonResponse
    {
        $author = Authors::where('id', $id)->first();

        if (!$author) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "messages" => [
                        "Author Not Found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $author->delete();
        return response()->json([
            'data' => true
        ])->setStatusCode(200);
    }
}
