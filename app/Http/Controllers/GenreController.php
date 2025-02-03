<?php

namespace App\Http\Controllers;

use App\Http\Requests\Genre\StoreGenreRequest;

use App\Models\Genre;


class GenreController extends Controller
{
    public function store(StoreGenreRequest $request)
    {
        $genre = Genre::create($request->only('name'));

        return response()->json([
            'message' => 'Genre created successfully.',
            'data' => $genre
        ]);
    }
}
