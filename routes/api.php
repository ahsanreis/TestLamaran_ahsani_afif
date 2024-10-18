<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/authors', [App\Http\Controllers\api\AuthorController::class, 'registerAuthor']);
Route::get('/authors', [App\Http\Controllers\api\AuthorController::class, 'getAuthors']);
Route::get('/authors/{id}', [\App\Http\Controllers\api\AuthorController::class, 'getAuthorsById'])->where('id', '[0-9]+');
Route::put('/authors/{id}', [\App\Http\Controllers\api\AuthorController::class, 'updateAuthorById'])->where('id', '[0-9]+');
Route::delete('/authors/{id}', [\App\Http\Controllers\api\AuthorController::class, 'deleteAuthor'])->where('id', '[0-9]+');

Route::post('/books', [App\Http\Controllers\api\BookController::class, 'addBook']);
Route::get('/books', [App\Http\Controllers\api\BookController::class, 'getBooks']);
Route::get('/books/{id}', [App\Http\Controllers\api\BookController::class, 'getBookById'])->where('id', '[0-9]+');
Route::put('/books/{id}', [App\Http\Controllers\api\BookController::class, 'updateBookById'])->where('id', '[0-9]+');
Route::delete('/books/{id}', [App\Http\Controllers\api\BookController::class, 'deleteBook'])->where('id', '[0-9]+');

Route::get('/authors/{author_id}/books', [\App\Http\Controllers\api\BookController::class, 'getBookByAuthorId'])->where('author_id', '[0-9]+');
