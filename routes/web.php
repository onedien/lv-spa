<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Illuminate\Http\Request;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('blog');
});

Route::get('/posts', function (Request $request) {
    $query = Post::query();

    // Jika ada parameter search, lakukan pencarian berdasarkan judul
    if ($request->has('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Paginate hasil pencarian atau list biasa
    return $query->paginate(10);
});

Route::get('/posts/{id}', function ($id) {
    return Post::find($id);
});
