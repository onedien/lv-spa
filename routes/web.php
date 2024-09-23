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
    $limit = $request->input('limit', 10);  // Default to 10 posts per page

    // Jika ada parameter search, lakukan pencarian berdasarkan judul
    if ($request->has('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Paginate based on limit
    return $query->paginate($limit);
});

Route::get('/posts/{id}', function ($id) {
    return Post::find($id);
});
