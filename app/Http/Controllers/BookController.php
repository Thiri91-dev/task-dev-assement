<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\DestroyRequest;
use App\Http\Requests\Book\IndexRequest;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Services\Book\Destroy;
use App\Http\Services\Book\Index;
use App\Http\Services\Book\Store;
use App\Http\Services\Book\Update;
use App\Models\Book;
use App\Http\Requests\Genre\AddGenresToBookRequest;


class BookController extends Controller
{
    public function index(IndexRequest $request, Index $index)
    {
        return response()->json([
            'message' => 'Successfully fetched the books.',
            'data' => $index()
        ]);


        /* $query = Book::query();

         if ($request->has('search')) {
             $query->where('title', 'LIKE', '%' . $request->search . '%');
         }

         $books = $query->get();
         return view('books.index', compact('books'));*/
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    public function store(StoreRequest $request, Store $store)
    {
        $book = $store($request->validated());

        return response()->json([
            'message' => 'Successfully stored the book.',
            'data' => $book
        ]);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id); // Find the book by ID
        return response()->json($book);
    }

    public function update(UpdateRequest $request, Update $update, $id)
    {
        $bookToUpdate = Book::find($id);

        if (!$bookToUpdate) {
            \Log::error('Book not found!');
            return response()->json(['error' => 'Book not found'], 404);
        }

        \Log::info('Book before update:', $bookToUpdate->toArray());

        $updatedBook = $update($request->validated(), $bookToUpdate);

        return response()->json([
            'message' => 'Successfully updated the book.',
            'data' => $updatedBook
        ], 200);
    }


    public function destroy(DestroyRequest $request, Destroy $destroy, Book $book)
    {
        $book->delete();  // Soft delete the book

        return response()->json([
            'message' => 'Successfully deleted the book.',
        ]);
    }

    public function addGenres(Book $book, AddGenresToBookRequest $request)
    {
        $book->genres()->sync($request->genre_ids);

        return response()->json([
            'message' => 'Genres added to the book successfully.',
            'data' => $book->load('genres')
        ]);
    }
}
