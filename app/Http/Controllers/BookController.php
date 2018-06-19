<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        return DB::table('books')->paginate(10);
//        return Book::all();
    }

    public function store(Request $request)
    {
        return Book::create($request->all());
    }

    public function show(Book $book)
    {
        return $book;
    }

    public function update(Request $request, Book $book)
    {
        $book->update($request->all());
        return $book;
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return $book;
    }
}
